<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");

$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if (isset($_POST['transid'])) {
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    $trans_id = check_string($_POST['transid']);
    $row = $CMSNT->get_row("SELECT * FROM `orders` WHERE `trans_id` = '$trans_id' AND `buyer` = '".$getUser['id']."'  ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __('Đơn hàng không tồn tại trong hệ thống')
        ]);
        die($data);
    }
    $clone = '';
    foreach ($CMSNT->get_list(" SELECT * FROM `accounts` WHERE `trans_id` = '$trans_id' ORDER BY id DESC ") as $row1) {
        $clone = $clone.PHP_EOL.htmlspecialchars_decode($row1['account']);
    }
    if (isset($clone)) {
        $file = $trans_id.".txt";
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => __('Tải về đơn hàng').' (#'.$row['trans_id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'filename'  => $file,
            'accounts'  => $clone,
            'msg'       => __('Đang tải xuống đơn hàng...')
        ]);
        die($data);
    } else {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __('Tải về đơn hàng thất bại')
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
