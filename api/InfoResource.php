<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../config.php");
require_once(__DIR__."/../libs/lang.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if (isset($_GET['username']) && isset($_GET['password'])) {
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".check_string($_GET['username'])."'  ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Thông tin đăng nhập không chính xác')]));
    }
    if($getUser['banned'] == 1){
        die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị cấm truy cập')]));
    }
    if($CMSNT->site('status_api_buyproduct') == 0){
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng kết nối API đã được tắt trên website này')]));
    }
    if(in_array(myip(), $ip_server_black)) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này không hỗ trợ cho web dùng crack')]));
    }
    $password = check_string($_GET['password']);
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
    if (!isset($_GET['id'])) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Thiếu ID sản phẩm cần lấy thông tin'
        ]));
    }
    $id = check_string($_GET['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `products` WHERE  `status` = 1 AND `id` = '$id'  ORDER BY `id` desc ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'ID sản phẩm không hợp lệ'
        ]));
    }
    if($row['allow_api'] == 0){
        die(json_encode([
            'status'    => 'error',
            'msg'       => __('Sản phẩm này không được phép đấu API')
        ]));
    }
    // $conlai = $CMSNT->num_rows(" SELECT * FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `status` = 'LIVE' AND `buyer` IS NULL ");
    // $conlai = $conlai ? $conlai : 0;
    $conlai = $row['id_api'] != 0 ? $row['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
    $list_dichvu = [];
    $list_dichvu =
    [
        'id'            => $row['id'],
        'name'          => $row['name'],
        'price'         => $row['price'],
        'amount'        => $conlai,
        'country'       => $row['flag'],
        'description'   => $row['content']
    ];
    die(json_encode([
        'status'    => 'success',
        'msg'       => 'Lấy thông tin sản phẩm thành công',
        'data'      => $list_dichvu
    ]));
    echo json_encode($data, JSON_PRETTY_PRINT);
} else {
    die(json_encode([
        'status'    => 'error',
        'msg'       => 'Vui lòng nhập thông tin đăng nhập'
    ]));
}
