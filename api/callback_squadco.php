<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../config.php");
require_once(__DIR__."/../libs/lang.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
 
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();
$headers = getallheaders();

if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !isset($headers['x-squad-encrypted-body']) ){
    
    die('Yêu cầu không hợp lệ');
}


$input = @file_get_contents("php://input");
define('SQUAD_SECRET_KEY', $CMSNT->site('squadco_Secret_Key'));

if($headers['x-squad-encrypted-body'] !== strtoupper(hash_hmac('sha512', $input, SQUAD_SECRET_KEY))){
    die('Xác minh webhook thất bại');
}
 
$body = json_decode($input, true);
$body = $body['Body'];
$amount = floor(check_string($body['amount'])/100);

if(isset($body['currency']) && $body['currency'] != $CMSNT->site('squadco_currency_code')){
    die('Currency không hợp lệ');
}
if($CMSNT->get_row(" SELECT * FROM `payment_squadco` WHERE `transaction_ref` = '".check_string($body['transaction_ref'])."' AND `amount` = '$amount' ")){
    die('Đơn này xử lý rồi');
}
if(!$getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `email` = '".check_string($body['email'])."' ")){
    die('Email user không tồn tại trong hệ thống');
}

 

$price = $amount * $CMSNT->site('squadco_rate');
$isInsert = $CMSNT->insert('payment_squadco', [
    'user_id'           => $getUser['id'],
    'transaction_ref'   => check_string($body['transaction_ref']),
    'amount'            => $amount,
    'price'             => $price,
    'create_gettime'    => gettime()
]);
if($isInsert){
    $user = new users;
    $user->AddCredits($getUser['id'], $price, __('Recharge Squadco').' #'.check_string($body['transaction_ref']));
}
exit();