<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/lang.php');
    require_once(__DIR__.'/../libs/database/users.php');
    require_once(__DIR__.'/../libs/database/invoices.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_cron')) {
        if (time() - $CMSNT->site('check_time_cron_cron') < 5) {
            die('Thao tác quá nhanh, vui lòng thử lại sau!');
        }
    }
    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron_cron' ");



    if(checkAddon(2) == true){
        /** TẠO GIAO DỊCH NẠP TIỀN ẢO */
        if($CMSNT->site('stt_giaodichao') == 1){
            /** NẠP TIỀN ẢO */
            $int_rand = rand(0, $CMSNT->site('speed_nap_gd_ao'));
            if($int_rand == $CMSNT->site('speed_nap_gd_ao')){
                $array_amount = explode(PHP_EOL, $CMSNT->site('amount_nap_ao'));
                $amount = $array_amount[rand(0, count($array_amount))];
                $amount = $amount != 0 ? $amount : 10000;
                $trans_id = 'fake_'.random("QWERTYUPASDFGHJKZXCVBNM123456789", 6);
                $CMSNT->insert("invoices", [
                    'type'              => 'deposit_money',
                    'user_id'           => $CMSNT->get_row("SELECT * FROM `users` ORDER BY RAND() ")['id'],
                    'trans_id'          => $trans_id,
                    'payment_method'    => $CMSNT->get_row("SELECT * FROM `banks` ORDER BY RAND() ")['short_name'],
                    'amount'            => $amount,
                    'pay'               => $amount,
                    'status'            => 1,
                    'create_date'       => gettime(),
                    'update_date'       => gettime(),
                    'create_time'       => time(),
                    'update_time'       => time(),
                    'note'              => null,
                    'fake'              => 1
                ]);
            }
            /** MUA HÀNG ẢO */
            $int_rand = rand(0, $CMSNT->site('speed_buy_gd_ao'));
            if($int_rand == $CMSNT->site('speed_buy_gd_ao')){
                $amount = rand($CMSNT->site('min_gd_ao'), $CMSNT->site('max_gd_ao'));
                $trans_id = random("QWERTYUPASDFGHJKZXCVBNM123456789", 4);
                foreach($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 ORDER BY RAND() ") as $product){

                    if($CMSNT->site('is_account_buy_fake') == 1){
                        if($CMSNT->num_rows(" SELECT * FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `status` = 'LIVE' AND `buyer` IS NULL ") == 0){
                            continue;
                        }
                    }
                    
                    $CMSNT->insert("orders", [
                        'trans_id'      => $trans_id,
                        'seller'        => $CMSNT->get_row("SELECT * FROM `users` WHERE `admin` = 1  ")['id'],
                        'buyer'         => $CMSNT->get_row("SELECT * FROM `users` ORDER BY RAND() ")['id'],
                        'product_id'    => $product['id'],
                        'amount'        => $amount,
                        'pay'           => $amount * $product['price'],
                        'create_date'   => gettime(),
                        'create_time'   => time(),
                        'fake'          => 1,
                        'cost'          => $amount * $product['price']
                    ]);
                    break;  
                }
            }
        }
    }


    /** XOÁ ĐƠN HÀNG ĐÃ BÁN */
    if($CMSNT->site('time_delete_orders') > 0){
        foreach($CMSNT->get_list(" SELECT * FROM `orders` WHERE  ".time()." - `create_time` >= ".$CMSNT->site('time_delete_orders')." ") as $orders){
            // XÓA TÀI NGUYÊN
            $CMSNT->remove("accounts", " `trans_id` = '".$orders['trans_id']."' ");
            // XÓA ĐƠN HÀNG
            $CMSNT->remove("orders", " `trans_id` = '".$orders['trans_id']."' ");
        }
    }

    /** XOÁ TÀI NGUYÊN HẾT HẠN */
    foreach($CMSNT->get_list(" SELECT * FROM `products` WHERE `time_delete_account` != 0 ") as $product){
        // XÓA TÀI NGUYÊN
        $CMSNT->remove("accounts", " `product_id` = '".$product['id']."' AND ".time()." - `create_time` >= ".$product['time_delete_account']." AND `buyer` IS NULL ");
    }
