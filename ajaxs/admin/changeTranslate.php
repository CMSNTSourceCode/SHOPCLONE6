<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');
if (isset($_POST['id'])) {
    if ($CMSNT->site('status_demo') != 0) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Không được dùng chức năng này vì đây là trang web demo'
        ]);
        die($data);
    }
    $id = check_string($_POST['id']);
    $row = $CMSNT->get_row("SELECT * FROM `translate` WHERE `id` = '$id' ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'ID ngôn ngữ không tồn tại trong hệ thống'
        ]);
        die($data);
    }
    $isUpdate = $CMSNT->update("translate", [
        'value' => isset($_POST['value']) ? check_string($_POST['value']) : '',
        'name' => isset($_POST['name']) ? check_string($_POST['name']) : ''
    ], " `id` = '$id' ");
    if ($isUpdate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Chỉnh sửa translate (ID '.$row['id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Thay đổi thành công'
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
