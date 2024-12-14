<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/lang.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
$User = new users();
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();
 
 

 if(isset($_POST['order_id']) && isset($_POST['billcode'])){

    $order_id = check_string($_POST['order_id']);
    $billcode = check_string($_POST['billcode']);
    $status = check_string($_POST['status']);
 

    if($row = $CMSNT->get_row(" SELECT * FROM `toyyibpay_transactions` WHERE `trans_id` = '$order_id' AND `status` = 0 AND `BillCode` = '$billcode' ")){

        if($status == 1){
            $isUpdate = $CMSNT->update('toyyibpay_transactions', [
                'status'    => 1,
                'update_date'   => gettime()
            ], " `id` = '".$row['id']."' ");
            if($isUpdate){
                $amount = $amount / 100;
                $received = $row['amount'] * $CMSNT->site('rate_toyyibpay');
                $User->AddCredits($row['user_id'], $received, 'Automatic top-up via Malaysian bank #'.$billcode);
            }
        }else if($status == 3){
            $CMSNT->update('toyyibpay_transactions', [
                'status'    => 2,
                'update_date'   => gettime()
            ], " `id` = '".$row['id']."' ");
        }

    }   


 }


 