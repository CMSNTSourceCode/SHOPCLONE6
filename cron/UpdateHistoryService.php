<?php
define("IN_SITE", true);
require_once(__DIR__.'/../libs/db.php');
require_once(__DIR__.'/../config.php');
require_once(__DIR__.'/../libs/helper.php');
require_once(__DIR__.'/../libs/lang.php');
require_once(__DIR__.'/../libs/5gsmm.php');
require_once(__DIR__.'/../libs/database/users.php');


$CMSNT = new DB;

/* START CHỐNG SPAM */
if (time() > $CMSNT->site('check_time_cron_UpdateHistory5gsmm')) {
    if (time() - $CMSNT->site('check_time_cron_UpdateHistory5gsmm') < 3) {
        die('Thao tác quá nhanh, vui lòng đợi');
    }
}

$CMSNT->update("settings", [
    'value' => time()
], " `name` = 'check_time_cron_UpdateHistory5gsmm' ");
 
if ($CMSNT->site('status_buff_like_sub') != 1) {
    die(json_encode([
        'status' => 'error',
        'msg'   => __('Chức năng này đang bảo trì')
    ]));
}
foreach($CMSNT->get_list(" SELECT id_api FROM `order_service` WHERE `status` = 'Pending' OR `status` = 'In progress' OR `status` = 'Processing' OR `status` = '' AND `id_api` != '' ORDER BY RAND() LIMIT 100 ") as $get_order_id){
    if($get_order_id['id_api'] != ''){
        $order_id[] = $get_order_id['id_api'];  
    }
}
$api = new Api($CMSNT->site('token_5gsmm'));
$statuses = $api->multiStatus($order_id);
//echo json_encode($order_id);
foreach($statuses as $order_id => $status){

    if($row = $CMSNT->get_row(" SELECT * FROM `order_service` WHERE `id_api` = '$order_id' ")){
        if($status['status'] == 'Canceled'){
            $rate = $row['price'] / $row['amount'];
            $refund = $rate * $status['remains'];
            $user = new users();
            $user->AddCredits($row['buyer'], $refund, "Hoàn tiền đơn hàng mua tương tác #".$row['trans_id']." số lượng còn lại ".$status['remains']);
            $CMSNT->update('order_service', [
                'remains'   => $status['remains'],
                'status'    => $status['status'],
                'refund'    => 1
            ], " `id` = '".$row['id']."' ");
        }
        $CMSNT->update('order_service', [
            'remains'   => $status['remains'],
            'status'    => $status['status']
        ], " `id` = '".$row['id']."' ");
        echo ' xử lý thành công 1 đơn '.$order_id.' | '.$status['status'].'<br>';
    }

}

// echo json_encode($statuses);