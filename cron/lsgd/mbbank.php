<?php
define("IN_SITE", true);
    require_once(__DIR__.'/../../libs/db.php');
    require_once(__DIR__.'/../../config.php');
    require_once(__DIR__.'/../../libs/helper.php');
    require_once(__DIR__.'/../../libs/database/users.php');
    require_once(__DIR__.'/../../libs/database/invoices.php');
    $CMSNT = new DB();
    $user = new users();
    queryCancelInvoices();
    
    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_mbbank')) {
        if (time() - $CMSNT->site('check_time_cron_mbbank') < 15) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", ['value' => time()], " `name` = 'check_time_cron_mbbank' ");
    /* END CHỐNG SPAM */
$type = 1; // 1 là check theo lịch sử giao dịch, 0 là check theo noti
if ($CMSNT->site('type_bank') == 'MBBank' && $CMSNT->site('token_bank') != '' && $CMSNT->site('status_bank') == 1) {
    // $token = $CMSNT->site('token_bank');
    // $stk = $CMSNT->site('stk_bank');
    // $mk = $CMSNT->site('mk_bank');
    $mbbank = new MBBANK ($token, $mk);
    $login = $mbbank->login();
	$lsgd = $mbbank->LSGD ($stk); // lịch sử giao dịch theo stk
	$full = array (
				"status" => "true",
				"message" => "Thành Công",
				"transactionHistoryList" => $lsgd
	);
    $result = $full;
    foreach ($result['transactionHistoryList'] as $data) {
        $tid            = check_string($data['refNo']);
        $description    = check_string($data['description']);
        $amount         = check_string($data['creditAmount']);
        $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
        // XỬ LÝ AUTO SERVER 2
        if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
            if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid'  ") == 0){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `description` = '$description' ") == 0){
                        $insertSv2 = $CMSNT->insert("server2_autobank", array(
                            'tid'               => $tid,
                            'user_id'           => $getUser['id'],
                            'description'       => $description,
                            'amount'            => $amount,
                            'received'          => checkPromotion($amount),
                            'create_gettime'    => gettime(),
                            'create_time'       => time()
                        ));
                        if ($insertSv2){
                            $received = checkPromotion($amount);
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua MBBank (#$tid - $description - $amount)");
                            if($isCong){
                                /** SEND NOTI CHO ADMIN */
                                $my_text = $CMSNT->site('naptien_notification');
                                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                $my_text = str_replace('{method}', 'MBBank - Server 2', $my_text);
                                $my_text = str_replace('{amount}', format_cash($amount), $my_text);
                                $my_text = str_replace('{price}', format_currency($received), $my_text);
                                $my_text = str_replace('{time}', gettime(), $my_text);
                                sendMessAdmin($my_text);
                                echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                            }
                        }
                    }
                }
            }
        }
        // XỬ LÝ AUTO SERVER 1
        if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
            continue;
        }
        foreach (whereInvoicePending('MBBank', $amount) as $row) {
            if($row['description'] == $description && $row['tid'] == $tid){
                continue;
            }
            if (isset(explode($row['trans_id'], strtoupper($description))[1])) {
                $isUpdate = $CMSNT->update("invoices", [
                    'status'        => 1,
                    'description'   => $description,
                    'tid'           => $tid,
                    'update_date'   => gettime(),
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' ");
                if($isUpdate){
                    $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id']);
                    if (!$isCong) {
                        $CMSNT->update("invoices", [
                        'status'  => 0
                        ], " `id` = '".$row['id']."' ");
                    }
                    /** SEND NOTI CHO ADMIN */
                    $my_text = $CMSNT->site('naptien_notification');
                    $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                    $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                    $my_text = str_replace('{method}', 'MBBank - Server 1', $my_text);
                    $my_text = str_replace('{amount}', format_cash($row['pay']), $my_text);
                    $my_text = str_replace('{price}', format_currency($row['amount']), $my_text);
                    $my_text = str_replace('{time}', gettime(), $my_text);
                    sendMessAdmin($my_text);
                    echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                }
                break;
            }
        }
    }
    die();
}

class MBBANK {
    private $softTokenId_goc = "bfc0c155-00c1-478b-9a4c-ee35e41f52e5";
    private $deviceId_goc = "c58c7339-97c2-ebdb-8400-573696596480";
    private $deviceIdCommon_goc = "c58c7339-97c2-ebdb-8400-573696596480";
    private $useragent = "Mozilla/5.0 (Linux; Android 7.1.2; ASUS_Z01QD Build/N2G48H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.120 Mobile Safari/537.36";
    private $URL = array (
        "LOGIN" => "https://mobile.mbbank.com.vn/retail_lite/common/activeDevice",
        "getBalance" => "https://mobile.mbbank.com.vn/retail_lite/account/v2.0/getBalance",
        "INFO" => "https://mobile.mbbank.com.vn/retail_lite/loan/getUserInfo",
        "GET_TOKEN" => "https://mobile.mbbank.com.vn/retail_lite/loyal/getToken",
        "GET_NOTI" => "https://mobile.mbbank.com.vn/retail_lite/notification/getNotificationDataList",
        "GET_TRANS" => "https://mobile.mbbank.com.vn/retail-transactionservice/transaction/getTransactionAccountHistory"
    );
    public function __construct ($user, $pass) {
        $this->user = $user;
        $this->pass = $pass;
        return $this;
    }
    public function login () {
        $header = array (
            "Host: mobile.mbbank.com.vn",
            "User-Agent: ".$this->useragent,
            "Cache-Control: no-cache",
            "Authorization: Basic QURNSU46QURNSU4=",
            "Connection: close"
        );

        $softTokenId = $this->softTokenId_goc;
        $deviceId = $this->deviceId_goc;
        $deviceIdCommon = $this->deviceIdCommon_goc;
        $data = '{
            "refNo":"0792623572-202241484355267243",
            "userId":"'.$this->user.'",
            "password":"'.md5($this->pass).'",
            "softTokenId":"'.$softTokenId.'",
            "deviceId":"'.$deviceId.'",
            "deviceIdCommon":"'.$deviceIdCommon.'",
            "appVersion":"android_13.1_v482"
        }';
        $result = $this->CURL("LOGIN", $header, $data);
        if ($result["result"]["message"] == "Customer is invalid" || $result["result"]["ok"] == false) {
            return array(
                "status" => "error",
                "code" => 500,
                "message" => "Tên Đăng Nhập Hoặc Mật Khẩu Sai"
            );
        } else {
        	$this->acct_list = $result["cust"]["acct_list"];
            $this->refNo = $result["refNo"];
            $this->sessionId = $result["sessionId"];
            return $result;
        }
    }
    public function notify () {
        $header = array (
            "Host:mobile.mbbank.com.vn",
            "User-Agent:".$this->useragent,
            "Cache-Control: no-cache",
            "Authorization: Basic QURNSU46QURNSU4=",
            "Connection: close",
        );
        $data = '{
            "refNo":"'.$this->refNo.'",
            "sessionId":"'.$this->sessionId.'",
            "fromRows":0,
            "toRows":20,
            "deviceIdCommon":"'.$this->deviceIdCommon_goc.'",
            "appVersion":"android_13.1_v482"
        }';
		return $this->CURL("GET_NOTI", $header, $data);
    }
	public function xuly_notify($thongbao){
    	$notify= $thongbao["notificationBusinessList"];
    	$list = [];
		for ($i = 0; $i < count($notify); $i++){
			$data = $notify[$i];
			if ($data["notiType"] == "MSG_NOTI_BDSD_T24_CHUDONG"){
				$text = $data["body"];
				$taikhoan = explode('TK ', explode ('|', $text)[0])[1];
				$info = explode ('|', $text)[1];
				$tach = explode (' ', $info);
				$biendong = $tach[1];
				$deviant = str_replace(array('+', '-'), array('', ''), explode ('VND', $biendong)[0]);
				$time = $tach[2]." ".$tach[3].":00";
				$vnd = explode ('|', $text)[2];
				$sodu = explode ('VND', explode ('SD:', $text)[1])[0];
				$config = explode ('|', $text)[3];
				array_push($list, array(
					"accountNo" => $taikhoan, #tài khoản
					"transactionId" => $data["notiId"], #mã giao dịch
					"creditAmount" => str_replace(array(',', '.'), array('', ''), $deviant), #số tiền giao dịch
					"type" => $biendong[0], #1 = cộng tiền, -1 = trừ tiền
					"currency" => "VND",
					"transactionDate" => $time, #thời gian
					"availableBalance" => $sodu, #số dư
					"description" => $config #nội dung giao dịch
				));
			}
		}
		return $list;
	}
    public function balance () {
        $header = array (
            "Host:mobile.mbbank.com.vn",
            "User-Agent:".$this->useragent,
            "Cache-Control: no-cache",
            "Authorization: Basic QURNSU46QURNSU4=",
            "Connection: close",
        );
        $data = '{
            "sessionId":"'.$this->sessionId.'",
            "refNo":"'.$this->refNo.'",
            "type":"",
            "deviceIdCommon":"'.$this->deviceIdCommon_goc.'",
            "appVersion":"android_13.1_v482"
        }';
        return $this->CURL("getBalance", $header, $data);
    }
    public function LSGD ($accountNo) {
    	if(!isset($this->acct_list[$accountNo])){
    		return array(
				'status' => 'error',
				'code' => 404,
				'message' => 'Không Tìm Thấy account'
			);
		}
    	date_default_timezone_set('Asia/Ho_Chi_Minh');
        $header = array (
            "Host:mobile.mbbank.com.vn",
            "User-Agent:".$this->useragent,
            "Cache-Control: no-cache",
            "Authorization: Basic QURNSU46QURNSU4=",
            "Connection: close",
        );
        $today = date('d/m/Y');
        $data = '{
            "refNo":"'.$this->refNo.'",
            "sessionId":"'.$this->sessionId.'",
            "fromDate":"'.$today.'",
            "toDate":"'.$today.'",
            "accountNo":"'.$accountNo.'",
            "deviceIdCommon":"'.$this->deviceIdCommon_goc.'",
            "appVersion":"android_13.1_v482"
        }';
        $result = $this->CURL("GET_TRANS", $header, $data);
        if($result["result"]["message"] == 'OK'){
        	$lsgd = $result["transactionHistoryList"];
            return $lsgd;
        } else {
        	return array(
        		'status' => 'error',
				'code' => 301,
				'message' => 'Không Tìm Thấy Lịch Sử Giao Dịch'
        	);
        }
    }
    private function CURL($Action,$header,$data) {
        $Data = is_array($data) ? json_encode($data) : $data;
        $curl = curl_init();
        $header[] = 'Content-Type: application/json; charset=utf-8';
        $header[] = 'accept: application/json';
        $header[] = 'Content-Length: '.strlen($Data);
        $opt = array(
            CURLOPT_URL =>$this->URL[$Action],
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => empty($data) ? FALSE : TRUE,
            CURLOPT_POSTFIELDS => $Data,
            CURLOPT_CUSTOMREQUEST => empty($data) ? 'GET' : 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_COOKIEJAR => "mb.txt",
			CURLOPT_COOKIEFILE => "mb.txt",
            CURLOPT_HEADER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => 20,
        );
        curl_setopt_array($curl,$opt);
        $body = curl_exec($curl);
        if(is_object(json_decode($body))){
            return json_decode($body,true);
        }
        return json_decode($body,true);
    }
}