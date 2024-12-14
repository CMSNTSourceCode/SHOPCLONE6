<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/database/users.php");
require_once(__DIR__.'/../../models/is_admin.php');

if ($CMSNT->site('status_demo') != 0) {
    die(json_encode(['status' => 'error','msg' => 'Không được dùng chức năng này vì đây là trang web demo']));
}
if (isset($_POST['action'])) {

    // EDIT list_tds_ttc
    if($_POST['action'] == 'update_list_tds_ttc'){
        $isUpdate = $CMSNT->update("list_tds_ttc", [
            'server'  => check_string($_POST['server']),
            'username'  => check_string($_POST['username']),
            'password'  => check_string($_POST['password']),
            'coin'  => check_string($_POST['coin']),
            'proxy_host'  => check_string($_POST['proxy_host']),
            'proxy_user'  => check_string($_POST['proxy_user']),
            'cookie'  => check_string($_POST['cookie']),
            'status'    => !empty($_POST['status']) ? check_string($_POST['status']) : 0
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }

    if($_POST['action'] == 'refundOrder'){
        if (empty($_POST['id'])) {
            die(json_encode(['status' => 'error','msg' => __('ID đơn hàng không tồn tại trong hệ thống')]));
        }
        if (!$row = $CMSNT->get_row(" SELECT * FROM `orders` WHERE `id` = '".check_string($_POST['id'])."' ")){
            die(json_encode(['status' => 'error','msg' => __('ID đơn hàng không tồn tại trong hệ thống')]));
        }
        if($row['refund'] == 1){
            die(json_encode(['status' => 'error','msg' => __('Đơn hàng này đã được hoàn tiền rồi')]));
        }
        if(!$rowUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '".$row['buyer']."' ")){
            die(json_encode(['status' => 'error','msg' => __('Không tìm thấy người mua đơn hàng này')]));
        }
        $User = new users;
        $isRefund = $User->RefundCredits($rowUser['id'], $row['pay'], __("Hoàn tiền đơn hàng #".$row['trans_id']));
        if($isRefund){
            if($rowUser['ref_id'] != 0){
                $ck = $CMSNT->site('ck_ref');
                if(getRowRealtime('users', $rowUser['ref_id'], 'ref_ck') != 0){
                    $ck = getRowRealtime('users', $rowUser['ref_id'], 'ref_ck');
                }
                $price = $row['pay'] * $ck / 100;
                $CMSNT->tru('users', 'ref_money', $price, " `id` = '".$rowUser['ref_id']."' ");
                $CMSNT->tru('users', 'ref_total_money', $price, " `id` = '".$rowUser['ref_id']."' ");
                $CMSNT->tru('users', 'ref_amount', $price, " `id` = '".$rowUser['id']."' ");
                $CMSNT->insert('log_ref', [
                    'user_id'       => $rowUser['ref_id'],
                    'reason'        => __('Thu hồi đơn hàng #'.$row['trans_id']),
                    'sotientruoc'   => getRowRealtime('users', $rowUser['ref_id'], 'ref_money') + $price,
                    'sotienthaydoi' => $price,
                    'sotienhientai' => getRowRealtime('users', $rowUser['ref_id'], 'ref_money'),
                    'create_gettime'    => gettime()
                ]);
            }
            $CMSNT->update('orders', [
                'refund'    => 1
            ], " `id` = '".$row['id']."' ");

            die(json_encode(['status' => 'success', 'msg' => __('Hoàn tiền thành công!')]));

        }


    }

    // EDIT NOTE store_fanpage
    if($_POST['action'] == 'changeStoreFanpage'){
        $isUpdate = $CMSNT->update("store_fanpage", [
            'note'  => check_string($_POST['note'])
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }


    if($_POST['action'] == 'changeProductAPI'){
        $isUpdate = $CMSNT->update("products", [
            'price'  => check_string($_POST['price']),
            'cost'  => check_string($_POST['cost'])
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }

    if($_POST['action'] == 'setDefaultCurrency'){
        $id = check_string($_POST['id']);
        $row = $CMSNT->get_row("SELECT * FROM `currencies` WHERE `id` = '$id' ");
        if (!$row) {
            $data = json_encode([
                'status'    => 'error',
                'msg'       => 'ID tiền tệ không tồn tại trong hệ thống'
            ]);
            die($data);
        }
        $CMSNT->update("currencies", [
            'default_currency' => 0
        ], " `id` > 0 ");
        $isUpdate = $CMSNT->update("currencies", [
            'default_currency' => 1
        ], " `id` = '$id' ");
        if ($isUpdate){
            $Mobile_Detect = new Mobile_Detect();
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => 'Set mặc định tiền tệ ('.$row['name'].' ID '.$row['id'].')'
            ]);
            $data = json_encode([
                'status'    => 'success',
                'msg'       => 'Thay đổi trạng thái tiền tệ thành công'
            ]);
            die($data);
        }else{
            die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
        }
    }

    if($_POST['action'] == 'cancel_email_campaigns'){
        $isUpdate = $CMSNT->update("email_campaigns", [
            'status'  => 2
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }


    
} 
 

$data = json_encode([
    'status'    => 'error',
    'msg'       => 'Dữ liệu không hợp lệ'
]);
die($data);

