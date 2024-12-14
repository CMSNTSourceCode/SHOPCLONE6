<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/sendEmail.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if (empty($_POST['type'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn phương thức thanh toán')]));
    }
    if (empty($_POST['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số tiền cần nạp')]));
    }
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$row = $CMSNT->get_row("SELECT * FROM `banks` WHERE `id` = '".check_string($_POST['type'])."' ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Phương thức thanh toán không tồn tại trong hệ thống')]));
    }
    if (time() - $getUser['time_request'] <  $config['max_time_load']) {
        die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
    }
    if ($_POST['amount'] < $CMSNT->site('min_recharge')) {
        die(json_encode(['status' => 'error', 'msg' => __('Số tiền nạp tối thiểu là').' '.format_currency($CMSNT->site('min_recharge'))]));
    }
    if ($CMSNT->num_rows("SELECT * FROM `invoices` WHERE `user_id` = '".$getUser['id']."' AND `status` = 0 AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ") >= 5) {
        die(json_encode(['status' => 'error', 'msg' => __('Bạn đang có quá nhiều hoá đơn đang chờ xử lý trong ngày')]));
    }
    $type = check_string($_POST['type']);
    // $amount là số tiền cần thanh toán
    $amount = check_string($_POST['amount']);
    $received = $amount;
    foreach($CMSNT->get_list("SELECT * FROM `promotions` WHERE `amount` <= '$amount' AND `status` = 1 ORDER by `amount` DESC ") as $promotion){
        // $received là thực nhận sau khi thanh toán đủ $amount
        $received = $amount + $amount * $promotion['discount'] / 100;
        break;
    }
    $trans_id = random('QWERTYUIOPASDFGHJKLZXCVBNM', 4).random("0123456789", 2);
    $isInsert = $CMSNT->insert("invoices", [
        'type'              => 'deposit_money',
        'user_id'           => $getUser['id'],
        'trans_id'          => $trans_id,
        'payment_method'    => $row['short_name'],
        'amount'            => $received,
        'pay'               => $amount,
        'status'            => 0,
        'create_date'       => gettime(),
        'update_date'       => gettime(),
        'create_time'       => time(),
        'update_time'       => time(),
        'note'              => null,
        'fake'              => 0
    ]);
    if ($isInsert) {
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => __('Tạo hoá đơn nạp tiền').' #'.$trans_id
        ]);
        // nhập thời gian request chống spam
        $CMSNT->update("users", [
            'time_request' => time()
        ], " `id` = '".$getUser['id']."' ");

        $chu_de = "Bạn có hóa đơn cần thanh toán tại ".$CMSNT->site('title');
        $content = curl_get2(base_url('libs/mails/deposit-order.php'));
        $content = str_replace('{payment_method}', $row['short_name'], $content);
        $content = str_replace('{amount}', format_cash($amount), $content);
        $content = str_replace('{trans_id}', $trans_id, $content);
        $content = str_replace('{price}', format_currency($amount), $content);
        $bcc = $CMSNT->site('title');
        sendCSM($getUser['email'], $getUser['username'], $chu_de, $content, $bcc);

        /** SEND NOTI CHO ADMIN */
        $my_text = $CMSNT->site('taohoadonnaptien_notification');
        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
        $my_text = str_replace('{username}', $getUser['username'], $my_text);
        $my_text = str_replace('{method}', $row['short_name'], $my_text);
        $my_text = str_replace('{trans_id}', $trans_id, $my_text);
        $my_text = str_replace('{amount}', format_cash($amount), $my_text);
        $my_text = str_replace('{price}', format_currency($received), $my_text);
        $my_text = str_replace('{time}', gettime(), $my_text);
        sendMessAdmin($my_text);


        die(json_encode(['status' => 'success', 'msg' => __('Tạo hoá đơn thành công'), 'trans_id' => $trans_id ]));
    } else {
        die(json_encode(['status' => 'error', 'msg' => __('Tạo hoá đơn thất bại, vui lòng thử lại')]));
    }
}
