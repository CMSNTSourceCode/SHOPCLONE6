<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../config.php");
require_once(__DIR__."/../libs/lang.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
$CMSNT = new DB();


if(isset($_GET['username'])){
    $username = check_string($_GET['username']);
} else if(isset($_POST['username'])){
    $username = check_string($_POST['username']);
} else{
    $username = NULL;
}

if(isset($_GET['password'])){
    $password = check_string($_GET['password']);
} else if(isset($_POST['password'])){
    $password = check_string($_POST['password']);
} else{
    $password = NULL;
}


if ($username != NULL && $password != NULL) {
  
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '$username'  ")) { 
        die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
    }
    if($getUser['banned'] == 1){
        die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị cấm truy cập')]));
    }
    if(in_array(myip(), $ip_server_black)) {
        die(__('Chức năng này không hỗ trợ cho web dùng crack'));
    }
    if ($CMSNT->site('type_password') == 'bcrypt') {
        if (!password_verify($password, $getUser['password'])) {
            if($getUser['login_attempts'] >= $config['limit_block_ip_login_client']){
                $CMSNT->insert('banned_ips', [
                    'ip'                => myip(),
                    'attempts'          => $getUser['login_attempts'],
                    'create_gettime'    => gettime(),
                    'banned'            => 1,
                    'reason'            => __('Đăng nhập thất bại nhiều lần')
                ]);
            }
            if($getUser['login_attempts'] >= $config['limit_block_login_client']){
                $User = new users();
                $User->Banned($getUser['id'], __('Đăng nhập thất bại nhiều lần'));
                die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị tạm khoá do đang nhập sai nhiều lần')]));
            }
            $CMSNT->cong('users', 'login_attempts', 1, " `id` = '".$getUser['id']."' ");
            die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
        }
    } else {
        if ($getUser['password'] != TypePassword($password)) {
            if($getUser['login_attempts'] >= $config['limit_block_ip_login_client']){
                $CMSNT->insert('banned_ips', [
                    'ip'                => myip(),
                    'attempts'          => $getUser['login_attempts'],
                    'create_gettime'    => gettime(),
                    'banned'            => 1,
                    'reason'            => __('Đăng nhập thất bại nhiều lần')
                ]);
            }
            if($getUser['login_attempts'] >= $config['limit_block_login_client']){
                $User = new users();
                $User->Banned($getUser['id'], __('Đăng nhập thất bại nhiều lần'));
                die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị tạm khoá do đang nhập sai nhiều lần')]));
            }
            $CMSNT->cong('users', 'login_attempts', 1, " `id` = '".$getUser['id']."' ");
            die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
        }
    }
    if($CMSNT->site('status_api_buyproduct') == 0){
        die(__('Chức năng kết nối API đã được tắt trên website này'));
    }
    if ($money = $getUser['money']) {
        die(format_currency($money));
    } else {
        die(format_currency(0));
    }
}



