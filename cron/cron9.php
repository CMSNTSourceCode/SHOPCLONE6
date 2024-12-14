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
    if (time() > $CMSNT->site('check_time_cron9')) {
        if (time() - $CMSNT->site('check_time_cron9') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }


    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron9' ");

    // LẤY SẢN PHẨM TỪ API VỀ
    if($CMSNT->site('status_connect_api') == 1){
        // LẤY DANH SÁCH WEBSITE API
        foreach($CMSNT->get_list(" SELECT * FROM `connect_api` WHERE `status` = 1 AND `type` = 'API_9' ") as $website){


            // CẬP NHẬT GIÁ SẢN PHẨM
            $response = balance_API_9($website['domain'], $website['password']);
            $getPrice = json_decode($response, true);
            if($getPrice['error'] == 0){
                $CMSNT->update('connect_api', [
                    'price' => format_currency($getPrice['data']['balance'])
                ], " `id` = '".$website['id']."' ");
            }

            

            // CURL LẤY THÔNG TIN SẢN PHẨM TỪNG WEBSITE
            $data = listProduct_API_9($website['domain'], $website['password']);
            $data = json_decode($data, true);
            if($data['error'] == 0){
                foreach($data['data'] as $category){
                    $id_catrgory_api = check_string($category['category_name']);

                    // CURL LẤY SẢN PHẨM
                    foreach($category['products'] as $account){
                        $id_product_api = check_string($account['id']);
                        $product_name = check_string($account['name']);
                        $ck = check_string($account['price']) * $website['ck_connect_api'] / 100;
                        $price = check_string($account['price']) + $ck;
                        $cost = check_string($account['price']);
                        if(!$rowProduct = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id_api` = '$id_product_api' AND `id_connect_api` = '".$website['id']."' ")){
                            // LẤY ID CATEGORY
                            $id_category = 0;
                            $CMSNT->insert('products', [
                                'user_id'           => $website['user_id'],
                                'category_id'       => $id_category,
                                'id_api'            => $id_product_api,
                                'id_connect_api'    => $website['id'],
                                'name'              => $product_name,
                                'name_api'          => $product_name,
                                'price'             => $price,
                                'status'            => $CMSNT->site('default_api_product_status'),
                                'cost'              => $cost,
                                'api_stock'         => check_string($account['remain']),
                                'flag'              => '',
                                'content'           => check_string($account['description']),
                                'update_api'        => time(),
                                'minimum'           => 1,
                                'maximum'           => 1000000
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
                                $product_content = check_string($account['description']);
                            }

                            // CẬP NHẬT GIÁ VÀ SỐ LƯỢNG SẢN PHẨM API
                            $CMSNT->update('products', [
                                'price'         => $price,
                                'name'          => $product_name,
                                'name_api'      => check_string($account['name']),
                                'content'       => $product_content,
                                'api_stock'     => check_string($account['remain']),
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