<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/helper.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

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
    $data = [];
    $list_category = [];
    foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 ORDER BY `id` ") as $category) {
        $list_dichvu = [];
        foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE  `status` = 1 AND `category_id` = '".$category['id']."'  ORDER BY `id` ") as $row) {
            // $conlai = $CMSNT->num_rows(" SELECT * FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `status` = 'LIVE' AND `buyer` IS NULL ");
            // $conlai = $conlai ? $conlai : 0;
            $conlai = $row['id_api'] != 0 ? $row['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
            $sold = $CMSNT->num_rows(" SELECT * FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NOT NULL ");
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
