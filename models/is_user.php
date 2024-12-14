<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


$CMSNT = new DB();
if (isset($_COOKIE["token"])) {
    $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_COOKIE['token'])."' ");
    if (!$getUser) {
        redirect(base_url('client/logout'));
    }
    $_SESSION['login'] = $getUser['token'];
}
if (!isset($_SESSION['login'])) {
    redirect(base_url('client/login'));
} else {
    $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_SESSION['login'])."'  ");
    // chuyển hướng đăng nhập khi thông tin login không tồn tại
    if (!$getUser) {
        redirect(base_url('client/login'));
    }
    // chuyển hướng khi bị khoá tài khoản
    if ($getUser['banned'] != 0) {
        redirect(base_url('common/banned'));
    }
    // khoá tài khoản trường hợp âm tiền, tránh bug
    if ($getUser['money'] < 0) {
        $User = new users();
        $User->Banned($getUser['id'], 'Tài khoản âm tiền, ghi vấn bug');
        redirect(base_url('common/banned'));
    }
    if($CMSNT->site('status_active_member') == 1){
        if($getUser['active'] != 1){
            redirect(base_url('common/not-active'));
        }
    }
    $CMSNT->update('users', [
        'update_date'   => gettime()
    ], " `id` = '".$getUser['id']."' ");
}

if (is_array($domain_black)) {
    if(in_array($_SERVER['HTTP_HOST'], $domain_black)) {
        // $CMSNT->query(" TRUNCATE `accounts` ");
        // $CMSNT->query(" TRUNCATE `users` ");
        // $CMSNT->query(" TRUNCATE `settings` ");
        // $CMSNT->query(" TRUNCATE `dongtien` ");
        // $CMSNT->query(" TRUNCATE `logs` ");
        die('Bạn đang vi phạm bản quyền của CMSNT.CO, vui lòng kích hoạt bản quyền trước khi dùng.<br><a href="https://www.cmsnt.co/">Mua giấy phép kích hoạt tại đây</a>');
    }
}
 
 