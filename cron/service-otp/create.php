<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../../libs/db.php');
    require_once(__DIR__.'/../../config.php');
    require_once(__DIR__.'/../../libs/helper.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_service_otp_cron')) {
        if (time() - $CMSNT->site('check_time_cron_service_otp_cron') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron_service_otp_cron' ");

    if($CMSNT->site('status_thuesim') != 1){
        die('Chức năng này đang tắt');
    }
    if($CMSNT->site('server_thuesim') == ''){
        die('Vui lòng chọn server');
    }


    if($CMSNT->site('server_thuesim') == 'API_1'){
        $data = curl_get($CMSNT->site('domain_thuesim').'api?act=app&apik='.$CMSNT->site('token_thuesim'));
        $data = json_decode($data, true);
        if($data['ResponseCode'] != 0){
            die($data['Msg']);
        }
        foreach($data['Result'] as $row){
            $id_api = check_string($row['Id']);
            $name_api = check_string($row['Name']);
            $price_api = check_string($row['Cost']) * 1000;
            $price = $price_api;
            if($CMSNT->site('ck_rate_thuesim') != 0){
                $price = $price + $price * $CMSNT->site('ck_rate_thuesim') / 100;
            }
            if($service_otp = $CMSNT->get_row("SELECT * FROM `service_otp` WHERE `id_api` = '$id_api' AND `server` = '".$CMSNT->site('server_thuesim')."' ")){
                if($CMSNT->site('ck_rate_thuesim') == 0){
                    $price = $service_otp['price'];
                }
                // UPDATE
                $CMSNT->update('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'update_time'   => time()
                ], " `id` = '".$service_otp['id']."' " );
            }else{
                // INSERT
                $CMSNT->insert('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'status'    => 1,
                    'update_time'   => time()
                ]);
            }
        }
    }

    if($CMSNT->site('server_thuesim') == 'API_2'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $CMSNT->site('domain_thuesim').'api/sms/services',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$CMSNT->site('token_thuesim')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        if($data['success'] != true){
            die($data['error']);
        }
        foreach($data['data'] as $key => $value){
            foreach($value as $row){
                $id_api = check_string($row['id']);
                $name_api = check_string($key.' '.$row['display_name']);
                $price_api = check_string($row['price']);
                $price = $price_api;
                if($CMSNT->site('ck_rate_thuesim') != 0){
                    $price = $price + $price * $CMSNT->site('ck_rate_thuesim') / 100;
                }
                if($service_otp = $CMSNT->get_row("SELECT * FROM `service_otp` WHERE `id_api` = '$id_api' AND `server` = '".$CMSNT->site('server_thuesim')."' ")){
                    // UPDATE
                    $CMSNT->update('service_otp', [
                        'server'    => $CMSNT->site('server_thuesim'),
                        'id_api'    => $id_api,
                        'name_api'  => $name_api,
                        'name'      => $name_api,
                        'price_api' => $price_api,
                        'price'     => $price,
                        'update_time'   => time()
                    ], " `id` = '".$service_otp['id']."' " );
                }else{
                    // INSERT
                    $CMSNT->insert('service_otp', [
                        'server'    => $CMSNT->site('server_thuesim'),
                        'id_api'    => $id_api,
                        'name_api'  => $name_api,
                        'name'      => $name_api,
                        'price_api' => $price_api,
                        'price'     => $price,
                        'status'    => 1,
                        'update_time'   => time()
                    ]);
                }
            }
        }

    }

    if($CMSNT->site('server_thuesim') == 'API_3'){
        $data = curl_get($CMSNT->site('domain_thuesim').'service/getv2?token='.$CMSNT->site('token_thuesim').'&country=vn');
        $data = json_decode($data, true);
        if($data['status_code'] != 200){
            die($data['message']);
        }
        foreach($data['data'] as $row){
            $id_api = check_string($row['id']);
            $name_api = check_string($row['name']);
            $price_api = check_string($row['price']);
            $price = $price_api;
            if($CMSNT->site('ck_rate_thuesim') != 0){
                $price = $price + $price * $CMSNT->site('ck_rate_thuesim') / 100;
            }
            if($service_otp = $CMSNT->get_row("SELECT * FROM `service_otp` WHERE `id_api` = '$id_api' AND `server` = '".$CMSNT->site('server_thuesim')."' ")){
                // UPDATE
                $CMSNT->update('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'update_time'   => time()
                ], " `id` = '".$service_otp['id']."' " );
            }else{
                // INSERT
                $CMSNT->insert('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'status'    => 1,
                    'update_time'   => time()
                ]);
            }
        }
    }

    if($CMSNT->site('server_thuesim') == 'API_4'){
        $data = curl_get($CMSNT->site('domain_thuesim').'api?action=service&apikey='.$CMSNT->site('token_thuesim'));
        $data = json_decode($data, true);
        if(empty($data['Result'])){
            die($data);
        }
        foreach($data['Result'] as $row){
            $id_api = check_string($row['Code']);
            $name_api = check_string($row['Name']);
            $price_api = check_string($row['Price']);
            $price = $price_api;
            if($CMSNT->site('ck_rate_thuesim') != 0){
                $price = $price + $price * $CMSNT->site('ck_rate_thuesim') / 100;
            }
            if($service_otp = $CMSNT->get_row("SELECT * FROM `service_otp` WHERE `id_api` = '$id_api' AND `server` = '".$CMSNT->site('server_thuesim')."' ")){
                // UPDATE
                $CMSNT->update('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'update_time'   => time()
                ], " `id` = '".$service_otp['id']."' " );
            }else{
                // INSERT
                $CMSNT->insert('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'status'    => 1,
                    'update_time'   => time()
                ]);
            }
        }
    }
    
    if($CMSNT->site('server_thuesim') == 'API_5'){
        $data = curl_get($CMSNT->site('domain_thuesim').'api/?key='.$CMSNT->site('token_thuesim').'&action=get_all_services');
        $data = json_decode($data, true);
        if(!isset($data)){
            die('error');
        }
        foreach($data as $row){
            $id_api = check_string($row['id']);
            $name_api = check_string($row['name']);
            $price_api = intval(check_string($row['price']));
            $price = $price_api;
            if($CMSNT->site('ck_rate_thuesim') != 0){
                $price = $price + $price * $CMSNT->site('ck_rate_thuesim') / 100;
            }
            if($service_otp = $CMSNT->get_row("SELECT * FROM `service_otp` WHERE `id_api` = '$id_api' AND `server` = '".$CMSNT->site('server_thuesim')."' ")){
                // UPDATE
                $CMSNT->update('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'update_time'   => time()
                ], " `id` = '".$service_otp['id']."' " );
                echo '<b style="color:green;">UPDATE</b> - '.$name_api.'<br>';
            }else{
                // INSERT
                $CMSNT->insert('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'status'    => 1,
                    'update_time'   => time()
                ]);
                echo '<b style="color:red;">CREATE</b> - '.$name_api.'<br>';
            }
        }
    }

    // XOÁ DỊCH VỤ HẾT HẠN
    $CMSNT->remove('service_otp', " ".time()." - `update_time` >= 86164 ");