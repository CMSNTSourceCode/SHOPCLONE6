<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    $CMSNT = new DB();


    function convert_status($status){
        if($status == 0){
            return 1;
        }else if($status == 1){
            return 0;
        }else if($status == 3){
            return 2;
        }else{
            return 0;
        }
    }



    if(isset($_GET['type']) && $_GET['type'] == 'buffsub-sale'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list?type_api=buff_sub_sale&limit=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => $data['subscribers'],
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }

    if(isset($_GET['type']) && $_GET['type'] == 'buffsub-speed'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list?type_api=buff_sub&limit=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => $data['subscribers'],
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }
    
    if(isset($_GET['type']) && $_GET['type'] == 'buffsub-slow'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list?type_api=buff_sub_slow&limit=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => $data['subscribers'],
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }

    if(isset($_GET['type']) && $_GET['type'] == 'bufflikefanpagesale'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list?type_api=like_page_sale&limit=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => $data['subscribers'],
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }

    if(isset($_GET['type']) && $_GET['type'] == 'bufflikefanpage'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list?type_api=like_page&limit=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => $data['subscribers'],
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }

    if(isset($_GET['type']) && $_GET['type'] == 'buffsubfanpage'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list?type_api=sub_page&limit=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => $data['subscribers'],
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }

    if(isset($_GET['type']) && $_GET['type'] == 'bufflikecommentsharelike'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list/?type_api=buff_likecommentshare&limit=0&obj_search=like,like_clone,like_v2,like_v3,like_v4,like_v5,like_v6,like_v7',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => $data['subscribers'],
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }

    if(isset($_GET['type']) && $_GET['type'] == 'bufflikecommentshareshare'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list/?type_api=buff_likecommentshare&limit=0&obj_search=share,share_sv2,share_sv3,share_sv4,share_sv5',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => $data['subscribers'],
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }

    if(isset($_GET['type']) && $_GET['type'] == 'buffviewstory'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/list?type_api=buffviewstory&type=0&limit=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'ht-token: '.$CMSNT->site('token_autofb')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        foreach($response['data'] as $data){
            $CMSNT->update("order_autofb", [
                'count_success' => $data['count_success'],
                'payment_api'   => $data['prices'],
                'subscribers'   => 0,
                'status'        => convert_status($data['status']),
                'update_time'   => time(),
                'update_gettime'    => gettime()
            ], " `type` = '".check_string($_GET['type'])."' AND `status` = 0 AND `insertId` = '".$data['id']."' ");
        }
    }