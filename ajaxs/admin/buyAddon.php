<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');

if (isset($_POST['id'])) {
    $id = check_string($_POST['id']);
    $row = $CMSNT->get_row("SELECT * FROM `addons` WHERE `id` = '$id' ");
    if (!$row) {
        die(json_encode(['status' => 'error', 'msg' => 'Addon này không tồn tại trong hệ thống!']));
    }
    if(empty($_POST['purchase_key'])){
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập Purchase key!']));
    }
    if ($CMSNT->site('status_demo') != 0) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Không được dùng chức năng này vì đây là trang web demo'
        ]);
        die($data);
    }
    $purchase_key = check_string($_POST['purchase_key']);
    $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
    if($purchase_key != md5($domain.'|'.$row['id'])){
        die(json_encode(['status' => 'error', 'msg' => 'Mã kích hoạt không hợp lệ!']));
    }
    $isUpdate = $CMSNT->update("addons",[
        'purchase_key'  => $purchase_key
    ], " `id` = '$id' ");
    if ($isUpdate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Kích hoạt thành công Addon ('.$row['name'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Kích hoạt addon thành công!'
        ]);
        die($data);
    }
} else {
    $data = json_encode([
        'status'    => 'error',
        'msg'       => 'Dữ liệu không hợp lệ'
    ]);
    die($data);
}
