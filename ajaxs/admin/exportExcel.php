<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if (isset($_POST['type'])) {

    if($_POST['type'] == 'invoices'){
        $i=1;
        $content = 'STT,TÀI KHOẢN,MÃ GIAO DỊCH,NGÂN HÀNG,THỰC NHẬN,TIỀN NẠP,TRẠNG THÁI, THỜI GIAN TẠO, CẬP NHẬT'.PHP_EOL;
        foreach($CMSNT->get_list(" SELECT * FROM `invoices` WHERE `fake` = 0 ORDER BY id ASC ") as $row){
            $content .= $i++.
            ','.getRowRealtime("users", $row['user_id'], "username").
            ','.$row['trans_id'].
            ','.$row['payment_method'].
            ','.format_currency($row['amount']).
            ','.format_currency($row['pay']).
            ','.display_invoice_text($row['status']).
            ','.$row['create_date'].
            ','.$row['update_date'].
            PHP_EOL;
        }
        $file = "Invoices.csv";
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Tải về dữ liệu Invoices.csv'
        ]);
        die(json_encode([
            'status'    => 'success',
            'filename'  => $file,
            'accounts'  => $content,
            'msg'       => __('Đang tải xuống...')
        ]));
    }

    if($_POST['type'] == 'product-order'){
        $i=1;
        $content = 'STT,BÊN BÁN,BÊN MUA,SẢN PHẨM,SỐ LƯỢNG,THANH TOÁN,MÃ GIAO DỊCH,THỜI GIAN'.PHP_EOL;
        foreach($CMSNT->get_list(" SELECT * FROM `orders` WHERE `product_id` != 0 AND `fake` = 0 ORDER BY id ASC ") as $row){
            $content .= $i++.
            ','.getRowRealtime("users", $row['seller'], "username").
            ','.getRowRealtime("users", $row['buyer'], "username").
            ','.getRowRealtime("products", $row['product_id'], 'name').
            ','.format_cash($row['amount']).
            ','.format_currency($row['pay']).
            ','.$row['trans_id'].
            ','.$row['create_date'].
            PHP_EOL;
        }
        $file = "ProductOrders.csv";
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Tải về dữ liệu ProductOrders.csv'
        ]);
        die(json_encode([
            'status'    => 'success',
            'filename'  => $file,
            'accounts'  => $content,
            'msg'       => __('Đang tải xuống...')
        ]));
    }


    if($_POST['type'] == 'document-order'){
        $i=1;
        $content = 'STT,BÊN BÁN,BÊN MUA,SẢN PHẨM,THANH TOÁN,MÃ GIAO DỊCH,THỜI GIAN'.PHP_EOL;
        foreach($CMSNT->get_list(" SELECT * FROM `orders` WHERE `document_id` != 0 AND `fake` = 0 ORDER BY id ASC ") as $row){
            $content .= $i++.
            ','.getRowRealtime("users", $row['seller'], "username").
            ','.getRowRealtime("users", $row['buyer'], "username").
            ','.getRowRealtime("products", $row['document_id'], 'name').
            ','.format_currency($row['pay']).
            ','.$row['trans_id'].
            ','.$row['create_date'].
            PHP_EOL;
        }
        $file = "DocumentOrders.csv";
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Tải về dữ liệu DocumentOrders.csv'
        ]);
        die(json_encode([
            'status'    => 'success',
            'filename'  => $file,
            'accounts'  => $content,
            'msg'       => __('Đang tải xuống...')
        ]));
    }


    if($_POST['type'] == 'users'){
        $content = 'ID,USERNAME,EMAIL,PASSWORD,PHONE,MONEY,TOTAL MONEY,DISCOUNT,ĐĂNG KÝ,ĐĂNG NHẬP,IP,BANNED,CTV,ADMIN'.PHP_EOL;
        foreach($CMSNT->get_list(" SELECT * FROM `users` ORDER BY `id` ") as $row){
            $content .= $row['id'].
            ','.$row['username'].
            ','.$row['email'].
            ','.$row['phone'].
            ','.$row['password'].
            ','.format_currency($row['money']).
            ','.format_currency($row['total_money']).
            ','.$row['chietkhau'].'%'.
            ','.$row['create_date'].
            ','.$row['update_date'].
            ','.$row['ip'].
            ','.$row['banned'].
            ','.$row['ctv'].
            ','.$row['admin'].
            PHP_EOL;
        }
        if (isset($content)) {
            $file = "Users.csv";
            $Mobile_Detect = new Mobile_Detect();
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => 'Tải về dữ liệu Users.csv'
            ]);
            die(json_encode([
                'status'    => 'success',
                'filename'  => $file,
                'accounts'  => $content,
                'msg'       => __('Đang tải xuống...')
            ]));
        } else {
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Tải về đơn hàng thất bại')
            ]));
        }
    }
    die(json_encode([
        'status'    => 'error',
        'msg'       => __('Dữ liệu không hợp lệ')
    ]));
}
else{
    die(json_encode([
        'status'    => 'error',
        'msg'       => __('Dữ liệu không hợp lệ')
    ]));
}
