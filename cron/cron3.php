<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/lang.php');
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
    if (time() > $CMSNT->site('check_time_cron3')) {
        if (time() - $CMSNT->site('check_time_cron3') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }

    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron3' ");

    // LẤY SẢN PHẨM TỪ API VỀ
    if($CMSNT->site('status_connect_api') == 1){
        // LẤY DANH SÁCH WEBSITE API
        foreach($CMSNT->get_list(" SELECT * FROM `connect_api` WHERE `status` = 1 AND `type` = 'API_1' ") as $website){
            // CẬP NHẬT GIÁ SẢN PHẨM
            $response = balance_API_1($website['domain'], $website['password']);
            $getPrice = json_decode($response, true);
            if($getPrice['status'] == true){
                $CMSNT->update('connect_api', [
                    'price' => format_currency($getPrice['balance'])
                ], " `id` = '".$website['id']."' ");
            }
            // CURL LẤY THÔNG TIN SẢN PHẨM TỪNG WEBSITE
            $data = curl_get2($website['domain'].'api/v1/categories');
            $data = json_decode($data, true);
            if(isset($data['data'])){
                foreach($data['data'] as $category){
                    // TÌM KHÔNG CÓ CHUYÊN MỤC TRONG HỆ THỐNG THÌ BẮT ĐẦU TẠO MỚI CHUYÊN MỤC
                    if(!$CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '".check_string($category['id'])."' AND `id_connect_api` = '".$website['id']."' ")){
                        $url_image = $CMSNT->site('favicon');
                        $CMSNT->insert('categories', [
                            'id_api'            => check_string($category['id']),
                            'id_connect_api'    => $website['id'],
                            'status'            => $CMSNT->site('default_api_product_status'),
                            'name'              => check_string($category['name']),
                            'image'             => $url_image
                        ]);
                        echo '<b style="color:red;">CREATE</b> - Tạo category '.check_string($category['name']).' thành công !<br>';
                    }
                    // CURL LẤY SẢN PHẨM
                    $list_product = curl_get2($website['domain'].'api/v1/category/'.$category['id']);
                    $list_product = json_decode($list_product, true);
                    foreach($list_product['data'] as $account){
                        $product_name = check_string($account['name']);
                        $ck = check_string($account['price']) * $website['ck_connect_api'] / 100;
                        $price = check_string($account['price']) + $ck;
                        if(!$rowProduct = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id_api` = '".check_string($account['id_product'])."' AND `id_connect_api` = '".$website['id']."' ")){
                            // LẤY ID CATEGORY
                            $id_api = $CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '".check_string($category['id'])."' AND `id_connect_api` = '".$website['id']."' ")['id'];
                            $CMSNT->insert('products', [
                                'user_id'           => $website['user_id'],
                                'category_id'       => !empty($id_api) ? $id_api : 0,
                                'id_api'            => check_string($account['id_product']),
                                'id_connect_api'    => $website['id'],
                                'name'              => $product_name,
                                'name_api'          => $product_name,
                                'price'             => $price,
                                'status'            => $CMSNT->site('default_api_product_status'),
                                'cost'              => check_string($account['price']),
                                'api_stock'         => check_string($account['quantity']),
                                'flag'              => '',
                                'content'           => check_string($account['desc']),
                                'update_api'        => time(),
                                'minimum'           => 1,
                                'maximum'           => 10000
                            ]);
                            echo '<b style="color:red;">CREATE</b> - Tạo sản phẩm '.$product_name.' thành công !<br>';
                        }else{
                            $price = $rowProduct['price'];
                            if($website['status_update_ck'] == 1){
                                $ck = check_string($account['price']) * $website['ck_connect_api'] / 100;
                                $price = check_string($account['price']) + $ck;
                            } 
                            $product_name = $rowProduct['name'];
                            $product_content = $rowProduct['content'];
                            if($website['auto_rename_api'] == 1){
                                $product_name = check_string($account['name']);
                                $product_content = check_string($account['desc']);
                            }
                            // CẬP NHẬT GIÁ VÀ SỐ LƯỢNG SẢN PHẨM API
                            $CMSNT->update('products', [
                                'price'         => $price,
                                'name'          => $product_name,
                                'name_api'      => check_string($account['name']),
                                'content'       => $product_content,
                                'api_stock'     => check_string($account['quantity']),
                                'update_api'    => time(),
                                'cost'          => check_string($account['price'])
                            ], " `id` = '".$rowProduct['id']."' ");
                            echo '<b style="color:green;">UPDATE</b> - sản phẩm '.$product_name.' thành công !<br>';
                        }
                    }
                }
            }
            // ẨN SẢN PHẨM KHI API XOÁ HOẶC ẨN SẢN PHẨM
            $CMSNT->remove('products', " `id_connect_api` = '".$website['id']."' AND ".time()." - `update_api` >= 3600 ");
        }   
    }