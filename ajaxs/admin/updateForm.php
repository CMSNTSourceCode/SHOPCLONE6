<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');

if (isset($_POST['table'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die(json_encode(['status' => 'error','msg' => 'Không được dùng chức năng này vì đây là trang web demo']));
    }
    if($_POST['table'] == 'rate_autofb'){
        $isUpdate = $CMSNT->update("rate_autofb", [
            'loaiseeding'       => check_string($_POST['loaiseeding']),
            'name_loaiseeding'  => check_string($_POST['name_loaiseeding']),
            'price'             => check_string($_POST['price']),
            'note'              => $_POST['note']
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }

} 
else {
    $data = json_encode([
        'status'    => 'error',
        'msg'       => 'Dữ liệu không hợp lệ'
    ]);
    die($data);
}
