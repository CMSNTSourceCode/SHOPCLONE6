<?php

define("IN_SITE", true);
require_once(__DIR__.'/libs/db.php');
require_once(__DIR__.'/config.php');
require_once(__DIR__.'/libs/helper.php');
//require_once(__DIR__.'/models/is_admin.php');
$CMSNT = new DB();


$whitelist = array(
    '127.0.0.1',
    '::1'
);
if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    die('Localhost không thể sử dụng chức năng này');
}
if ($CMSNT->site('status_update') == 1) {
    if ($config['version'] != file_get_contents('http://api.cmsnt.co/version.php?version=SHOPCLONE6')) {
        //CONFIG THÔNG SỐ
        define('filename', 'update_'.random('ABC123456789', 6).'.zip');
        define('serverfile', 'http://api.cmsnt.co/shopclone62Fx52sdfg.zip');
        // TIẾN HÀNH TẢI BẢN CẬP NHẬT TỪ SERVER VỀ
        file_put_contents(filename, file_get_contents(serverfile));
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
            $query = file_get_contents(BASE_URL('install.php'));
            // XÓA FILE INSTALL DATABASE
            if ($query) {
                unlink('install.php');
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
