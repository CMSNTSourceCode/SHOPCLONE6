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
    if (time() > $CMSNT->site('check_time_cron17')) {
        if (time() - $CMSNT->site('check_time_cron17') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }

    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron17' ");

    // LẤY SẢN PHẨM TỪ API VỀ
    if($CMSNT->site('status_connect_api') == 1){
        // LẤY DANH SÁCH WEBSITE API
        foreach($CMSNT->get_list(" SELECT * FROM `connect_api` WHERE `status` = 1 AND `type` = 'API_17' ") as $website){
            // CẬP NHẬT GIÁ SẢN PHẨM
            $getPrice = curl_get2($website['domain']."/api/GetBalance.php?username=".$website['username']."&password=".$website['password']);
            $CMSNT->update('connect_api', [
                'price' => $getPrice
            ], " `id` = '".$website['id']."' ");
            // CURL LẤY THÔNG TIN SẢN PHẨM TỪNG WEBSITE
            $data = curl_get2($website['domain'].'/api/CategoryList.php?username='.$website['username'].'&password='.$website['password']);
            $data = json_decode($data, true);
            if($data['status'] == 'success'){
                foreach($data['data'] as $account){
                    $product_name = check_string($account['title']);
                    $ck = check_string($account['money']) * $website['ck_connect_api'] / 100;
                    $price = check_string($account['money']) + $ck;
                    if(!$rowProduct = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id_api` = '".check_string($account['id'])."' AND `id_connect_api` = '".$website['id']."' ")){
                        // THÊM SẢN PHẨM
                        $id_api = 0;
                        $CMSNT->insert('products', [
                            'user_id'           => $website['user_id'],
                            'category_id'       => $id_api,
                            'id_api'            => check_string($account['id']),
                            'id_connect_api'    => $website['id'],
                            'name'              => $product_name,
                            'name_api'          => $product_name,
                            'price'             => $price,
                            'status'            => $CMSNT->site('default_api_product_status'),
                            'cost'              => check_string($account['money']),
                            'api_stock'         => check_string($account['amount']),
                            'flag'              => check_string($account['quocgia']),
                            'content'           => check_string($account['note']),
                            'update_api'        => time(),
                            'minimum'           => 1,
                            'maximum'           => 10000
                        ]);
                        echo '<b style="color:red;">CREATE</b> - Tạo sản phẩm '.$product_name.' thành công !<br>';
                    }else{
                        // CẬP NHẬT SẢN PHẨM
                        $price = $rowProduct['price'];
                        if($website['status_update_ck'] == 1){
                            $ck = check_string($account['money']) * $website['ck_connect_api'] / 100;
                            $price = check_string($account['money']) + $ck;
                        } 
                        $product_name = $rowProduct['name'];
                        $product_content = $rowProduct['content'];
                        if($website['auto_rename_api'] == 1){
                            $product_name = check_string($account['title']);
                            $product_content = check_string($account['note']);
                        }
                        $CMSNT->update('products', [
                            'price'         => $price,
                            'name'          => $product_name,
                            'name_api'      => check_string($account['title']),
                            'content'       => $product_content,
                            'cost'          => check_string($account['money']),
                            'update_api'    => time(),
                            'api_stock'     => check_string($account['amount'])
                        ], " `id` = '".$rowProduct['id']."' ");
                        echo '<b style="color:green;">UPDATE</b> - sản phẩm '.$product_name.' thành công !<br>';
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