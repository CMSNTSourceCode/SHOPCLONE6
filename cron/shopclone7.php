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
    if (time() > $CMSNT->site('check_time_shopclone7')) {
        if (time() - $CMSNT->site('check_time_shopclone7') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }

    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_shopclone7' ");

    // LẤY SẢN PHẨM TỪ API VỀ
    if($CMSNT->site('status_connect_api') == 1){
        // LẤY DANH SÁCH WEBSITE API
        foreach($CMSNT->get_list(" SELECT * FROM `connect_api` WHERE `status` = 1 AND `type` = 'SHOPCLONE7' ") as $website){
            // CẬP NHẬT GIÁ SẢN PHẨM
            $result = curl_get2($website['domain']."api/profile.php?api_key=".$website['password']);
            $result = json_decode($result, true);
            if(isset($result['status']) && $result['status'] == 'success'){
                $CMSNT->update('connect_api', [
                    'price' => format_currency($result['data']['money'])
                ], " `id` = '".$website['id']."' "); 
            }
            // CURL LẤY THÔNG TIN SẢN PHẨM TỪNG WEBSITE
            $data = curl_get2($website['domain'].'api/products.php?api_key='.$website['password']);
            $data = json_decode($data, true);
            if($data['status'] == 'success'){
                foreach($data['categories'] as $category){
                    // TÌM KHÔNG CÓ CHUYÊN MỤC TRONG HỆ THỐNG THÌ BẮT ĐẦU TẠO MỚI CHUYÊN MỤC
                    if(!$CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '".check_string($category['id'])."' AND `id_connect_api` = '".$website['id']."' ")){
                        $url_image = $CMSNT->site('favicon');
                        $rand = '_'.random('QWERTTYUIOPASDFGHJKLZXCVBNM123456789', 6);
                        $uploads_dir = '../assets/storage/images/category'.$rand.'.png';
                        $image = imagecreatefrompng($category['icon']);
                        if ($image === false) {
                            $url_image = $CMSNT->site('favicon');
                        } else {
                            // Sử dụng hàm imagepng() sau khi đã kiểm tra đối tượng GdImage
                            imagepng($image, $uploads_dir);
                            imagedestroy($image); // Giải phóng tài nguyên hình ảnh
                            $url_image = 'assets/storage/images/category'.$rand.'.png';
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
                    foreach($category['products'] as $account){
                        $product_name = check_string($account['name']);
                        $ck = check_string($account['price']) * $website['ck_connect_api'] / 100;
                        $price = check_string($account['price']) + $ck;
                        if(!$rowProduct = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id_api` = '".check_string($account['id'])."' AND `id_connect_api` = '".$website['id']."' ")){
                            // THÊM SẢN PHẨM
                            $id_api = $CMSNT->get_row(" SELECT * FROM `categories` WHERE `id_api` = '".check_string($category['id'])."' AND `id_connect_api` = '".$website['id']."' ")['id'];
                            $CMSNT->insert('products', [
                                'user_id'           => $website['user_id'],
                                'category_id'       => !empty($id_api) ? $id_api : 0,
                                'id_api'            => check_string($account['id']),
                                'id_connect_api'    => $website['id'],
                                'name'              => $product_name,
                                'name_api'          => $product_name,
                                'price'             => $price,
                                'status'            => $CMSNT->site('default_api_product_status'),
                                'cost'              => check_string($account['price']),
                                'api_stock'         => check_string($account['amount']),
                                'content'           => check_string($account['description']),
                                'update_api'        => time(),
                                'minimum'           => check_string($account['min']),
                                'maximum'           => check_string($account['max'])
                            ]);
                            echo '<b style="color:red;">CREATE</b> - Tạo sản phẩm '.$product_name.' thành công !<br>';
                        }else{
                            // CẬP NHẬT SẢN PHẨM
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
                            $CMSNT->update('products', [
                                'price'         => $price,
                                'name'          => $product_name,
                                'name_api'      => check_string($account['name']),
                                'content'       => $product_content,
                                'cost'          => check_string($account['price']),
                                'update_api'    => time(),
                                'api_stock'     => check_string($account['amount']),
                                'minimum'           => check_string($account['min']),
                                'maximum'           => check_string($account['max'])
                            ], " `id` = '".$rowProduct['id']."' ");
                            echo '<b style="color:green;">UPDATE</b> - sản phẩm '.$product_name.' thành công !<br>';
                        }
                    }
                }
            }
            // ẨN SẢN PHẨM KHI API XOÁ HOẶC ẨN SẢN PHẨM
            $CMSNT->remove('products', " `id_connect_api` = '".$website['id']."' AND ".time()." - `update_api` >= 3600 ");

            // XOÁ SẢN PHẨM RÁC
            foreach($CMSNT->get_list(" SELECT * FROM `products` WHERE `id_connect_api` != 0  ") as $row52){
                if(!$CMSNT->get_row(" SELECT * FROM `connect_api` WHERE `id` = '".$row52['id_connect_api']."' AND `status` = 1  ")){
                    $CMSNT->remove('products', " `id` = '".$row52['id']."' ");
                }
            }
            
        }
    }