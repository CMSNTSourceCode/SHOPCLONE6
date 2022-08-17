<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/lang.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron2')) {
        if (time() - $CMSNT->site('check_time_cron2') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }

    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron2' ");

    // LẤY SẢN PHẨM TỪ API VỀ
    if($CMSNT->site('status_connect_api') == 1){
        // LẤY DANH SÁCH WEBSITE API
        foreach($CMSNT->get_list(" SELECT * FROM `connect_api` WHERE `status` = 1 AND `type` = 'CMSNT' ") as $website){
            // CẬP NHẬT GIÁ SẢN PHẨM
            $getPrice = curl_get($website['domain']."/api/GetBalance.php?username=".$website['username']."&password=".$website['password']);
            $CMSNT->update('connect_api', [
                'price' => $getPrice
            ], " `id` = '".$website['id']."' ");
            // CURL LẤY THÔNG TIN SẢN PHẨM TỪNG WEBSITE
            $data = curl_get($website['domain'].'/api/ListResource.php?username='.$website['username'].'&password='.$website['password']);
            $data = json_decode($data, true);
            if($data['status'] == 'success'){
                foreach($data['categories'] as $category){
                    // TÌM KHÔNG CÓ CHUYÊN MỤC TRONG HỆ THỐNG THÌ BẮT ĐẦU TẠO MỚI CHUYÊN MỤC
                    if(!$CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '".check_string($category['id'])."' AND `id_connect_api` = '".$website['id']."' ")){
                        $url_image = NULL;
                        $rand = '_'.random('QWERTTYUIOPASDFGHJKLZXCVBNM123456789', 6);
                        $uploads_dir = '../assets/storage/images/category'.$rand.'.png';
                        $image = imagecreatefrompng($category['image']);
                        imagepng($image, $uploads_dir);
                        if(imagepng($image, $uploads_dir)){
                            $url_image = 'assets/storage/images/category'.$rand.'.png';
                        }else{
                            $url_image = NULL;
                        }
                        $CMSNT->insert('categories', [
                            'id_api'            => check_string($category['id']),
                            'id_connect_api'    => $website['id'],
                            'status'            => $CMSNT->site('default_api_product_status'),
                            'name'              => check_string($category['name']),
                            'image'             => $url_image
                        ]);
                        echo '<b style="color:red;">CREATE</b> - Tạo category '.check_string($category['name']).' thành công !<br>';
                    }
                    foreach($category['accounts'] as $account){
                        $product_name = check_string($account['name']);
                        $ck = check_string($account['price']) * $CMSNT->site('ck_connect_api') / 100;
                        $price = check_string($account['price']) + $ck;
                        if(!$rowProduct = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id_api` = '".check_string($account['id'])."' AND `id_connect_api` = '".$website['id']."' ")){
                            // THÊM SẢN PHẨM
                            $id_api = $CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '".check_string($category['id'])."' AND `id_connect_api` = '".$website['id']."' ")['id'];
                            $CMSNT->insert('products', [
                                'user_id'           => $website['user_id'],
                                'category_id'       => $id_api,
                                'id_api'            => check_string($account['id']),
                                'id_connect_api'    => $website['id'],
                                'name'              => $product_name,
                                'name_api'          => $product_name,
                                'price'             => $price,
                                'status'            => $CMSNT->site('default_api_product_status'),
                                'cost'              => check_string($account['price']),
                                'api_stock'         => check_string($account['amount']),
                                'flag'              => check_string($account['country']),
                                'content'           => check_string($account['description']),
                                'update_api'        => time(),
                                'minimum'           => 1,
                                'maximum'           => 10000
                            ]);
                            echo '<b style="color:red;">CREATE</b> - Tạo sản phẩm '.$product_name.' thành công !<br>';
                        }else{
                            // CẬP NHẬT SẢN PHẨM
                            $price = $rowProduct['price'];
                            if($CMSNT->site('ck_connect_api') > 0){
                                $ck = check_string($account['price']) * $CMSNT->site('ck_connect_api') / 100;
                                $price = check_string($account['price']) + $ck;
                            }
                            $product_name = $rowProduct['name'];
                            $product_content = $rowProduct['content'];
                            if($CMSNT->site('auto_rename_api') == 1){
                                $product_name = check_string($account['name']);
                                $product_content = check_string($account['description']);
                            }
                            $CMSNT->update('products', [
                                'price'         => $price,
                                'name'          => $product_name,
                                'name_api'      => check_string($account['name']),
                                'content'       => $product_content,
                                'cost'          => check_string($account['price']),
                                'update_api'    => time(),
                                'api_stock'     => check_string($account['amount'])
                            ], " `id` = '".$rowProduct['id']."' ");
                            echo '<b style="color:green;">UPDATE</b> - sản phẩm '.$product_name.' thành công !<br>';
                        }
                    }
                }
                // ẨN SẢN PHẨM KHI API XOÁ HOẶC ẨN SẢN PHẨM
                $CMSNT->update('products', [
                    'status'    => 0
                ], " `id_connect_api` = '".$website['id']."' AND ".time()." - `update_api` >= 300 ");
            }
        }
    }