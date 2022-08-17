<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/helper.php");
$CMSNT = new DB();


if (isset($_GET['username']) && isset($_GET['password'])) {
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".check_string($_GET['username'])."'  ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Thông tin đăng nhập không chính xác'
        ]));
    }
    $password = check_string($_GET['password']);
    if ($CMSNT->site('type_password') == 'bcrypt') {
        if (!password_verify($password, $getUser['password'])) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => 'Thông tin đăng nhập không chính xác'
            ]));
        }
    } else {
        if ($getUser['password'] != TypePassword($password)) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => 'Thông tin đăng nhập không chính xác'
            ]));
        }
    }

    if ($money = $getUser['money']) {
        die(format_currency($money));
    } else {
        die(format_currency(0));
    }
}
