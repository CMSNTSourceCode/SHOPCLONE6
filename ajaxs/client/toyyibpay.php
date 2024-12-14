<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__.'/../../config.php');
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/toyyibpay.php");
$CMSNT = new DB();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    if ($CMSNT->site('status_demo') != 0) {
        die(json_encode(['status' => 'error', 'msg' => __('You cannot use this function because this is a demo site')]));
    }
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('The system is maintenance')]));
    }
    if ($CMSNT->site('status_toyyibpay') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('This function is under maintenance')]));
    }
    if ($CMSNT->site('userSecretKey_toyyibpay') == '') {
        die(json_encode(['status' => 'error', 'msg' => __('This function has not been configured')]));
    }
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Please log in')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Please log in')]));
    }
    if (time() - $getUser['time_request'] < $config['max_time_load']) {
        die(json_encode(['status' => 'error', 'msg' => __('You are working too fast, please wait')]));
    }
    if (empty($_POST['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Please enter deposit amount')]));
    }
    if ($_POST['amount'] <= 0) {
        die(json_encode(['status' => 'error', 'msg' => __('Deposit amount is not available')]));
    }
    if($_POST['amount'] < $CMSNT->site('min_toyyibpay')){
        die(json_encode(['status' => 'error', 'msg' => __('Minimum deposit amount is RM'.$CMSNT->site('min_toyyibpay').'')]));
    }
    // if($CMSNT->get_row(" SELECT COUNT(id) FROM `nowpayments` WHERE `user_id` = '".$getUser['id']."' AND `payment_status` = 'waiting' AND `created_at` >= DATE(NOW()) AND `created_at` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)'] > 5){
    //     die(json_encode(['status' => 'error', 'msg' => __('Bạn đang có nhiều đơn nạp tiền trong hôm nay chưa được xử lý')]));
    // }

    $amount = check_string($_POST['amount']);
    $trans_id = random('QWERTYUIOPASDFGHJKLZXCVBNM', 3).time();

    $toyyibpay = new toyyibpay($CMSNT->site('userSecretKey_toyyibpay'));
    
    $result = $toyyibpay->createBill([
        'categoryCode' => $CMSNT->site('categoryCode_toyyibpay'),
        'billName' => 'Invoice - RM '.$amount,
        'billDescription'=> 'Recharge invoice on website '.$_SERVER['HTTP_HOST'],
        'billPriceSetting' => 1,
        'billPayorInfo' => 0,
        'billAmount'    => check_string($_POST['amount']) * 100,
        'billReturnUrl' => base_url('client/toyyibpay'),
        'billCallbackUrl'   => base_url('api/callback_toyyibpay.php'),
        'billExternalReferenceNo' => $trans_id,
        'billTo'    =>  $getUser['username'],
        'billEmail' => !empty($getUser['email']) ? $getUser['email'] : 'None',
        'billPhone' => !empty($getUser['phone']) ? $getUser['phone'] : 0,
        'billSplitPayment' => 0,
        'billSplitPaymentArgs' => '',
        'billPaymentChannel' => 0,
        'billContentEmail' => 'Thank you for using our system',
        'billChargeToCustomer'  => $CMSNT->site('billChargeToCustomer'),
        'billExpiryDate'    => '',
        'billExpiryDays'    => 3
    ]);
    $result = json_decode($result, true);
    $BillCode = $result[0]['BillCode'];

    if(!isset($BillCode)){
        die(json_encode(['status' => 'error', 'msg' => __('Error API!')]));
    }
    $isInsert = $CMSNT->insert('toyyibpay_transactions', array(
        'user_id'           => $getUser['id'],
        'trans_id'          => $trans_id,
        'billName'          => 'Invoice - RM '.$amount,
        'amount'            => $amount,
        'status'            => 0,
        'BillCode'          => $BillCode,
        'create_date'       => gettime(),
        'update_date'       => gettime()
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
            'action'        => __('Create Recharge Bank Malaysia Invoice #')." $trans_id"
        ]);
        die(json_encode(['invoice_url'  => 'https://toyyibpay.com/'.$BillCode, 'status' => 'success', 'msg' => __('Successful!')]));
    }else{
        die(json_encode(['status' => 'error', 'msg' => __('Error!')]));
    }
}
