<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/lang.php");

$CMSNT = new DB();
if (isset($_POST['id'])) {
    $id = check_string($_POST['id']);
    $row = $CMSNT->get_row("SELECT * FROM `currencies` WHERE `id` = '$id' ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __('ID tiền tệ không tồn tại trong hệ thống')
        ]);
        die($data);
    }
    $isUpdate = setCurrency($id);
    if ($isUpdate) {
        $data = json_encode([
            'status'    => 'success',
            'msg'       => __('Thay đổi tiền tệ thành công')
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
