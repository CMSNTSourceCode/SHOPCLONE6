
<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/lang.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
 
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!empty($data)) {
        $idData = check_string($data['id']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/transactions/$idData/verify");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".$CMSNT->site('flutterwave_secretKey')
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $id = check_string($response['data']['id']);
        $txRef = check_string($response['data']['tx_ref']);
        $currency = check_string($response['data']['currency']);
        $amount = check_string($response['data']['amount']);
        $price = $amount * $CMSNT->site('flutterwave_rate');
        if ($response['data']['status'] == 'successful') {
            if($row = $CMSNT->get_row(" SELECT * FROM `payment_flutterwave` WHERE `tx_ref` = '$txRef' AND `currency` = '$currency' AND `status` = 'pending'  ")){
                $user = new users;
                $isCong = $user->AddCredits($row['user_id'], $price, __('Recharge Flutterwave').' #'.$id);
                if($isCong){
                    $CMSNT->update('payment_flutterwave', [
                        'status'   => 'success',
                        'update_gettime'    => gettime(),
                        'amount'    => $amount
                    ], " `id` = '".$row['id']."' AND `status` = 'pending' ");
                }
            }
        }
    }
}