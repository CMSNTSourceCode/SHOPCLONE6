<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__.'/../../config.php');
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/nowpayments.php");
$CMSNT = new DB();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status_demo') != 0) {
        die(json_encode(['status' => 'error', 'msg' => 'Bạn không được dùng chức năng này vì đây là trang web demo']));
    }
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if ($CMSNT->site('status_crypto') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang được bảo trì')]));
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
    if (empty($_POST['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số tiền nạp')]));
    }
    if ($_POST['amount'] <= 0) {
        die(json_encode(['status' => 'error', 'msg' => __('Số tiền nạp không khả dụng')]));
    }
    if($_POST['amount'] < $CMSNT->site('min_crypto')){
        die(json_encode(['status' => 'error', 'msg' => __('Số tiền nạp tối thiểu là '.'$'.$CMSNT->site('min_crypto'))]));
    }
    if($CMSNT->get_row(" SELECT COUNT(id) FROM `nowpayments` WHERE `user_id` = '".$getUser['id']."' AND `payment_status` = 'waiting' AND `created_at` >= DATE(NOW()) AND `created_at` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)'] > 5){
        die(json_encode(['status' => 'error', 'msg' => __('Bạn đang có nhiều đơn nạp tiền trong hôm nay chưa được xử lý')]));
    }

    $amount = check_string($_POST['amount']);
    $trans_id = random('QWERTYUIOPASDFGHJKLZXCVBNM', 4).time();

    $NowPaymentsAPI = new NowPaymentsAPI($CMSNT->site('apikey_nowpayments'));
    $result = $NowPaymentsAPI->createInvoice([
        'price_amount'      => $amount,
        'price_currency'    => 'usd',
        'ipn_callback_url'  => base_url('api/callback_nowpayments.php'),
        'order_id'          => $trans_id,
        'order_description' => __('Hoá đơn nạp tiền').' #'.$trans_id,
        'success_url'       => base_url('client/crypto'),
        'cancel_url'        => base_url('client/crypto')
    ]);
    $result = json_decode($result, true);
    $isInsert = $CMSNT->insert('nowpayments', array(
        'user_id'           => $getUser['id'],
        'invoice_id'        => $result['id'],
        'payment_id'        => NULL,
        'payment_status'    => 'waiting',
        'pay_address'       => NULL,
        'price_amount'      => $result['price_amount'],
        'price_currency'    => $result['price_currency'],
        'pay_amount'        => 0,
        'actually_paid'     => 0,
        'pay_currency'      => $result['pay_currency'],
        'order_id'          => $trans_id,
        'order_description' => __('Hoá đơn nạp tiền').' #'.$trans_id,
        'purchase_id'       => NULL,
        'created_at'        => gettime(),
        'updated_at'        => gettime(),
        'outcome_amount'    => 0,
        'outcome_currency'  => NULL
    ));

    if ($isInsert) {
        $CMSNT->update("users", [
            'time_request' => time()
        ], " `id` = '".$getUser['id']."' ");

        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => __('Tạo hoá đơn nạp tiền qua Crypto')." $trans_id"
        ]);
        die(json_encode(['invoice_url'  => $result['invoice_url'], 'status' => 'success', 'msg' => __('Tạo đơn nạp tiền thành công !')]));
    }else{
        die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo hoá đơn')]));
    }
}
