<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/sendEmail.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();
use PragmaRX\Google2FAQRCode\Google2FA;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì') ]));
    }
    if (isset($_POST['action']) && $_POST['action'] == 'ChangeProfile') {
        if ($CMSNT->site('status_demo') != 0) {
            $data = json_encode([
                'status'    => 'error',
                'msg'       => 'Không được dùng chức năng này vì đây là trang web demo'
            ]);
            die($data);
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['email'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập địa chỉ Email')]));
        }
        if (check_email($_POST['email']) == false) {
            die(json_encode(['status' => 'error', 'msg' => __('Định dạng Email không hợp lệ')]));
        }
        if(!empty($_POST['phone'])){
            if (isValidPhoneNumber($_POST['phone']) != true) {
                die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số điện thoại hợp lệ')]));
            }
        }
        $isUpdate = $CMSNT->update("users", [
            'email' => isset($_POST['email']) ? check_string($_POST['email']) : null,
            'fullname' => isset($_POST['fullname']) ? check_string($_POST['fullname']) : null,
            'phone' => isset($_POST['phone']) ? check_string($_POST['phone']) : null
        ], " `token` = '".check_string($_POST['token'])."' ");
        if ($isUpdate) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => __('Thay đổi thông tin hồ sơ')
            ]);
            die(json_encode(['status' => 'success', 'msg' => __('Lưu thành công')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('Lưu thất bại')]));
    }


    if (isset($_POST['action']) && $_POST['action'] == 'ChangePassword') {
        if ($CMSNT->site('status_demo') != 0) {
            $data = json_encode([
                'status'    => 'error',
                'msg'       => 'Không được dùng chức năng này vì đây là trang web demo'
            ]);
            die($data);
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['password'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mật khẩu hiện tại')]));
        }
        if (empty($_POST['newpassword'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mật khẩu mới')]));
        }
        if (empty($_POST['renewpassword'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Nhập lại mật khẩu không đúng')]));
        }
        if ($_POST['renewpassword'] != $_POST['newpassword']) {
            die(json_encode(['status' => 'error', 'msg' => __('Nhập lại mật khẩu không đúng')]));
        }
        $password = check_string($_POST['password']);
        if ($CMSNT->site('type_password') == 'bcrypt') {
            if (!password_verify($password, $getUser['password'])) {
                die(json_encode(['status' => 'error', 'msg' => __('Mật khẩu hiện tại không chính xác')]));
            }
        } else {
            if ($getUser['password'] != TypePassword($password)) {
                die(json_encode(['status' => 'error', 'msg' => __('Mật khẩu hiện tại không chính xác')]));
            }
        }
        $isUpdate = $CMSNT->update("users", [
            'change_password'   => 1,
            'password'  => isset($_POST['newpassword']) ? TypePassword(check_string($_POST['newpassword'])) : null,
            'token'     => md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 6).time())
        ], " `token` = '".check_string($_POST['token'])."' ");
        if ($isUpdate) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => __('Thay đổi mật khẩu')
            ]);
            die(json_encode(['status' => 'success', 'msg' => __('Đổi mật khẩu thành công')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('Đổi mật khẩu thất bại')]));
    }

    if (isset($_POST['action']) && $_POST['action'] == 'ChangeGoogle2FA') {
        if ($CMSNT->site('status_demo') != 0) {
            $data = json_encode([
                'status'    => 'error',
                'msg'       => 'Không được dùng chức năng này vì đây là trang web demo'
            ]);
            die($data);
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['secret'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mã xác minh 2FA')]));
        }
        $google2fa = new Google2FA();
        if ($google2fa->verifyKey($getUser['SecretKey_2fa'], check_string($_POST['secret']), 2) != true) {
            die(json_encode(['status' => 'error', 'msg' => __('Mã xác minh không chính xác')]));
        }
        $isUpdate = $CMSNT->update("users", [
            'status_2fa' => isset($_POST['status_2fa']) ? check_string($_POST['status_2fa']) : 0
        ], " `token` = '".check_string($_POST['token'])."' ");
        if ($isUpdate) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => __('Thay đổi trạng thái Google 2FA')
            ]);
            die(json_encode(['status' => 'success', 'msg' => __('Lưu thành công')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('Lưu thất bại')]));
    }

    if (isset($_POST['action']) && $_POST['action'] == 'VerifyGoogle2FA') {
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token_2fa` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['code'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mã xác minh')]));
        }
        if($getUser['limit_2fa'] >= 5){
            $CMSNT->update("users", [
                'limit_2fa' => 0,
                'token_2fa' => NULL
            ], " `id` = '".$getUser['id']."' ");
            // banned ip nếu sai 2fa quá 5 lần
            $CMSNT->insert('banned_ips', [
                'ip'                => myip(),
                'attempts'          => $getUser['limit_2fa'],
                'create_gettime'    => gettime(),
                'banned'            => 1,
                'reason'            => 'Input the wrong 2FA code many times'
            ]);
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã nhập sai quá nhiều lần, vui lòng xác minh lại từ đầu')]));
        }
        $google2fa = new Google2FA();
        if ($google2fa->verifyKey($getUser['SecretKey_2fa'], check_string($_POST['code']), 2) != true) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => '[Warning] Phát hiện có người đang cố gắng nhập mã xác minh 2FA'
            ]);
            $CMSNT->cong('users', 'limit_2fa', 1, " `id` = '".$getUser['id']."' ");
            die(json_encode(['status' => 'error', 'msg' => __('Mã xác minh không chính xác')]));
        }
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => __('Đăng nhập thành công vào hệ thống')
        ]);
        $CMSNT->update("users", [
            'token_2fa' => NULL,
            'ip' => myip(),
            'time_session' => time(),
            'device' => $Mobile_Detect->getUserAgent()
        ], " `id` = '".$getUser['id']."' ");
        setcookie("token", $getUser['token'], time() + $CMSNT->site('session_login'), "/");
        $_SESSION['login'] = $getUser['token'];
        die(json_encode([
            'status' => 'success',
            'msg'    => __('Đăng nhập thành công')
        ]));
    }

    if (isset($_POST['action']) && $_POST['action'] == 'VerifyOTPMail') {
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `otp_token` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['code'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mã xác minh')]));
        }
        if ($getUser['otp'] == NULL) {
            die(json_encode(['status' => 'error', 'msg' => __('OTP không đúng')]));
        }
        if($getUser['otp_limit'] >= 5){
            $CMSNT->update("users", [
                'otp' => NULL,
                'otp_limit' => 0,
                'otp_token' => NULL
            ], " `id` = '".$getUser['id']."' ");
            // banned ip nếu sai otp quá 5 lần
            $CMSNT->insert('banned_ips', [
                'ip'                => myip(),
                'attempts'          => $getUser['otp_limit'],
                'create_gettime'    => gettime(),
                'banned'            => 1,
                'reason'            => 'Input the wrong OTP Mail code many times'
            ]);
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã nhập sai quá nhiều lần, vui lòng xác minh lại từ đầu')]));
        }
        if ($getUser['otp'] != check_string($_POST['code'])) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => '[Warning] Phát hiện có người đang cố gắng nhập OTP Mail'
            ]);
            $CMSNT->cong('users', 'otp_limit', 1, " `id` = '".$getUser['id']."' ");
            die(json_encode(['status' => 'error', 'msg' => __('OTP không đúng')]));
        }
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => __('Đăng nhập thành công vào hệ thống')
        ]);
        $CMSNT->update("users", [
            'otp' => NULL,
            'otp_limit' => 0,
            'otp_token' => NULL,
            'ip' => myip(),
            'time_session' => time(),
            'device' => $Mobile_Detect->getUserAgent()
        ], " `id` = '".$getUser['id']."' ");
        
        setcookie("token", $getUser['token'], time() + $CMSNT->site('session_login'), "/");
        $_SESSION['login'] = $getUser['token'];
        die(json_encode([
            'status' => 'success',
            'msg'    => __('Đăng nhập thành công')
        ]));
    }


}
