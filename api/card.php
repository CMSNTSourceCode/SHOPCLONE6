<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/lang.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
$User = new users();
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
    die('status_website_off');
}
if ($CMSNT->site('status_napthe') != 1) {
    die('status_card_off');
}
/** CALLBACK */
if(isset($_GET['request_id']) && isset($_GET['callback_sign'])){
    $status = check_string($_GET['status']);
    $message = check_string($_GET['message']);
    $request_id = check_string($_GET['request_id']); // request id
    $declared_value = check_string($_GET['declared_value']); //Giá trị khai báo
    $value = check_string($_GET['value']); //Giá trị thực của thẻ
    $amount = check_string($_GET['amount']); //Số tiền nhận được
    $code = check_string($_GET['code']);
    $serial = check_string($_GET['serial']);
    $telco = check_string($_GET['telco']);
    $trans_id = check_string($_GET['trans_id']); //Mã giao dịch bên chúng tôi
    $callback_sign = check_string($_GET['callback_sign']);

    if($callback_sign != md5($CMSNT->site('partner_key_card').$code.$serial)){
        die('callback_sign_error');
    }
    //$code = check_string($_GET['content']);
    if (!$row = $CMSNT->get_row(" SELECT * FROM `cards` WHERE `trans_id` = '$request_id' AND `status` = 0 ")) {
        die('request_id_error');
    }

    if($status == 1){
        if($CMSNT->site('ck_napthe') == 0){
            $price = $amount;
        }else{
            $price = $value - $value * $CMSNT->site('ck_napthe') / 100;
        }
        $CMSNT->update("cards", array(
            'status'        => 1,
            'price'         => $price,
            'update_date'    => gettime()
        ), " `id` = '".$row['id']."' ");
        $User->AddCredits($row['user_id'], $price, "Nạp thẻ cào Seri ".$row['serial']." - Pin ".$row['pin']." ", 'TOPUP_CARD_'.$row['pin']);

        /** SEND NOTI CHO ADMIN */
        $my_text = $CMSNT->site('naptien_notification');
        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
        $my_text = str_replace('{method}', 'Thẻ Cào', $my_text);
        $my_text = str_replace('{amount}', $value, $my_text);
        $my_text = str_replace('{price}', $price, $my_text);
        $my_text = str_replace('{time}', gettime(), $my_text);
        sendMessAdmin($my_text);

        die('payment.success');
    }
    else{
        $CMSNT->update("cards", array(
            'status'        => 2,
            'price'         => 0,
            'update_date'   => gettime(),
            'reason'        => 'Thẻ cào không hợp lệ hoặc đã được sử dụng'
        ), " `id` = '".$row['id']."' ");
        exit('payment.error');
    }
}







