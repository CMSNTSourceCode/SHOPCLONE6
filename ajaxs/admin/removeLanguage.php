<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
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
    $row = $CMSNT->get_row("SELECT * FROM `languages` WHERE `id` = '$id' ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'ID ngôn ngữ không tồn tại trong hệ thống'
        ]);
        die($data);
    }
    if ($row['lang_default'] == 1) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Bạn không thể xoá ngôn ngữ mặc định của hệ thống'
        ]);
        die($data);
    }
    $CMSNT->remove("translate", " `lang_id` = '".$row['id']."' ");
    $isRemove = $CMSNT->remove("languages", " `id` = '$id' ");
    if ($isRemove) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Xoá ngôn ngữ ('.$row['lang'].' ID '.$row['id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa ngôn ngữ thành công'
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
