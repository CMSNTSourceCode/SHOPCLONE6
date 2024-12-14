<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/database/users.php');
    require_once(__DIR__.'/../libs/database/invoices.php');
    $CMSNT = new DB();
    $user = new users();

    if($CMSNT->site('pin_cron') != ''){
        if(empty($_GET['pin'])){
            die('Vui lòng nhập mã PIN');
        }
        if($_GET['pin'] != $CMSNT->site('pin_cron')){
            die('Mã PIN không chính xác');
        }
    }

    
    queryCancelInvoices();


    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_thesieure')) {
        if (time() - $CMSNT->site('check_time_cron_thesieure') < 10) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", ['value' => time()], " `name` = 'check_time_cron_thesieure' ");
    /* END CHỐNG SPAM */


    if ($CMSNT->site('status_thesieure') != 1) {
        die('Chức năng đang bảo trì.');
    }
    if ($CMSNT->site('token_thesieure') == '') {
        die('Thiếu Token THESIEURE');
    }
    $result = curl_get2("https://api.web2m.com/historyapithesieure/".$CMSNT->site('token_thesieure'));
    $result = json_decode($result, true);
    if ($result['status'] != true) {
        die('Lấy dữ liệu thất bại');
    }
    foreach ($result['tranList'] as $data) {
        $partnerId      = $data['username'];                    // SỐ ĐIỆN THOẠI CHUYỂN
        $comment        = $data['description'];                 // NỘI DUNG CHUYỂN TIỀN
        $tranId         = $data['description'];                     // MÃ GIAO DỊCH
        $amount         = str_replace(',', '', $data['amount']);
        $amount         = str_replace('đ', '', $amount);               // SỐ TIỀN CHUYỂN
        $user_id        = parse_order_id($comment, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN

        // XỬ LÝ AUTO SERVER 1 
        if($CMSNT->site('sv1_autobank') == 1){
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$comment' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('THESIEURE', $amount) as $row) {
                if($row['description'] == $comment && $row['tid'] == $tranId){
                    continue;
                }
                if (isset(explode($row['trans_id'], strtoupper($comment))[1])) {
                    if ($amount >= $row['pay']) {
                        $isUpdate = $CMSNT->update("invoices", [
                            'status'        => 1,
                            'description'   => $comment,
                            'tid'           => $tranId,
                            'update_date'   => gettime(),
                            'update_time'   => time()
                        ], " `id` = '".$row['id']."' ");
                        if ($isUpdate) {
                            $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
                            if (!$isCong) {
                                // $CMSNT->update("invoices", [
                                // 'status'  => 0
                                // ], " `id` = '".$row['id']."' ");
                            }
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'THESIEURE.COM Server 1', $my_text);
                        $my_text = str_replace('{amount}', format_cash($amount), $my_text);
                        $my_text = str_replace('{price}', format_currency($received), $my_text);
                        $my_text = str_replace('{time}', gettime(), $my_text);
                        sendMessAdmin($my_text);
                        echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                        break;
                    }
                }
            }
        }
    }