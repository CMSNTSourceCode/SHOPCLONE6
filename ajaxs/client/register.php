<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/lang.php");
use PragmaRX\Google2FA\Google2FA;

$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if (empty($_POST['username'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Username không được để trống')]));
    }
    if (empty($_POST['email'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Email không được để trống')]));
    }
    if (empty($_POST['password'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Mật khẩu không được để trống')]));
    }
    if (empty($_POST['repassword'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Nhập lại mật khẩu không đúng')]));
    }
    $username = check_string($_POST['username']);
    $email = check_string($_POST['email']);
    $password = check_string($_POST['password']);
    $repassword = check_string($_POST['repassword']);
    if ($password != $repassword) {
        die(json_encode(['status' => 'error', 'msg' => __('Nhập lại mật khẩu không đúng')]));
    }
    if (check_email($email) != true) {
        die(json_encode(['status' => 'error', 'msg' => __('Định dạng Email không đúng')]));
    }
    // if ($CMSNT->site('status_captcha') == 1) {
    //     $phrase = check_string($_POST['phrase']);
    //     if (strcasecmp($phrase, $_SESSION['phrase']) != 0) {
    //         die(json_encode(['status' => 'error', 'msg' => __('Captcha không chính xác')]));
    //     }
    // }
    if($CMSNT->site('reCAPTCHA_status') == 1){
        if (empty($_POST['recaptcha'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng xác minh Captcha')]));
        }
        $recaptcha = check_string($_POST['recaptcha']);
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$CMSNT->site('reCAPTCHA_secret_key')."&response=$recaptcha";
        $verify = file_get_contents($url);
        $captcha_success=json_decode($verify);
        if ($captcha_success->success==false) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng xác minh Captcha')]));
        }
    }
    if ($CMSNT->num_rows("SELECT * FROM `users` WHERE `username` = '$username' ") > 0) {
        die(json_encode(['status' => 'error','msg' => __('Tên đăng nhập đã tồn tại trong hệ thống')]));
    }
    if ($CMSNT->num_rows("SELECT * FROM `users` WHERE `email` = '$email' ") > 0) {
        die(json_encode(['status' => 'error', 'msg' => __('Địa chỉ email đã tồn tại trong hệ thống')]));
    }
    if ($CMSNT->num_rows("SELECT * FROM `users` WHERE `ip` = '".myip()."' ") >= $CMSNT->site('max_register_ip')) {
        die(json_encode(['status' => 'error', 'msg' => __('IP của bạn đã đạt giới hạn tạo tài khoản cho phép')]));
    }
    # Create the 2FA class
    $google2fa = new Google2FA();
    $token = md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 6).time());
    $isCreate = $CMSNT->insert("users", [
        'token'         => $token,
        'username'      => $username,
        'email'         => $email,
        'password'      => TypePassword($password),
        'ref_id'        => !empty($_SESSION['ref']) ? check_string($_SESSION['ref']) : 0,
        'ip'            => myip(),
        'device'        => $Mobile_Detect->getUserAgent(),
        'create_date'   => gettime(),
        'update_date'   => gettime(),
        'time_session'  => time(),
        'change_password'        => 1,
        'SecretKey_2fa' => $google2fa->generateSecretKey()
    ]);
    if ($isCreate) {
        $CMSNT->insert("logs", [
            'user_id'       => $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '$token' ")['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => __('Thực hiện tạo tài khoản')
        ]);
        setcookie("token", $token, time() + $CMSNT->site('session_login'), "/");
        $_SESSION['login'] = $token;
        /** SEND NOTI CHO ADMIN */
        $my_text = $CMSNT->site('register_notification');
        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
        $my_text = str_replace('{username}', $username, $my_text);
        $my_text = str_replace('{email}', $email, $my_text);
        $my_text = str_replace('{ip}', myip(), $my_text);
        $my_text = str_replace('{device}', $Mobile_Detect->getUserAgent(), $my_text);
        $my_text = str_replace('{time}', gettime(), $my_text);
        sendMessAdmin($my_text);
        die(json_encode(['status' => 'success', 'msg' => __('Đăng ký thành công')]));
    } else {
        die(json_encode(['status' => 'error', 'msg' => __('Tạo tài khoản thất bại, vui lòng thử lại')]));
    }
}
