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
    if (time() > $CMSNT->site('check_time_cron6')) {
        if (time() - $CMSNT->site('check_time_cron6') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }


    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron6' ");

    // LẤY SẢN PHẨM TỪ API VỀ
    if($CMSNT->site('status_connect_api') == 1){
        // LẤY DANH SÁCH WEBSITE API
        foreach($CMSNT->get_list(" SELECT * FROM `connect_api` WHERE `status` = 1 AND `type` = 'API_6' ") as $website){


            // CẬP NHẬT GIÁ SẢN PHẨM
            $response = balance_API_6($website['domain'], $website['password']);
            $getPrice = json_decode($response, true);
            if(isset($getPrice['balance'])){
                $CMSNT->update('connect_api', [
                    'price' => format_currency($getPrice['balance'])
                ], " `id` = '".$website['id']."' ");
            }
            


            // CURL LẤY CATEGORIES
            $data = curl_get($website['domain'].'/api.php?apikey='.$website['password'].'&action=get-services');
            $data = json_decode($data, true);
            if($data['code'] == 0){
                foreach($data['data'] as $account){

                    $id_api_category = check_string($account['type']);
                    $service_id = check_string($account['service_id']);
                    $product_name = check_string($account['service_name']);
                    $product_content = check_string($account['description']);
                    $ck = check_string($account['price']) * $website['ck_connect_api'] / 100;
                    $price = check_string($account['price']) + $ck;
                    $cost = check_string($account['price']);
                    $api_stock = check_string($account['quantity']);


                    // TÌM KHÔNG CÓ CHUYÊN MỤC TRONG HỆ THỐNG THÌ BẮT ĐẦU TẠO MỚI CHUYÊN MỤC
                    if(!$CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '$id_api_category' AND `id_connect_api` = '".$website['id']."' ")){
                        $url_image = $CMSNT->site('favicon');
                        $CMSNT->insert('categories', [
                            'id_api'            => $id_api_category,
                            'id_connect_api'    => $website['id'],
                            'status'            => $CMSNT->site('default_api_product_status'),
                            'name'              => $id_api_category,
                            'image'             => $url_image
                        ]);
                        echo '<b style="color:red;">CREATE</b> - Tạo category '.$id_api_category.' thành công !<br>';
                    }
                    // LẤY ID CATEGORY
                    $id_category = $CMSNT->get_row(" SELECT `id` FROM `categories` WHERE `id_api` = '$id_api_category' AND `id_connect_api` = '".$website['id']."' ")['id'];
                    if(!$rowProduct = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id_api` = '$service_id' AND `id_connect_api` = '".$website['id']."' ")){
                        $isInsert = $CMSNT->insert('products', [
                            'user_id'           => $website['user_id'],
                            'category_id'       => $id_category,
                            'id_api'            => $service_id,
                            'id_connect_api'    => $website['id'],
                            'name'              => $product_name,
                            'name_api'          => $product_name,
                            'price'             => $price,
                            'status'            => $CMSNT->site('default_api_product_status'),
                            'cost'              => $cost,
                            'api_stock'         => $api_stock,
                            'flag'              => '',
                            'content'           => $product_content,
                            'update_api'        => time(),
                            'minimum'           => 1,
                            'maximum'           => 10000
                        ]);
                        if($isInsert){
                            echo '<b style="color:red;">CREATE</b> - Tạo sản phẩm '.$product_name.' thành công !<br>';
                        }
                    }else{
                        $price = $rowProduct['price'];
                        // if($website['ck_connect_api'] > 0){
                        //     $ck = check_string($account['price']) * $website['ck_connect_api'] / 100;
                        //     $price = check_string($account['price']) + $ck;
                        // }
                        if($website['status_update_ck'] == 1){
                            $ck = check_string($account['price']) * $website['ck_connect_api'] / 100;
                            $price = check_string($account['price']) + $ck;
                        } 
                        if($website['auto_rename_api'] != 1){
                            $product_name = $rowProduct['name'];
                            $product_content = $rowProduct['content'];
                        }
                        // CẬP NHẬT GIÁ VÀ SỐ LƯỢNG SẢN PHẨM API
                        $isUpdate = $CMSNT->update('products', [
                            'price'         => $price,
                            'name'          => $product_name,
                            'name_api'      => $product_name,
                            'content'       => $product_content,
                            'api_stock'     => $api_stock,
                            'update_api'    => time(),
                            'cost'          => $cost
                        ], " `id` = '".$rowProduct['id']."' ");
                        if($isUpdate){
                            echo '<b style="color:green;">UPDATE</b> - sản phẩm '.$product_name.' thành công !<br>';
                        }
                    }

                }
            }

            // ẨN SẢN PHẨM KHI API XOÁ HOẶC ẨN SẢN PHẨM
            $CMSNT->remove('products', " `id_connect_api` = '".$website['id']."' AND ".time()." - `update_api` >= 3600 ");
        }
    }