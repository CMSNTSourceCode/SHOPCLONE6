<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    $CMSNT = new DB();

    if($CMSNT->site('pin_cron') != ''){
        if(empty($_GET['pin'])){
            die('Vui lòng nhập mã PIN');
        }
        if($_GET['pin'] != $CMSNT->site('pin_cron')){
            die('Mã PIN không chính xác');
        }
    }

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_checklivefb')) {
        if (time() - $CMSNT->site('check_time_cron_checklivefb') < 3) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    /* Thời gian check live cách nhau mỗi giây */
    $timeCheck = $CMSNT->site('time_check_live');

    /* Số lượng tài khoản check trên mỗi sản phẩm mỗi phút */
    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron_checklivefb' ");


    // Khởi tạo mảng UIDs
    $uids = [];

    // Khởi tạo mảng chứa các thông tin về sản phẩm
    $products_info = [];

    $where_is_checklive = "";
    $products_list = $CMSNT->get_list("SELECT * FROM `products` WHERE `checklive` = 1");

    if (!empty($products_list)) {
        $product_ids = array_map(function($product) {
            return $product['id'];
        }, $products_list);
    
        $product_ids_str = implode(',', array_map('intval', $product_ids));
        $where_is_checklive = " AND `product_id` IN ($product_ids_str)";
    }else{
        die('Không có sản phẩm nào bật check live');
    }
    
    // Lấy danh sách sản phẩm từ CSDL hoặc bất kỳ nguồn dữ liệu nào khác
    $products = $CMSNT->get_list("SELECT * FROM `accounts` WHERE `buyer` IS NULL AND `status` = 'LIVE' $where_is_checklive ORDER BY `time_live` ASC LIMIT 100");

    
    // Lặp qua danh sách sản phẩm để tạo danh sách UIDs
    foreach ($products as $product) {
        // Kiểm tra xem UID đã tồn tại trong mảng UIDs chưa, nếu chưa thì thêm vào
        if (!in_array(explode("|", $product['account'])[0], $uids)) {
            $uids[] = explode("|", $product['account'])[0];
        }
        // Lưu thông tin sản phẩm vào mảng để sử dụng sau này
        $products_info[explode("|", $product['account'])[0]] = $product;
    }

    // Khởi tạo multi-curl handler
    $mh = curl_multi_init();
    $curl_handles = [];

    // Lặp qua danh sách UIDs để tạo các xử lý cURL riêng lẻ cho mỗi UID
    foreach ($uids as $uid) {
        $ch = curl_init();
        $url = "https://graph2.facebook.com/v3.3/{$uid}/picture?redirect=0";
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ]);
        curl_multi_add_handle($mh, $ch);
        $curl_handles[$uid] = $ch;
    }

    // Thực thi các yêu cầu đồng thời
    $running = null;
    do {
        curl_multi_exec($mh, $running);
    } while ($running > 0);


    // Lặp qua các xử lý cURL để lấy kết quả và xử lý
    foreach ($curl_handles as $uid => $ch) {
        $result = curl_multi_getcontent($ch);
        $info = curl_getinfo($ch);
        if ($info['http_code'] == 200) {
            $result_array = json_decode($result, true);
            if (isset($result_array['data']) && (!empty($result_array['data']['height']) || !empty($result_array['data']['width']))) {
                // UID live, cập nhật thời gian kiểm tra live
                $CMSNT->update("accounts", [
                    'status'    => 'LIVE',
                    'time_live' => time()
                ], " `id` = '".$products_info[$uid]['id']."' ");
                echo "UID: ".substr($uid, 0, 8)."*******, Result: LIVE <br>";
            } else {
                $CMSNT->update("accounts", [
                    'status'    => 'DIE',
                    'time_live' => time()
                ], " `id` = '".$products_info[$uid]['id']."' ");
                echo "UID: ".substr($uid, 0, 8)."*******, Result: DIE ".$result."<br>";
            }
        } else {
            $error_message = "UID: ".substr($uid, 0, 8)."*******, Result: ERROR, Error: " . $result;
            echo $error_message . "<br>";
        }
        // Đóng xử lý cURL
        curl_multi_remove_handle($mh, $ch);
        curl_close($ch);
    }

    // Đóng multi-curl handler
    curl_multi_close($mh);



