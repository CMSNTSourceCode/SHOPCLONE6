<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");

$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();


if (isset($_POST['id'])) {
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    $id = check_string($_POST['id']);
    $row = $CMSNT->get_row("SELECT * FROM `orders` WHERE `id` = '$id' AND `buyer` = '".$getUser['id']."'  ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __('Đơn hàng không tồn tại trong hệ thống')
        ]);
        die($data);
    }
    $isRemove = $CMSNT->update("orders", [
        'display'   => 0
    ], " `id` = '$id' ");
    if ($isRemove) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => __('Xoá đơn hàng').' (#'.$row['trans_id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => __('Xóa sản phẩm thành công')
        ]);
        die($data);
    } else {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __('Xóa sản phẩm thất bại')
        ]);
        die($data);
    }
} else {
    $data = json_encode([
        'status'    => 'error',
        'msg'       => __('Dữ liệu không hợp lệ')
    ]);
    die($data);
}
