<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../../libs/db.php');
    require_once(__DIR__.'/../../config.php');
    require_once(__DIR__.'/../../libs/helper.php');
    require_once(__DIR__.'/../../libs/database/users.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_service_otp_history')) {
        if (time() - $CMSNT->site('check_time_cron_service_otp_history') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron_service_otp_history' ");


    foreach($CMSNT->get_list(" SELECT * FROM `otp_history` WHERE `status` = 1 ") as $row){

        if($CMSNT->site('server_thuesim') == 'API_1'){
            $data = curl_get($CMSNT->site('domain_thuesim').'api?act=code&apik='.$CMSNT->site('token_thuesim').'&id='.$row['id_order_api']);
            $data = json_decode($data, true);
            if($data['ResponseCode'] == 2){
                $isUpdate = $CMSNT->update('otp_history', [
                    'status'    => $data['ResponseCode'],
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                if($isUpdate){
                    $user = new users();
                    $user->AddCredits($row['user_id'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                }
                continue;
            }
            if($data['ResponseCode'] == 3){
                $isUpdate = $CMSNT->update('otp_history', [
                    'status'    => $data['ResponseCode'],
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                if($isUpdate){
                    $user = new users();
                    $user->AddCredits($row['user_id'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                }
                continue;
            }
            if($data['ResponseCode'] == 0){
                $isUpdate = $CMSNT->update('otp_history', [
                    'status'    => $data['ResponseCode'],
                    'code'      => $data['Result']['Code'],
                    'sms'      => $data['Result']['SMS'],
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                continue;
            }
        }

        if($CMSNT->site('server_thuesim') == 'API_2'){
            $data = array('order_id' => $row['id_order_api']);
            $data = json_encode($data);
            $ch = curl_init($CMSNT->site('domain_thuesim')."api/sms/order");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer '.$CMSNT->site('token_thuesim') 
            )
            );
            echo $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result, true);
 
            if($data['success'] != true){
                // $isUpdate = $CMSNT->update('otp_history', [
                //     'status'    => 2,
                //     'sms'       => $data['error'],
                //     'update_time'   => time()
                // ], " `id` = '".$row['id']."' AND `status` = 1 ");
                // if($isUpdate){
                //     $user = new users();
                //     $user->AddCredits($row['user_id'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                // }
                continue;
            }
            $data = $data['data'];
            if($data['status'] == 4){
                $isUpdate = $CMSNT->update('otp_history', [
                    'status'    => 2,
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                if($isUpdate){
                    $user = new users();
                    $user->AddCredits($row['user_id'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                }
                continue;
            }
            if($data['status'] == 0){
                $CMSNT->update('otp_history', [
                    'number'    => $data['phone'],
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                continue;
            }

            if($data['status'] == 1){
                $isUpdate = $CMSNT->update('otp_history', [
                    'status'    => 0,
                    'code'      => $data['code'],
                    'sms'      => $data['message'],
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                continue;
            }

        }

        if($CMSNT->site('server_thuesim') == 'API_3'){
            $data = curl_get($CMSNT->site('domain_thuesim').'session/getv2?requestId='.$row['id_order_api'].'&token='.$CMSNT->site('token_thuesim'));
            $data = json_decode($data, true);
            // if($data['status_code'] == -2){
            //     $isUpdate = $CMSNT->update('otp_history', [
            //         'status'    => 3,
            //         'update_time'   => time()
            //     ], " `id` = '".$row['id']."' AND `status` = 1 ");
            //     continue;
            // }
            if($data['status_code'] == 200){
                if($data['data']['Status'] == 2){
                    $isUpdate = $CMSNT->update('otp_history', [
                        'status'        => 2,
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 1 ");
                    if($isUpdate){
                        $user = new users();
                        $user->AddCredits($row['user_id'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                    }
                    continue;
                }
                if($data['data']['Status'] == 1){
                    $sms = '';
                    if($row['data']['IsSound'] == false){
                        $sms = $data['data']['SmsContent'];
                    }
                    $CMSNT->update('otp_history', [
                        'status'    => 0,
                        'code'      => $data['data']['Code'],
                        'sms'      => $sms = '',
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 1 ");
                    continue;
                }
            }
        }

        if($CMSNT->site('server_thuesim') == 'API_4'){
            $data = curl_get($CMSNT->site('domain_thuesim').'api?action=code&id='.$row['id_order_api'].'&apikey='.$CMSNT->site('token_thuesim'));
            $data = json_decode($data, true);
            if(isset($data['ResponseCode'])){
                if($data['ResponseCode'] == 0){
                    $CMSNT->update('otp_history', [
                        'status'    => 0,
                        'code'      => $data['Result']['otp'],
                        'sms'      => $data['Result']['SMS'],
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 1 ");
                    continue;
                }
                if(time() - strtotime($row['create_gettime']) >= 300 && $data['ResponseCode'] == 1){
                    $isUpdate = $CMSNT->update('otp_history', [
                        'status'        => 2,
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 1 ");
                    if($isUpdate){
                        $user = new users();
                        $user->AddCredits($row['user_id'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                    }
                    continue;
                }

            }
        }

        if($CMSNT->site('server_thuesim') == 'API_5'){
            $data = curl_get($CMSNT->site('domain_thuesim').'api/?action=get_code&id='.$row['id_order_api'].'&key='.$CMSNT->site('token_thuesim'));
            $data = json_decode($data, true);
            if(isset($data['otp_code'])){
                if($data['otp_code'] == 'timeout'){
                    $isUpdate = $CMSNT->update('otp_history', [
                        'status'        => 2,
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 1 ");
                    if($isUpdate){
                        $user = new users();
                        $user->AddCredits($row['user_id'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                    }
                    continue;
                }else if($data['otp_code'] == 'is_comming'){
                    continue;
                }
                else{
                    $CMSNT->update('otp_history', [
                        'status'    => 0,
                        'code'      => $data['otp_code'],
                        'sms'      => $data['otp_code'],
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 1 ");
                    continue;
                }
            }
        }


    }