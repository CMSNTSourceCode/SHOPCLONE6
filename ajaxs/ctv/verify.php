<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();
use PragmaRX\Google2FAQRCode\Google2FA;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'VerifyGoogle2FA') {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Chức năng này đã bị đóng, vui lòng đăng nhập bằng trang khách'
        ]));
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `ctv` = 1 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['code'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mã xác minh')]));
        }
        $google2fa = new Google2FA();
        if ($google2fa->verifyKey($getUser['SecretKey_2fa'], check_string($_POST['code']), 2) != true) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => '[Warning] Phát hiện có người đang cố gắng nhập mã xác minh'
            ]);
            die(json_encode(['status' => 'error', 'msg' => __('Mã xác minh không chính xác')]));
        }
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Đăng nhập thành công vào hệ thống CTV.'
        ]);
        $CMSNT->update("users", [
            'ip' => myip(),
            'device' => $Mobile_Detect->getUserAgent()
        ], " `id` = '".$getUser['id']."' ");
        setcookie("token", $getUser['token'], time() + $CMSNT->site('session_login'), "/");
        $_SESSION['ctv_login'] = $getUser['token'];
        die(json_encode([
            'status' => 'success',
            'msg' => 'Đăng nhập thành công!'
        ]));
    }
}
