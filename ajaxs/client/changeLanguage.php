<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/lang.php");

$CMSNT = new DB();
if (isset($_POST['id'])) {
    $id = check_string($_POST['id']);
    $row = $CMSNT->get_row("SELECT * FROM `languages` WHERE `id` = '$id' ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'ID ngôn ngữ không tồn tại trong hệ thống'
        ]);
        die($data);
    }
    $isUpdate = setLanguage($id);
    if ($isUpdate) {
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Thay đổi ngôn ngữ thành công'
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
