<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


/** BUFF FOLLOW SALE */
function getPrice_buffsub_sale($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "dataform": {
            "locnangcao": 0,
            "locnangcao_gt": 0,
            "locnangcao_dotuoi_start": 0,
            "locnangcao_dotuoi_end": 0,
            "locnangcao_banbe_start": 0,
            "locnangcao_banbe_end": 0,
            "profile_user": "100038641389494",
            "loaiseeding": '.$loaiseeding.',
            "baohanh": 0,
            "sltang": 1000,
            "giatien": 1,
            "ghichu": "",
            "startDatebh": "2022-04-23T18:28:58.219Z",
            "EndDatebh": "2022-05-01T18:28:58.219Z"
          },
    "type_api": "buff_sub_sale"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_buffsub_sale($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "dataform": {
        "locnangcao": 0,
        "locnangcao_gt": 0,
        "locnangcao_dotuoi_start": 0,
        "locnangcao_dotuoi_end": 0,
        "locnangcao_banbe_start": 0,
        "locnangcao_banbe_end": 0,
        "profile_user": "'.$uid.'",
        "loaiseeding": '.$loaiseeding.',
        "baohanh": 0,
        "sltang": '.$amount.',
        "giatien": '.getPrice_buffsub_sale($loaiseeding).',
        "ghichu": "'.$ghichu.'",
        "startDatebh": "2022-04-23T18:28:58.219Z",
        "EndDatebh": "2022-05-01T18:28:58.219Z"
    },
    "type_api": "buff_sub_sale"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

/** BUFF FOLLOW SPEED */
function getPrice_buffsub_speed($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "dataform": {
            "locnangcao": 0,
            "locnangcao_gt": 0,
            "locnangcao_dotuoi_start": 0,
            "locnangcao_dotuoi_end": 0,
            "locnangcao_banbe_start": 0,
            "locnangcao_banbe_end": 0,
            "profile_user": "100038641389494",
            "loaiseeding": '.$loaiseeding.',
            "baohanh": 0,
            "sltang": 1000,
            "giatien": 1,
            "ghichu": "",
            "startDatebh": "2022-04-23T18:28:58.219Z",
            "EndDatebh": "2022-05-01T18:28:58.219Z"
          },
    "type_api": "buff_sub"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_buffsub_speed($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "dataform": {
        "locnangcao": 0,
        "locnangcao_gt": 0,
        "locnangcao_dotuoi_start": 0,
        "locnangcao_dotuoi_end": 0,
        "locnangcao_banbe_start": 0,
        "locnangcao_banbe_end": 0,
        "profile_user": "'.$uid.'",
        "loaiseeding": '.$loaiseeding.',
        "baohanh": 0,
        "sltang": '.$amount.',
        "giatien": '.getPrice_buffsub_speed($loaiseeding).',
        "ghichu": "'.$ghichu.'",
        "startDatebh": "2022-04-23T18:28:58.219Z",
        "EndDatebh": "2022-05-01T18:28:58.219Z"
    },
    "type_api": "buff_sub"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

/** BUFF FOLLOW ĐỀ XUẤT */
function getPrice_buffsub_slow($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "dataform": {
            "locnangcao": 0,
            "locnangcao_gt": 0,
            "locnangcao_dotuoi_start": 0,
            "locnangcao_dotuoi_end": 0,
            "locnangcao_banbe_start": 0,
            "locnangcao_banbe_end": 0,
            "profile_user": "100038641389494",
            "loaiseeding": '.$loaiseeding.',
            "baohanh": 0,
            "sltang": 1000,
            "giatien": 1,
            "ghichu": "",
            "startDatebh": "2022-04-23T18:28:58.219Z",
            "EndDatebh": "2022-05-01T18:28:58.219Z"
          },
    "type_api": "buff_sub_slow"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_buffsub_slow($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "dataform": {
        "locnangcao": 0,
        "locnangcao_gt": 0,
        "locnangcao_dotuoi_start": 0,
        "locnangcao_dotuoi_end": 0,
        "locnangcao_banbe_start": 0,
        "locnangcao_banbe_end": 0,
        "profile_user": "'.$uid.'",
        "loaiseeding": '.$loaiseeding.',
        "baohanh": 0,
        "sltang": '.$amount.',
        "giatien": '.getPrice_buffsub_slow($loaiseeding).',
        "ghichu": "'.$ghichu.'",
        "startDatebh": "2022-04-23T18:28:58.219Z",
        "EndDatebh": "2022-05-01T18:28:58.219Z"
    },
    "type_api": "buff_sub_slow"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

/** BUFF LIKE FANPAGE SALE */
function getPrice_bufflikefanpagesale($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "dataform": {
            "locnangcao": 0,
            "locnangcao_gt": 0,
            "locnangcao_dotuoi_start": 0,
            "locnangcao_dotuoi_end": 0,
            "locnangcao_banbe_start": 0,
            "locnangcao_banbe_end": 0,
            "profile_user": "101009158325461",
            "loaiseeding": '.$loaiseeding.',
            "baohanh": 0,
            "sltang": 1000,
            "giatien": 1,
            "ghichu": "",
            "startDatebh": "2022-04-23T18:28:58.219Z",
            "EndDatebh": "2022-05-01T18:28:58.219Z"
          },
    "type_api": "like_page_sale"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_bufflikefanpagesale($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "dataform": {
        "locnangcao": 0,
        "locnangcao_gt": 0,
        "locnangcao_dotuoi_start": 0,
        "locnangcao_dotuoi_end": 0,
        "locnangcao_banbe_start": 0,
        "locnangcao_banbe_end": 0,
        "profile_user": "'.$uid.'",
        "loaiseeding": '.$loaiseeding.',
        "baohanh": 0,
        "sltang": '.$amount.',
        "giatien": '.getPrice_bufflikefanpagesale($loaiseeding).',
        "ghichu": "'.$ghichu.'",
        "startDatebh": "2022-04-23T18:28:58.219Z",
        "EndDatebh": "2022-05-01T18:28:58.219Z"
    },
    "type_api": "like_page_sale"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

/** BUFF LIKE FANPAGE */
function getPrice_bufflikefanpage($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "dataform": {
            "locnangcao": 0,
            "locnangcao_gt": 0,
            "locnangcao_dotuoi_start": 0,
            "locnangcao_dotuoi_end": 0,
            "locnangcao_banbe_start": 0,
            "locnangcao_banbe_end": 0,
            "profile_user": "101009158325461",
            "loaiseeding": '.$loaiseeding.',
            "baohanh": 0,
            "sltang": 1000,
            "giatien": 1,
            "ghichu": "",
            "startDatebh": "2022-04-23T18:28:58.219Z",
            "EndDatebh": "2022-05-01T18:28:58.219Z"
          },
    "type_api": "like_page"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_bufflikefanpage($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "dataform": {
        "locnangcao": 0,
        "locnangcao_gt": 0,
        "locnangcao_dotuoi_start": 0,
        "locnangcao_dotuoi_end": 0,
        "locnangcao_banbe_start": 0,
        "locnangcao_banbe_end": 0,
        "profile_user": "'.$uid.'",
        "loaiseeding": '.$loaiseeding.',
        "baohanh": 0,
        "sltang": '.$amount.',
        "giatien": '.getPrice_bufflikefanpage($loaiseeding).',
        "ghichu": "'.$ghichu.'",
        "startDatebh": "2022-04-23T18:28:58.219Z",
        "EndDatebh": "2022-05-01T18:28:58.219Z"
    },
    "type_api": "like_page"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

/** BUFF SUB FANPAGE */
function getPrice_buffsubfanpage($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    // convert uid để chạy cho 2 fanpage pro5 vs page thường
    if($loaiseeding == 1){
        $uid = '101009158325461';
    }else{
        $uid = '100063510428035';
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "dataform": {
            "locnangcao": 0,
            "locnangcao_gt": 0,
            "locnangcao_dotuoi_start": 0,
            "locnangcao_dotuoi_end": 0,
            "locnangcao_banbe_start": 0,
            "locnangcao_banbe_end": 0,
            "profile_user": "'.$uid.'",
            "loaiseeding": '.$loaiseeding.',
            "baohanh": 0,
            "sltang": 1000,
            "giatien": 1,
            "ghichu": "",
            "startDatebh": "2022-04-23T18:28:58.219Z",
            "EndDatebh": "2022-05-01T18:28:58.219Z"
          },
    "type_api": "sub_page"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_buffsubfanpage($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "dataform": {
        "locnangcao": 0,
        "locnangcao_gt": 0,
        "locnangcao_dotuoi_start": 0,
        "locnangcao_dotuoi_end": 0,
        "locnangcao_banbe_start": 0,
        "locnangcao_banbe_end": 0,
        "profile_user": "'.$uid.'",
        "loaiseeding": '.$loaiseeding.',
        "baohanh": 0,
        "sltang": '.$amount.',
        "giatien": '.getPrice_buffsubfanpage($loaiseeding).',
        "ghichu": "'.$ghichu.'",
        "startDatebh": "2022-04-23T18:28:58.219Z",
        "EndDatebh": "2022-05-01T18:28:58.219Z"
    },
    "type_api": "sub_page"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

/** BUFF LIKE */
function getPrice_bufflikecommentshare($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "dataform": {
            "locnangcao": 0,
            "locnangcao_gt": 0,
            "locnangcao_dotuoi_start": 0,
            "locnangcao_dotuoi_end": 13,
            "locnangcao_banbe_start": 0,
            "locnangcao_banbe_end": 100,
            "profile_user": "666729844625056",
            "loaiseeding": "'.$loaiseeding.'",
            "baohanh": 0,
            "sltang": 1000,
            "giatien": 1,
            "ghichu": "",
            "startDatebh": "2022-04-23T18:28:58.219Z",
            "EndDatebh": "2022-05-01T18:28:58.219Z",
            "type": "",
            "tocdolike": 0,
            "list_messages": []
          },
    "type_api": "buff_likecommentshare"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_bufflikecommentshare($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "dataform": {
        "locnangcao": 0,
        "locnangcao_gt": 0,
        "locnangcao_dotuoi_start": 0,
        "locnangcao_dotuoi_end": 13,
        "locnangcao_banbe_start": 0,
        "locnangcao_banbe_end": 100,
        "profile_user": "'.$uid.'",
        "loaiseeding": "'.$loaiseeding.'",
        "baohanh": 0,
        "sltang": '.$amount.',
        "giatien": '.getPrice_bufflikecommentshare($loaiseeding).',
        "ghichu": "'.$ghichu.'",
        "startDatebh": "2022-04-23T18:28:58.219Z",
        "EndDatebh": "2022-05-01T18:28:58.219Z",
        "type": "",
        "tocdolike": 0,
        "list_messages": []
    },
    "type_api": "buff_likecommentshare"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

/** BUFF SHARE PROFILE */
function getPrice_bufflikecommentshareshare($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "dataform": {
            "locnangcao": 0,
            "locnangcao_gt": 0,
            "locnangcao_dotuoi_start": 0,
            "locnangcao_dotuoi_end": 13,
            "locnangcao_banbe_start": 0,
            "locnangcao_banbe_end": 100,
            "profile_user": "658240532140654",
            "loaiseeding": "'.$loaiseeding.'",
            "baohanh": 0,
            "sltang": 1000,
            "giatien": 1,
            "ghichu": "",
            "startDatebh": "2022-04-23T18:28:58.219Z",
            "EndDatebh": "2022-05-01T18:28:58.219Z",
            "type": "",
            "tocdolike": 0,
            "list_messages": []
          },
    "type_api": "buff_likecommentshare"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_bufflikecommentshareshare($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "dataform": {
        "locnangcao": 0,
        "locnangcao_gt": 0,
        "locnangcao_dotuoi_start": 0,
        "locnangcao_dotuoi_end": 13,
        "locnangcao_banbe_start": 0,
        "locnangcao_banbe_end": 100,
        "profile_user": "'.$uid.'",
        "loaiseeding": "'.$loaiseeding.'",
        "baohanh": 0,
        "sltang": '.$amount.',
        "giatien": '.getPrice_bufflikecommentshareshare($loaiseeding).',
        "ghichu": "'.$ghichu.'",
        "startDatebh": "2022-04-23T18:28:58.219Z",
        "EndDatebh": "2022-05-01T18:28:58.219Z",
        "type": "",
        "tocdolike": 0,
        "list_messages": []
    },
    "type_api": "buff_likecommentshare"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

/** BUFF VIEW STORI */
function getPrice_buffviewstory($loaiseeding){
    error_reporting(0);
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "lhi": "106539713977408",
        "url": "UzpfSVNDOjY5MjEyOTQ0NTMzMzcxNA==",
        "lsct": "0",
        "slct": "100",
        "gc": "",
        "gtmtt": 1,
        "type_api": "buffviewstory"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if($data = explode('Giá thấp nhất của chức năng là ', $data['message'])[1]){
        $data = explode('!', $data)[0];
        return $data;
    }else{
        return 0;
    }
}
function order_buffviewstory($uid, $loaiseeding, $amount, $ghichu){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/facebook_buff/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "lhi": "'.explode('/', $uid)[0].'",
        "url": "'.explode('/', $uid)[1].'",
        "lsct": "0",
        "slct": "'.$amount.'",
        "gc": "",
        "gtmtt": '.getPrice_buffviewstory($loaiseeding).',
        "type_api": "buffviewstory"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}

function getUID_AutoFB($url){
    $CMSNT = new DB;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cmslike.com/api/checklinkfb/check/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "link": "'.$url.'"
    }',
    CURLOPT_HTTPHEADER => array(
        'ht-token: '.$CMSNT->site('token_autofb'),
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    //return $response;
    return json_decode($response, true);
}