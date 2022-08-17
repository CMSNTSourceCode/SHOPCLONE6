<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    if($_POST['store'] == 'buffsub_sale'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    if($_POST['store'] == 'buffsub_speed'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    if($_POST['store'] == 'buffsub_slow'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    if($_POST['store'] == 'bufflikefanpagesale'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    if($_POST['store'] == 'bufflikefanpage'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    if($_POST['store'] == 'buffsubfanpage'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    if($_POST['store'] == 'bufflikecommentsharelike'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    if($_POST['store'] == 'bufflikecommentshareshare'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    if($_POST['store'] == 'buffviewstory'){
        if(empty($_POST['loaiseeding'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '".check_string($_POST['loaiseeding'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => $row['note']
                ]));
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => $row['note']
            ]));
        }
    }

    die(format_currency(0));
    
}
die(format_currency(0));
