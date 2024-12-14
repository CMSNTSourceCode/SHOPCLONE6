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
    if ($CMSNT->site('status_crypto') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang được bảo trì')]));
    }
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Please log in')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Please log in')]));
    }
    if (empty($_POST['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Please enter the amount to deposit')]));
    }
    $amount = check_string($_POST['amount']);
    if($amount < $CMSNT->site('crypto_min')){
        die(json_encode(['status' => 'error', 'msg' => __('The minimum deposit amount is:').' $'.$CMSNT->site('crypto_min')]));
    }
    if($amount > $CMSNT->site('crypto_max')){
        die(json_encode(['status' => 'error', 'msg' => __('The maximum deposit amount is:').' $'.format_cash($CMSNT->site('crypto_max'))]));
    }
    if($CMSNT->num_rows(" SELECT * FROM `crypto_invoice` WHERE `user_id` = '".$getUser['id']."' AND `status` = 'waiting' AND ROUND(`amount`) = '$amount'  ") >= 3){
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng không SPAM')]));
    }
    $name = 'Recharge '.check_string($_SERVER['HTTP_HOST']);
    $description = 'Recharge invoice to '.$getUser['username'];
    $callback = base_url('api/callback_crypto.php');
    $return_url = base_url('client/crypto');
    $request_id = md5(time().random('qwertyuiopasdfghjklzxcvbnm0123456789', 4));
        $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    ); 
    $result = file_get_contents('https://fpayment.co/api/AddInvoice.php?token_wallet='.$CMSNT->site('crypto_token').
        '&address_wallet='.trim($CMSNT->site('crypto_address')).
        '&name='.urlencode($name).
        '&description='.urlencode($description).
        '&amount='.$amount.
        '&request_id='.$request_id.
        '&callback='.urlencode($callback).
        '&return_url='.urlencode($return_url), false, stream_context_create($arrContextOptions)
    );
    $result = json_decode($result, true);
    if(!isset($result['status'])){
        die(json_encode(['status' => 'error', 'msg' => __('Invoice could not be generated due to API error, please try again later')]));
    }
    if($result['status'] == 'error'){
        die(json_encode(['status' => 'error', 'msg' => __($result['msg'])]));
    }
    $trans_id = check_string($result['data']['trans_id']);
    $isInsert = $CMSNT->insert('crypto_invoice', [
        'trans_id'          => $trans_id,
        'user_id'           => $getUser['id'],
        'request_id'        => check_string($result['data']['request_id']),
        'amount'            => check_string($result['data']['amount']),
        'create_gettime'    => gettime(),
        'update_gettime'    => gettime(),
        'status'            => check_string($result['data']['status']),
        'url_payment'       => check_string($result['data']['url_payment']),
        'msg'               => NULL
    ]);
    if($isInsert){
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => __('Generate Crypto Recharge Invoice').' #'.$trans_id
        ]);
        die(json_encode([
            'url'  => check_string($result['data']['url_payment']),
            'status' => 'success', 
            'msg' => __('Hoá đơn nạp tiền đã được tạo thành công!')
        ]));
    } else{
        die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo hoá đơn')]));
    }
}
