<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = check_string($_POST['email']);
    $password = check_string($_POST['password']);
    die(json_encode([
        'status'    => 'error',
        'msg'       => 'Chức năng này đã bị đóng, vui lòng đăng nhập bằng trang khách'
    ]));
    if (empty($email = check_string($_POST['email']))) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Email không được để trống'
        ]));
    }
    if (empty($_POST['password'])) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Mật khẩu không được để trống'
        ]));
    }
    $CMSNT = new DB();
    if ($CMSNT->site('status_captcha') == 1) {
        $phrase = check_string($_POST['phrase']);
        if (strcasecmp($phrase, $_SESSION['phrase']) != 0) {
            die(json_encode(['status' => 'error', 'msg' => __('Captcha không chính xác')]));
        }
    }
    $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `email` = '$email' AND `ctv` = 1  ");
    if (!$getUser) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Thông tin đăng nhập không chính xác'
        ]));
    }
    if (time() > $getUser['time_request']) {
        if (time() - $getUser['time_request'] < $config['max_time_load']) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
        }
    }
    if ($CMSNT->site('type_password') == 'bcrypt') {
        if (!password_verify($password, $getUser['password'])) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Thông tin đăng nhập không chính xác')
            ]));
        }
    } else {
        if ($getUser['password'] != TypePassword($password)) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Thông tin đăng nhập không chính xác')
            ]));
        }
    }
    if ($getUser['status_2fa'] == 1) {
        die(json_encode([
            'status'    => 'verify',
            'url'       => base_url('ctv/verify/'.base64_encode($getUser['token'])),
            'msg'       => __('Vui lòng xác minh 2FA để hoàn thành đăng nhập')
        ]));
    }
    $Mobile_Detect = new Mobile_Detect();
    $CMSNT->insert("logs", [
        'user_id'       => $getUser['id'],
        'ip'            => myip(),
        'device'        => $Mobile_Detect->getUserAgent(),
        'createdate'    => gettime(),
        'action'        => 'Đăng nhập thành công vào hệ thống CTV.'
    ]);
    $new_token = md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 6).time());
    $CMSNT->update("users", [
        'ip'        => myip(),
        'time_request' => time(),
        'time_session' => time(),
        'device'    => $Mobile_Detect->getUserAgent(),
        'token'     => $new_token
    ], " `id` = '".$getUser['id']."' ");
    setcookie("token", $new_token, time() + $CMSNT->site('session_login'), "/");
    $_SESSION['ctv_login'] = $new_token;
    die(json_encode([
        'status' => 'success',
        'msg' => 'Đăng nhập thành công!'
    ]));
}
