<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/nowpayments.php');
    require_once(__DIR__.'/../libs/database/users.php');
 
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
    if (time() > $CMSNT->site('check_time_cron_crypto')) {
        if (time() - $CMSNT->site('check_time_cron_crypto') < 10) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", ['value' => time()], " `name` = 'check_time_cron_crypto' ");
    /* END CHỐNG SPAM */
    if ($CMSNT->site('status_crypto') != 1) {
        die('Chức năng đang bảo trì.');
    }
 
    $nowPayments = new NowPaymentsAPI($CMSNT->site('apikey_nowpayments'));
    $data = $nowPayments->getListPayments([
        'limit'     => 100,
        'page'      => 0,
        'sortBy'    => 'created_at',
        'orderBy'   => 'desc'
    ]);
    $data = json_decode($data, true);
    foreach($data['data'] as $result){
        if($row = $CMSNT->get_row(" SELECT * FROM `nowpayments` WHERE `order_id` = '".$result['order_id']."'  ")){
            if($row['payment_status'] == 'waiting' || $row['payment_status'] == 'confirming' || $row['payment_status'] == 'confirmed' || $row['payment_status'] == 'sending'){
                $isUpdate = $CMSNT->update('nowpayments', array(
                    'invoice_id'        => $result['invoice_id'],
                    'payment_status'    => $result['payment_status'],
                    'pay_address'       => $result['pay_address'],
                    'price_currency'    => $result['price_currency'],
                    'pay_amount'        => $result['pay_amount'],
                    'actually_paid'     => $result['actually_paid'],
                    'pay_currency'      => $result['pay_currency'],
                    'purchase_id'       => $result['purchase_id'],
                    'updated_at'        => gettime(),
                    'outcome_amount'    => $result['outcome_amount'],
                    'outcome_currency'  => $result['outcome_currency']
                ), " `id` = '".$row['id']."' ");
                if($isUpdate){
                    if($result['payment_status'] == 'finished'){
                        $price = $CMSNT->site('rate_crypto') * $row['price_amount'];
                        $CMSNT->update('nowpayments', array(
                            'payment_status'    => 'finished',
                            'price'             => $price
                        ), " `id` = '".$row['id']."' ");
                        $User = new users();
                        $User->AddCredits($row['user_id'], $price, 'Payment Crypto #'.$row['order_id']);
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'Crypto - #'.$row['order_id'], $my_text);
                        $my_text = str_replace('{amount}', '$'.format_cash($row['price_amount']), $my_text);
                        $my_text = str_replace('{price}', format_currency($price), $my_text);
                        $my_text = str_replace('{time}', gettime(), $my_text);
                        sendMessAdmin($my_text);
                    }
                    echo '[-] Xử lý thành công hoá đơn<br>';
                }
            }
        }
    }