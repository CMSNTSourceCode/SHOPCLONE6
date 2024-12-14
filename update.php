<?php

define("IN_SITE", true);
require_once(__DIR__.'/libs/db.php');
require_once(__DIR__.'/config.php');
require_once(__DIR__.'/libs/helper.php');
//require_once(__DIR__.'/models/is_admin.php');
$CMSNT = new DB();

function curl_get_contents($url) {
    // Initialize a cURL session
    $ch = curl_init();
    // Set the URL to fetch
    curl_setopt($ch, CURLOPT_URL, $url);
    // Set the timeout for the request
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    // Return the transfer as a string instead of outputting it directly
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Optional: Set a user-agent to mimic a browser request
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
    // Optional: Follow redirects (HTTP 3xx responses)
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // Execute the request and store the result
    $result = curl_exec($ch);
    // Check for errors
    if (curl_errno($ch)) {
        // If there's an error, return false
        $result = false;
    }
    // Close the cURL session
    curl_close($ch);
    return $result;
}

$whitelist = array(
    '127.0.0.1',
    '::1'
);

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 


if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    die('Localhost không thể sử dụng chức năng này');
}
if ($CMSNT->site('status_update') == 1) {
    if ($config['version'] != curl_get_contents('http://api.cmsnt.co/version.php?version=SHOPCLONE6')) {
        //CONFIG THÔNG SỐ
        define('filename', 'update_'.random('ABC123456789', 6).'.zip');
        define('serverfile', 'http://api.cmsnt.co/shopclone62Fx52sdfg.zip');
        // TIẾN HÀNH TẢI BẢN CẬP NHẬT TỪ SERVER VỀ
        file_put_contents(filename, curl_get_contents(serverfile));
        // TIẾN HÀNH GIẢI NÉN BẢN CẬP NHẬT VÀ GHI ĐÈ VÀO HỆ THỐNG
        $file = filename;
        $path = pathinfo(realpath($file), PATHINFO_DIRNAME);
        $zip = new ZipArchive();
        $res = $zip->open($file);
        if ($res === true) {
            $zip->extractTo($path);
            $zip->close();
            // XÓA FILE ZIP CẬP NHẬT TRÁNH TỤI KHÔNG MUA ĐÒI XÀI FREE
            unlink(filename);
            // TIẾN HÀNH INSTALL DATABASE MỚI
            $query = file_get_contents(BASE_URL('install.php'), false, stream_context_create($arrContextOptions));
            // XÓA FILE INSTALL DATABASE
            if ($query) {
                //unlink('install.php');
            }
            // GHI LOG
            $file = @fopen('Update.txt', 'a');
            if ($file) {
                $data = "[UPDATE] Phiên cập nhật phiên bản gần nhất vào lúc ".gettime().PHP_EOL;
                fwrite($file, $data);
                fclose($file);
            }
            die('Cập nhật thành công!');
        } else {
            die('Cập nhật thất bại!');
        }
    }
    die('Không có phiên bản mới nhất');
} else {
    die('Chức năng cập nhật tự động đang được tắt');
}
