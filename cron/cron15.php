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
    if (time() > $CMSNT->site('check_time_cron15')) {
        if (time() - $CMSNT->site('check_time_cron15') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }


    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron15' ");

    // LẤY SẢN PHẨM TỪ API VỀ
    if($CMSNT->site('status_connect_api') == 1){
        // LẤY DANH SÁCH WEBSITE API
        foreach($CMSNT->get_list(" SELECT * FROM `connect_api` WHERE `status` = 1 AND `type` = 'API_15' ") as $website){


            // CẬP NHẬT GIÁ SẢN PHẨM
            $response = balance_API_15($website['domain'], $website['username'], $website['password']);
            $getPrice = json_decode($response, true);
            if($getPrice['status'] == true){
                $CMSNT->update('connect_api', [
                    'price' => format_currency($getPrice['price'])
                ], " `id` = '".$website['id']."' ");
            }
  

            // CURL LẤY CATEGORIES
            $list_product = listProduct_API_15($website['domain'], $website['password']);
            $list_product = json_decode($list_product, true);
            if($list_product['status'] == true){
                
                foreach($list_product['categories'] as $category){
                    $category_id_api = check_string($category['id']);
                    // TÌM KHÔNG CÓ CHUYÊN MỤC TRONG HỆ THỐNG THÌ BẮT ĐẦU TẠO MỚI CHUYÊN MỤC
                    if(!$CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '$category_id_api' AND `id_connect_api` = '".$website['id']."' ")){
                        $url_image = $CMSNT->site('favicon');
                        $CMSNT->insert('categories', [
                            'id_api'            => $category_id_api,
                            'id_connect_api'    => $website['id'],
                            'status'            => $CMSNT->site('default_api_product_status'),
                            'name'              => check_string($category['name']),
                            'image'             => $url_image
                        ]);
                        echo '<b style="color:red;">CREATE</b> - Tạo category '.check_string($category['name']).' thành công !<br>';
                    }
                    foreach($category['accounts'] as $account){
                        $product_amount_api = check_string($account['amount']);
                        $product_price_api = check_string($account['price']);
                        $product_id_api = check_string($account['id']);
                        $product_name_api = check_string($account['name']);
                        $product_content_api = '';

                        $ck = $product_price_api * $website['ck_connect_api'] / 100;
                        $price = $product_price_api + $ck;
                        if(!$rowProduct = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id_api` = '".$product_id_api."' AND `id_connect_api` = '".$website['id']."' ")){
                            // LẤY ID CATEGORY
                            $id_category = $CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '".$category_id_api."' AND `id_connect_api` = '".$website['id']."' ")['id'];
                            $isInsert = $CMSNT->insert('products', [
                                'user_id'           => $website['user_id'],
                                'category_id'       => $id_category,
                                'id_api'            => $product_id_api,
                                'id_connect_api'    => $website['id'],
                                'name'              => $product_name_api,
                                'name_api'          => $product_name_api,
                                'price'             => $price,
                                'status'            => $CMSNT->site('default_api_product_status'),
                                'cost'              => $product_price_api,
                                'api_stock'         => $product_amount_api,
                                'flag'              => '',
                                'content'           => $product_content_api,
                                'update_api'        => time(),
                                'minimum'           => 1,
                                'maximum'           => 10000
                            ]);
                            if($isInsert){
                                echo '<b style="color:red;">CREATE</b> - Tạo sản phẩm '.$product_name_api.' thành công !<br>';
                            }
                        }else{
                            $price = $rowProduct['price'];
                            if($website['status_update_ck'] == 1){
                                $ck = $product_price_api * $website['ck_connect_api'] / 100;
                                $price = $product_price_api + $ck;
                            }
                            $product_name = $rowProduct['name'];
                            $product_content = $rowProduct['content'];
                            if($website['auto_rename_api'] == 1){
                                $product_name = $product_name_api;
                                $product_content = $product_content_api;
                            }
                            // CẬP NHẬT GIÁ VÀ SỐ LƯỢNG SẢN PHẨM API
                            $isUpdate = $CMSNT->update('products', [
                                'price'         => $price,
                                'name'          => $product_name,
                                'name_api'      => $product_name_api,
                                'content'       => $product_content,
                                'api_stock'     => $product_amount_api,
                                'update_api'    => time(),
                                'cost'          => $product_price_api
                            ], " `id` = '".$rowProduct['id']."' ");
                            if($isUpdate){
                                echo '<b style="color:green;">UPDATE</b> - sản phẩm '.$product_name_api.' thành công !<br>';
                            }
                        }
                    }
                }
                 
            }

            // ẨN SẢN PHẨM KHI API XOÁ HOẶC ẨN SẢN PHẨM
            $CMSNT->remove('products', " `id_connect_api` = '".$website['id']."' AND ".time()." - `update_api` >= 3600 ");
        }
    }