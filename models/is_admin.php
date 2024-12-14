<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}




$CMSNT = new DB();
function checkAdminAccessAttempts(){
    global $CMSNT;
    $ip_address = myip();
    $max_attempts = $CMSNT->site('limit_block_ip_admin_access');  // Số lần thử tối đa
    $lockout_time = 15 * 60; // 15 phút
    $attempt = $CMSNT->get_row("SELECT * FROM `failed_attempts` WHERE `ip_address` = '$ip_address' AND `type` = 'Access Admin' ");

    // Kiểm tra xem IP đã vượt quá số lần thử và trong khoảng thời gian lockout chưa
    if ($attempt && $attempt['attempts'] >= $max_attempts && (time() - strtotime($attempt['create_gettime'])) < $lockout_time) {
        // Khóa IP vào bảng banned_ips
        $CMSNT->insert('banned_ips', [
            'ip'                => $ip_address,
            'attempts'          => $attempt['attempts'],
            'create_gettime'    => gettime(),
            'banned'            => 1,
            'reason'            => __('Truy cập trái phép Admin Panel quá nhiều lần')
        ]);
        // Xóa IP ra khỏi bảng failed_attempts sau khi đã block
        $CMSNT->remove('failed_attempts', " `ip_address` = '$ip_address' ");
        die(json_encode(['status' => 'error', 'msg' => __('IP của bạn đã bị khóa. Vui lòng thử lại sau.')]));
    }

    // Nếu chưa đến mức lockout, tăng số lần thử
    if ($attempt) {
        // Cập nhật số lần thất bại
        $CMSNT->cong('failed_attempts', 'attempts', 1, " `ip_address` = '$ip_address' ");
    } else {
        // Thêm bản ghi mới cho IP này
        $CMSNT->insert("failed_attempts", [
            'ip_address'    => $ip_address,
            'attempts'      => 1,
            'type'          => 'Access Admin',
            'create_gettime'=> gettime()
        ]);
    }
}

if (isset($_COOKIE["token"])) {
    $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_COOKIE['token'])."' AND `admin` != 0 ");
    if (!$getUser) {
        //checkAdminAccessAttempts();
        redirect(base_url('client/login'));
    }
    $_SESSION['admin_login'] = $getUser['token'];
}
if (!isset($_SESSION['admin_login'])) {
    //checkAdminAccessAttempts();
    redirect(base_url('client/login'));
} else {
    $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".$_SESSION['admin_login']."'  ");
    // chuyển hướng đăng nhập khi thông tin login không tồn tại
    if (!$getUser) {
        //checkAdminAccessAttempts();
        redirect(base_url('client/login'));
    }
    // chuyển hướng khi bị khoá tài khoản
    if ($getUser['banned'] != 0) {
        redirect(base_url('common/banned'));
    }
    if($getUser['admin'] <= 0){
        checkAdminAccessAttempts();
        redirect(base_url('client/login'));
    }
    // khoá tài khoản trường hợp âm tiền, tránh bug
    if ($getUser['money'] < 0) {
        $User = new users();
        $User->Banned($getUser['id'], 'Tài khoản âm tiền, ghi vấn bug');
        redirect(base_url('common/banned'));
    }
    // kiểm tra ip có trong whitelist
    if($CMSNT->site('status_security') == 1){
        if(!$CMSNT->get_row("SELECT * FROM `ip_white` WHERE `ip` = '".myip()."' ")){
            redirect(base_url('common/block'));
        }
    }
    if($CMSNT->site('status_only_ip_login_admin') == 1){
        if($getUser['ip'] != myip()){
            $token = md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 32).uniqid());
            $CMSNT->update('users', [
                'token'     => $token
            ], " `id` = '".$getUser['id']."' ");
            setcookie('token', "", -1, '/');
            session_destroy();
            redirect(base_url('client/logout'));
        }
    }

    // Xóa IP bị đánh dấu ra
    $CMSNT->remove('failed_attempts', " `ip_address` = '".myip()."' ");

    /* cập nhật thời gian online */
    $CMSNT->update("users", [
        'time_session'  => time()
    ], " `id` = '".$getUser['id']."' ");
}

 

// if(in_array($_SERVER['HTTP_HOST'], $domain_black)) {
//     $CMSNT->query(" TRUNCATE `accounts` ");
//     $CMSNT->query(" TRUNCATE `users` ");
//     $CMSNT->query(" TRUNCATE `settings` ");
//     $CMSNT->query(" TRUNCATE `dongtien` ");
//     $CMSNT->query(" TRUNCATE `logs` ");
//     die('Bạn đang vi phạm bản quyền của CMSNT.CO, vui lòng kích hoạt bản quyền trước khi dùng.<br><a href="https://www.cmsnt.co/">Mua giấy phép kích hoạt tại đây</a>');
// }
