<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__.'/../../config.php');
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status_demo') != 0) {
        die(json_encode(['status' => 'error', 'msg' => 'Bạn không được dùng chức năng này vì đây là trang web demo']));
    }
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if ($CMSNT->site('status_napthe') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng nạp thẻ đang được tắt')]));
    }
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (time() - $getUser['time_request'] < $config['max_time_load']) {
        die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
    }
    if (empty($_POST['telco'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn nhà mạng')]));
    }
    if (empty($_POST['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn mệnh giá cần nạp')]));
    }
    if ($_POST['amount'] <= 0) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn mệnh giá cần nạp')]));
    }
    if (empty($_POST['serial'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập serial thẻ')]));
    }
    if (empty($_POST['pin'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mã thẻ')]));
    }
    $telco = check_string($_POST['telco']);
    $amount = check_string($_POST['amount']);
    $serial = check_string($_POST['serial']);
    $pin = check_string($_POST['pin']);
    if (checkFormatCard($telco, $serial, $pin)['status'] != true) {
        die(json_encode(['status' => 'error', 'msg' => checkFormatCard($telco, $serial, $pin)['msg']]));
    }
    if($CMSNT->num_rows(" SELECT * FROM `cards` WHERE `user_id` = '".$getUser['id']."' AND `status` = 0  ") > 5){
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng không spam!')]));
    }
    if(
        $CMSNT->num_rows("SELECT * FROM `cards` WHERE `status` = 2 AND `user_id` = '".$getUser['id']."' AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY  ") - 
        $CMSNT->num_rows("SELECT * FROM `cards` WHERE `status` = 1 AND `user_id` = '".$getUser['id']."' AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY  ") >= 5)
    {
        die(json_encode(['status' => 'error', 'msg' => __('Bạn đã bị chặn sử dụng chức năng nạp thẻ trong 1 ngày')]));
    }
    $trans_id = random('QWERTYUIOPASDFGHJKLZXCVBNM', 6).time();
    $data = card24h($telco, $amount, $serial, $pin, $trans_id);
    if($data['status'] == 99){
        $isInsert = $CMSNT->insert("cards", array(
            'trans_id'  => $trans_id,
            'telco'     => $telco,
            'amount'    => $amount,
            'serial'    => $serial,
            'pin'       => $pin,
            'price'     => 0,
            'user_id'   => $getUser['id'],
            'status'    => 0,
            'reason'    => '',
            'create_date'    => gettime(),
            'update_date'    => gettime()
        ));
        if ($isInsert) {
            // Nhập thời gian request chống spam
            $CMSNT->update("users", [
                'time_request' => time()
            ], " `id` = '".$getUser['id']."' ");
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => "Thực hiện nạp thẻ Serial: $serial - Pin: $pin"
            ]);
            die(json_encode(['status' => 'success', 'msg' => __('Nạp thẻ thành công')]));
        }else{
            die(json_encode(['status' => 'error', 'msg' => __('Nạp thẻ thất bại, vui lòng liên hệ Admin')]));
        }
    }else{
        die(json_encode(['status' => 'error', 'msg' => $data['data']['msg']]));
    }
}
