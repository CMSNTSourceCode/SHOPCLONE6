<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if($_POST['store'] == 'mua-xu-ttc'){
        if (empty($_POST['amount'])) {
            die(format_currency(0));
        }
        $amount = check_string($_POST['amount']);
        $total = $amount * $CMSNT->site('rate_ban_xu_ttc');
        die(format_currency($total));
    }
    if($_POST['store'] == 'mua-xu-tds'){
        if (empty($_POST['amount'])) {
            die(format_currency(0));
        }
        $amount = check_string($_POST['amount']);
        $total = $amount * $CMSNT->site('rate_ban_xu_tds');
        die(format_currency($total));
    }
    
    if($_POST['store'] == 'otp-order'){
        if (empty($_POST['amount'])) {
            die(format_currency(0));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(__('Vui lòng đăng nhập'));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `service_otp` WHERE `id` = '".check_string($_POST['id'])."' ")) {
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            // $total = $total - $total * $getUser['chietkhau'] / 100;
            die(format_currency($total));
        }
        die(format_currency(0));
    }


    if($_POST['store'] == 'order-service'){
        if(empty($_POST['service'])){
            die(json_encode([
                'status' => 'success',
                'type'  => '',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `services` WHERE `id` = '".check_string($_POST['service'])."' ")) {
            if(isset($_POST['token'])){
                if($getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")){
                    $ck = $getUser['chietkhau'];
                }
            }
            $amount = check_string($_POST['amount']);
            if($row['type'] == 'Custom Comments'){
                $total_amount = substr_count($_POST['comment'], PHP_EOL) + 1;
                $comment = check_string($_POST['comment']);
                $amount = $total_amount;
            }
            if($row['type'] == 'Package'){
                $amount = 1;
            }
            $total = (int)$amount * $row['price'];
            $total = $total - $total * $ck / 100;
            die(json_encode([
                'status'        => 'success',
                'total'         => format_currency($total),
                'type'          => $row['type'],
                'min_max'       => __('Min').' '.format_cash($row['min']).' - '.__('Max').' '.format_cash($row['max']),
                'msg'           => isset($row['note']) ? $row['note'] : ''
            ]));
        }
    }

    
    if($_POST['store'] == 'accounts'){
        if (empty($_POST['amount'])) {
            die(format_currency(0));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(__('Vui lòng đăng nhập'));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `products` WHERE `id` = '".check_string($_POST['id'])."' ")) {
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            $total = $total - $total * getDiscount(check_string($_POST['amount']), check_string($_POST['id'])) / 100;
            $total = $total - $total * $getUser['chietkhau'] / 100;
            if (isset($_POST['coupon'])) {
                $discount = checkCoupon(check_string($_POST['coupon']), $getUser['id'], $total);
            }
            if (isset($discount)) {
                $total = $total - $total * $discount / 100;
            }
            die(format_currency($total));
        }
        die(format_currency(0));
    }

    if($_POST['store'] == 'documents'){
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(__('Vui lòng đăng nhập'));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `documents` WHERE `id` = '".check_string($_POST['id'])."' ")) {
            $amount = 1;
            $total = $amount * $row['price'];
            $total = $total - $total * $getUser['chietkhau'] / 100;
            if (isset($_POST['coupon'])) {
                $discount = checkCoupon(check_string($_POST['coupon']), $getUser['id'], $total);
            }
            if (isset($discount)) {
                $total = $total - $total * $discount / 100;
            }
            die(format_currency($total));
        }
        die(format_currency(0));
    }

    if($_POST['store'] == 'store-fanpage'){
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(__('Vui lòng đăng nhập'));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `store_fanpage` WHERE `id` = '".check_string($_POST['id'])."' ")) {
            $amount = 1;
            $total = $amount * $row['price'];
            $total = $total - $total * $getUser['chietkhau'] / 100;
            if (isset($_POST['coupon'])) {
                $discount = checkCoupon(check_string($_POST['coupon']), $getUser['id'], $total);
            }
            if (isset($discount)) {
                $total = $total - $total * $discount / 100;
            }
            die(format_currency($total));
        }
        die(format_currency(0));
    }

 


    die(format_currency(0));
    
}
die(format_currency(0));
