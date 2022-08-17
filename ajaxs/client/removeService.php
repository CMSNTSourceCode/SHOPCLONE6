<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");

$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();


if (isset($_POST['id'])) {
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    $id = check_string($_POST['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `order_autofb` WHERE `id` = '$id' AND `user_id` = '".$getUser['id']."'  ")) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __('Đơn hàng không tồn tại trong hệ thống')
        ]);
        die($data);
    }
    if($row['status'] != 0){
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __('Đơn hàng này không thể huỷ')
        ]);
        die($data);
    }


 
    if(isset($_POST['app']) && $_POST['app'] == 'facebook_buff'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $CMSNT->site('domain_autofb').'api/facebook_buff/removeorder/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "id_remove": '.$row['insertId'].',
            "type_api": "'.check_string($_POST['type']).'"
        }',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb'),
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
    }


    if($response['status'] == 200){
        $isRemove = $CMSNT->update("order_autofb", [
            'status'   => 2
        ], " `id` = '".$row['id']."' ");
        if($isRemove){
            $Mobile_Detect = new Mobile_Detect();
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => __('Huỷ đơn dịch vụ').' (#'.$row['trans_id'].')'
            ]);
            $data = json_encode([
                'status'    => 'success',
                'msg'       => __($response['message'])
            ]);
            die($data);
        }
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __('Vui lòng liên hệ Developer')
        ]);
        die($data);
    }
    else{
        $data = json_encode([
            'status'    => 'error',
            'msg'       => __($response['message'])
        ]);
        die($data);
    }
}
