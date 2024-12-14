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
    $data = [];
    $list_category = [];
    foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 ORDER BY `id` ") as $category) {
        $list_dichvu = [];
        foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `allow_api` = 1 AND `status` = 1 AND `category_id` = '".$category['id']."'  ORDER BY `id` ") as $row) {
            $conlai = $row['id_api'] != 0 ? $row['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
            $sold = $CMSNT->get_row(" SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NOT NULL ")['COUNT(id)'];
            $list_dichvu[] = [
                'id'            => $row['id'],
                'name'          => $row['name'],
                'price'         => $row['price'],
                'amount'        => $conlai,
                'country'       => $row['flag'],
                'description'   => $row['content']
            ];
        }
        $list_category[] =
        [
            'id'    => $category['id'],
            'name'  => $category['name'],
            'image' => BASE_URL($category['image']),
            'accounts'  => $list_dichvu
        ];
    }
    $data =
    [
        'status'    => 'success',
        'categories'  => $list_category
    ];
    echo json_encode($data, JSON_PRETTY_PRINT);
} else {
    die(json_encode([
        'status'    => 'error',
        'msg'       => 'Vui lòng nhập thông tin đăng nhập'
    ]));
}
