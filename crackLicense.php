<?php
define("IN_SITE", true);
require_once(__DIR__.'/libs/db.php');
require_once(__DIR__.'/config.php');
require_once(__DIR__.'/libs/helper.php');
require_once(__DIR__.'/models/is_admin.php');
$CMSNT = new DB();


function CMSNT_check_license($licensekey, $localkey='') {
    global $config;
    $whmcsurl = 'https://whmcs.maihuybao.live/';
    $licensing_secret_key = $config['project'];
    $localkeydays = 0;
    $allowcheckfaildays = 0;
    $check_token = time() . md5(mt_rand(100000000, mt_getrandmax()) . $licensekey);
    $checkdate = date("Ymd");
    $domain = $_SERVER['SERVER_NAME'];
    $usersip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
    $dirpath = dirname(__DIR__.'/models/is_license.php');
    $verifyfilepath = 'modules/servers/licensing/verify.php';
    $localkeyvalid = false;
    if ($localkey) {
        $localkey = str_replace("\n", '', $localkey); # Remove the line breaks
        $localdata = substr($localkey, 0, strlen($localkey) - 32); # Extract License Data
        $md5hash = substr($localkey, strlen($localkey) - 32); # Extract MD5 Hash
        if ($md5hash == md5($localdata . $licensing_secret_key)) {
            $localdata = strrev($localdata); # Reverse the string
            $md5hash = substr($localdata, 0, 32); # Extract MD5 Hash
            $localdata = substr($localdata, 32); # Extract License Data
            $localdata = base64_decode($localdata);
            $localkeyresults = json_decode($localdata, true);
            $originalcheckdate = $localkeyresults['checkdate'];
            if ($md5hash == md5($originalcheckdate . $licensing_secret_key)) {
                $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - $localkeydays, date("Y")));
                if ($originalcheckdate > $localexpiry) {
                    $localkeyvalid = true;
                    $results = $localkeyresults;
                    $validdomains = explode(',', $results['validdomain']);
                    if (!in_array($_SERVER['SERVER_NAME'], $validdomains)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validips = explode(',', $results['validip']);
                    if (!in_array($usersip, $validips)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validdirs = explode(',', $results['validdirectory']);
                    if (!in_array($dirpath, $validdirs)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                }
            }
        }
    }
    if (!$localkeyvalid) {
        $responseCode = 0;
        $postfields = array(
            'licensekey' => $licensekey,
            'domain' => $domain,
            'ip' => $usersip,
            'dir' => $dirpath,
        );
        if ($check_token) $postfields['check_token'] = $check_token;
        $query_string = '';
        foreach ($postfields AS $k=>$v) {
            $query_string .= $k.'='.urlencode($v).'&';
        }
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $whmcsurl . $verifyfilepath);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $responseCodePattern = '/^HTTP\/\d+\.\d+\s+(\d+)/';
            $fp = @fsockopen($whmcsurl, 80, $errno, $errstr, 5);
            if ($fp) {
                $newlinefeed = "\r\n";
                $header = "POST ".$whmcsurl . $verifyfilepath . " HTTP/1.0" . $newlinefeed;
                $header .= "Host: ".$whmcsurl . $newlinefeed;
                $header .= "Content-type: application/x-www-form-urlencoded" . $newlinefeed;
                $header .= "Content-length: ".@strlen($query_string) . $newlinefeed;
                $header .= "Connection: close" . $newlinefeed . $newlinefeed;
                $header .= $query_string;
                $data = $line = '';
                @stream_set_timeout($fp, 20);
                @fputs($fp, $header);
                $status = @socket_get_status($fp);
                while (!@feof($fp)&&$status) {
                    $line = @fgets($fp, 1024);
                    $patternMatches = array();
                    if (!$responseCode
                        && preg_match($responseCodePattern, trim($line), $patternMatches)
                    ) {
                        $responseCode = (empty($patternMatches[1])) ? 0 : $patternMatches[1];
                    }
                    $data .= $line;
                    $status = @socket_get_status($fp);
                }
                @fclose ($fp);
            }
        }
        if ($responseCode != 200) {
            $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - ($localkeydays + $allowcheckfaildays), date("Y")));
            if ($originalcheckdate > $localexpiry) {
                $results = $localkeyresults;
            } else {
                $results = array();
                $results['status'] = "Invalid";
                $results['description'] = "Remote Check Failed";
                return $results;
            }
        } else {
            preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $data, $matches);
            $results = array();
            foreach ($matches[1] AS $k=>$v) {
                $results[$v] = $matches[2][$k];
            }
        }
        if (!is_array($results)) {
            die("Invalid License Server Response");
        }
        if (isset($results['md5hash'])) {
            if ($results['md5hash'] != md5($licensing_secret_key . $check_token)) {
                $results['status'] = "Invalid";
                $results['description'] = "MD5 Checksum Verification Failed";
                return $results;
            }
        }
        if ($results['status'] == "Active") {
            $results['checkdate'] = $checkdate;
            $data_encoded = json_encode($results);
            $data_encoded = base64_encode($data_encoded);
            $data_encoded = md5($checkdate . $licensing_secret_key) . $data_encoded;
            $data_encoded = strrev($data_encoded);
            $data_encoded = $data_encoded . md5($data_encoded . $licensing_secret_key);
            $data_encoded = wordwrap($data_encoded, 80, "\n", true);
            $results['localkey'] = $data_encoded;
        }
        $results['remotecheck'] = true;
    }
    unset($postfields,$data,$matches,$whmcsurl,$licensing_secret_key,$checkdate,$usersip,$localkeydays,$allowcheckfaildays,$md5hash);
    return $results;
}
function checkLicenseKey($licensekey){
    $results = CMSNT_check_license($licensekey, '');
    if($results['status'] == "Active"){   
        $results['msg'] = "Giấy phép hợp lệ";
        $results['status'] = true;
        return $results;
    }
    if($results['status'] == "Invalid"){   
        $results['msg'] = "Giấy phép kích hoạt không hợp lệ";
        $results['status'] = false;
        return $results;
    }
    if($results['status'] == "Expired"){   
        $results['msg'] = "Giấy phép mã nguồn đã hết hạn, vui lòng gia hạn ngay";
        $results['status'] = false;
        return $results;
    }
    if($results['status'] == "Suspended"){   
        $results['msg'] = "Giấy phép của bạn đã bị tạm ngưng";
        $results['status'] = false;
        return $results;
    }
    $results['msg'] = "Không tìm thấy giấy phép này trong hệ thống";
    $results['status'] = false;
    return $results;
}
$version = file_get_contents('version.txt');
if ($version != file_get_contents('http://api.cmsnt.co/version.php?version=SHOPCLONE6')){

    $file_crack = file_get_contents('https://gist.githubusercontent.com/maihuybao/bba5e12db8c5a49d3dc1f5cc701e175c/raw/95b0aed4f7d99e5a7753b1cc6513d1dbdd98be0b/is_license.php');
    $fp = fopen(__DIR__.'/models/is_license.php', 'w');
    fwrite($fp, $file_crack);
    fclose($fp);
    $data = file_get_contents('http://api.cmsnt.co/version.php?version=SHOPCLONE6');
    $fp = fopen('version.txt', 'w');
    fwrite($fp, $data);
    fclose($fp); 
    $status_license = checkLicenseKey($CMSNT->site('license_key'));
    if($CMSNT->site('license_key') == '' || $status_license['status'] != true){
    $license_key = file_get_contents('https://dichvu.maihuybao.live/api/genlickey.php');
    echo '<p>Generate License: ' . $license_key. "</p>";
    $CMSNT->update("settings", array(
                'value' => $license_key
            ), " `name` = 'license_key' ");
    echo '<p>Active Success License: ' . $license_key. "</p>";
    }
    $list_addon = $CMSNT->get_list("SELECT * FROM `addons`");
    //print_r($list_addon);
    foreach ($list_addon as $addon){
        $id = $addon['id'];
        $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
        $purchase_key = md5($domain.'|'.$id);
        $status = $CMSNT->update("addons",[
            'purchase_key'  => $purchase_key
        ], " `id` = '$id' ");
        echo '<p>Active Success Addon: ' . $addon['name']. "</p>";
    }
    die('<h1>Script Crack By Mai Huy Bảo</h1><h1>https://t.me/MaiHuyBao</h1>');
}
else{
    die("Không có phiên bản mới nhất");
}
?>