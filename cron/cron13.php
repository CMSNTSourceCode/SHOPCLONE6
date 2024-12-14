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
    if (time() > $CMSNT->site('check_time_cron13')) {
        if (time() - $CMSNT->site('check_time_cron13') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }

    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron13' ");

    // LẤY SẢN PHẨM TỪ API VỀ
    if($CMSNT->site('status_connect_api') == 1){
        // LẤY DANH SÁCH WEBSITE API
        foreach($CMSNT->get_list(" SELECT * FROM `connect_api` WHERE `status` = 1 AND `type` = 'API_13' ") as $website){
            // CẬP NHẬT GIÁ SẢN PHẨM


            // CURL LẤY SẢN PHẨM
            $list_product = listProduct_API_13($website['domain'], $website['password']);
            $list_product = json_decode($list_product, true);
            if(isset($list_product['IsSuccessed'])){
                foreach($list_product['Data'] as $account){
                    $product_name = check_string($account['Name']);
                    $ck = check_string($account['Price']) * $website['ck_connect_api'] / 100;
                    $price = check_string($account['Price']) + $ck;
                    $product_content = '';
                    if(!$rowProduct = $CMSNT->get_row(" SELECT * FROM `products` WHERE `id_api` = '".check_string($account['Id'])."' AND `id_connect_api` = '".$website['id']."' ")){
                        // LẤY ID CATEGORY
                        $id_api = 0;
                        $isInsert = $CMSNT->insert('products', [
                            'user_id'           => $website['user_id'],
                            'category_id'       => $id_api,
                            'id_api'            => check_string($account['Id']),
                            'id_connect_api'    => $website['id'],
                            'name'              => $product_name,
                            'name_api'          => $product_name,
                            'price'             => $price,
                            'status'            => $CMSNT->site('default_api_product_status'),
                            'cost'              => check_string($account['Price']),
                            'api_stock'         => check_string($account['Quantity']),
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
                        if($website['status_update_ck'] == 1){
                            $ck = check_string($account['Price']) * $website['ck_connect_api'] / 100;
                            $price = check_string($account['Price']) + $ck;
                        }
                        $product_name = $rowProduct['name'];
                        $product_content = $rowProduct['content'];
                        if($website['auto_rename_api'] == 1){
                            $product_name = check_string($account['Name']);
                            $product_content = '';
                        }
                        // CẬP NHẬT GIÁ VÀ SỐ LƯỢNG SẢN PHẨM API
                        $isUpdate = $CMSNT->update('products', [
                            'price'         => $price,
                            'name'          => $product_name,
                            'name_api'      => check_string($account['Name']),
                            'content'       => $product_content,
                            'api_stock'     => check_string($account['Quantity']),
                            'update_api'    => time(),
                            'cost'          => check_string($account['Price'])
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