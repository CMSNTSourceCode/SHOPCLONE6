<?php
define("IN_SITE", true);
require_once(__DIR__.'/../libs/db.php');
require_once(__DIR__.'/../config.php');
require_once(__DIR__.'/../libs/helper.php');
require_once(__DIR__.'/../libs/lang.php');
require_once(__DIR__.'/../libs/5gsmm.php');

$CMSNT = new DB;

/* START CHỐNG SPAM */
if (time() > $CMSNT->site('check_time_cron_UpdateRate5gsmm')) {
    if (time() - $CMSNT->site('check_time_cron_UpdateRate5gsmm') < 10) {
        die('Thao tác quá nhanh, vui lòng đợi');
    }
}

$CMSNT->update("settings", [
    'value' => time()
], " `name` = 'check_time_cron_UpdateRate5gsmm' ");

if ($CMSNT->site('status_buff_like_sub') != 1) {
    die(json_encode([
        'status' => 'error',
        'msg'   => __('Chức năng này đang bảo trì')
    ]));
}

$api = new Api($CMSNT->site('token_5gsmm'));
$services = $api->services(); # return all services

foreach($services as $row){
    if($row['type'] == 'Subscriptions'){
        continue;
    }
    if(!$CMSNT->get_row("SELECT * FROM `category_service` WHERE `name` = '".$row['category']."' ")){
        $CMSNT->insert('category_service', [
            'name'      => $row['category'],
            'display'   => 1
        ]);
        echo 'Thêm category '.$row['category'].' thành công ! <br>';
     }
    if(!$service = $CMSNT->get_row("SELECT * FROM `services` WHERE `name` = '".$row['name']."' ")){
        // LẤY GIÁ SỐ LƯỢNG 1
        $rate   = $row['rate'] / 1000;
        // CHUYỂN ĐỔI GIÁ USD SANG VNĐ
        $rate   = $rate * $CMSNT->site('rate_vnd_5gsmm');
        $ck     = $rate * $CMSNT->site('ck_rate_service') / 100;
        $price  = $rate + $ck;
        $isInsert = $CMSNT->insert('services', [
            'name'              => $row['name'],
            'category_id'       => $CMSNT->get_row(" SELECT * FROM `category_service` WHERE `name` = '".$row['category']."' ")['id'],
            'type'              => $row['type'],
            'price'             => $price,
            'cost'              => $price,
            'min'               => $row['min'],
            'max'               => $row['max'],
            'id_api'            => $row['service'],
            'dripfeed'          => $row['dripfeed'],
            'refill'            => $row['refill'],
            'cancel'            => $row['cancel'],
            'status'            => 1,
            'content'           => '',
            'source_api'        => '5gsmm.com',
            'update_time'       => time()
        ]);
        if($isInsert){
            echo '[<b style="color:green;">CREATE</b>] Thêm sản phẩm '.$row['name'].' thành công ! <br>';
        }
    }else{
        // LẤY GIÁ SỐ LƯỢNG 1
        $rate   = $row['rate'] / 1000;
        // CHUYỂN ĐỔI GIÁ USD SANG VNĐ
        $rate   = $rate * $CMSNT->site('rate_vnd_5gsmm');
        if($CMSNT->site('status_updatec_rate_service') == 1){
            $ck     = $rate * $CMSNT->site('ck_rate_service') / 100;
            $price  = $rate + $ck;
        }else{
            $price = $service['price'];
        }
        $isUpdate = $CMSNT->update('services', [
            'cost'              => $rate,
            'price'             => $price,
            'name'              => $row['name'],
            'type'              => $row['type'],
            'min'               => $row['min'],
            'max'               => $row['max'],
            'id_api'            => $row['service'],
            'dripfeed'          => $row['dripfeed'],
            'refill'            => $row['refill'],
            'cancel'            => $row['cancel'],
            'update_time'       => time()
        ], " `id` = '".$service['id']."' ");
        if($isUpdate){
            echo '[<b style="color:red;">UPDATE</b>] Cập nhật sản phẩm '.$row['name'].' thành công ! <br>';          
        }

    }
}


$CMSNT->remove('services', "  ".time()." - `update_time` >= 3600 ");
 
die('success!');