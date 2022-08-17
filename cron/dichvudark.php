<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/database/users.php');
    require_once(__DIR__.'/../libs/database/invoices.php');
    $CMSNT = new DB();
    $user = new users();
    queryCancelInvoices();
    
    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_dichvudark')) {
        if (time() - $CMSNT->site('check_time_cron_dichvudark') < 15) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", ['value' => time()], " `name` = 'check_time_cron_dichvudark' ");
    /* END CHỐNG SPAM */
    if ($CMSNT->site('status_momo') == 1 && $CMSNT->site('token_momo') != ''){
    $dataPost = array("Loai_api" => "lsgd1h");
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.dichvudark.com/api/ApiMomo",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $dataPost,
    CURLOPT_HTTPHEADER => array(
    "Code: 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",
    "Token: ".$CMSNT->site('token_momo'),
    "Hour: 4")
    ));
    $result = curl_exec($curl);
    $result = json_decode($result, true);
    if ($CMSNT->site('token_bank') == '') {
        die('Thiếu Token Bank');
    }
    foreach ($result['tranList'] as $data) {
        $partnerId      = $data['partnerId'];               // SỐ ĐIỆN THOẠI CHUYỂN
        $comment        = $data['comment'];                 // NỘI DUNG CHUYỂN TIỀN
        $tranId         = $data['tranId'];                  // MÃ GIAO DỊCH
        $partnerName    = $data['partnerName'];             // TÊN CHỦ VÍ
        $amount         = $data['amount'];                  // SỐ TIỀN CHUYỂN
        $user_id        = parse_order_id($comment, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
        // XỬ LÝ AUTO SERVER 2
        if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
            if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tranId' ") == 0){
                    $insertSv2 = $CMSNT->insert("server2_autobank", array(
                        'tid'               => $tranId,
                        'user_id'           => $getUser['id'],
                        'description'       => $comment,
                        'amount'            => $amount,
                        'received'          => checkPromotion($amount),
                        'create_gettime'    => gettime(),
                        'create_time'       => time()
                    ));
                    if ($insertSv2){
                        $received = checkPromotion($amount);
                        $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua ví MOMO (#$tranId - $amount - $comment - $partnerId - $partnerName)");
                        if($isCong){

                            /** SEND NOTI CHO ADMIN */
                            $my_text = $CMSNT->site('naptien_notification');
                            $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                            $my_text = str_replace('{username}', $getUser['username'], $my_text);
                            $my_text = str_replace('{method}', 'Ví MOMO', $my_text);
                            $my_text = str_replace('{amount}', format_cash($amount), $my_text);
                            $my_text = str_replace('{price}', format_currency($received), $my_text);
                            $my_text = str_replace('{time}', gettime(), $my_text);
                            sendMessAdmin($my_text);

                            echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                        }
                    }
                }
            }
        }
        // XỬ LÝ AUTO SERVER 1
        if($CMSNT->site('sv1_autobank') == 1){
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$comment' AND `tid` = '$tranId' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('MOMO', $amount) as $row) {
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
                            $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id']);
                            if (!$isCong) {
                                $CMSNT->update("invoices", [
                                'status'  => 0
                                ], " `id` = '".$row['id']."' ");
                            }
                        }
                        echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                        break;
                    }
                }
            }
        }
    }
}
    if ($CMSNT->site('type_bank') == 'MBBank' && $CMSNT->site('token_bank') != '' && $CMSNT->site('status_bank') == 1) {
    $token = $CMSNT->site('token_bank');
    $stk = $CMSNT->site('stk_bank');
    $dataPost = array(
     "Loai_api" => "lsgdv2",
     );
     $curl = curl_init();
     curl_setopt_array($curl, array(
     CURLOPT_URL => "https://api.dichvudark.com/api/ApiMbBank",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_SSL_VERIFYPEER => false,
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_CUSTOMREQUEST => "POST",
     CURLOPT_POSTFIELDS => $dataPost,
     CURLOPT_HTTPHEADER => array(
     "Code: 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",
     "Token: ".$token,
     "Stk: ".$stk)
     ));
        $result = curl_exec($curl);//echo($result);
        $result = json_decode($result, true);
        
        foreach ($result['transactionHistoryList'] as $data) {
            $tid            = check_string($data['refNo']);
            $description    = check_string($data['description']);
            $amount         = check_string($data['creditAmount']);
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid'  ") == 0){
                        if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `description` = '$description' ") == 0){
                            $insertSv2 = $CMSNT->insert("server2_autobank", array(
                                'tid'               => $tid,
                                'user_id'           => $getUser['id'],
                                'description'       => $description,
                                'amount'            => $amount,
                                'received'          => checkPromotion($amount),
                                'create_gettime'    => gettime(),
                                'create_time'       => time()
                            ));
                            if ($insertSv2){
                                $received = checkPromotion($amount);
                                $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua MBBank (#$tid - $description - $amount)");
                                if($isCong){
                                    /** SEND NOTI CHO ADMIN */
                                    $my_text = $CMSNT->site('naptien_notification');
                                    $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                    $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                    $my_text = str_replace('{method}', 'MBBank - Server 2', $my_text);
                                    $my_text = str_replace('{amount}', format_cash($amount), $my_text);
                                    $my_text = str_replace('{price}', format_currency($received), $my_text);
                                    $my_text = str_replace('{time}', gettime(), $my_text);
                                    sendMessAdmin($my_text);
                                    echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                                }
                            }
                        }
                    }
                }
            }
            // XỬ LÝ AUTO SERVER 1
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('MBBank', $amount) as $row) {
                if($row['description'] == $description && $row['tid'] == $tid){
                    continue;
                }
                if (isset(explode($row['trans_id'], strtoupper($description))[1])) {
                    $isUpdate = $CMSNT->update("invoices", [
                        'status'        => 1,
                        'description'   => $description,
                        'tid'           => $tid,
                        'update_date'   => gettime(),
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' ");
                    if($isUpdate){
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id']);
                        if (!$isCong) {
                            $CMSNT->update("invoices", [
                            'status'  => 0
                            ], " `id` = '".$row['id']."' ");
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'MBBank - Server 1', $my_text);
                        $my_text = str_replace('{amount}', format_cash($row['pay']), $my_text);
                        $my_text = str_replace('{price}', format_currency($row['amount']), $my_text);
                        $my_text = str_replace('{time}', gettime(), $my_text);
                        sendMessAdmin($my_text);
                        echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                    }
                    break;
                }
            }
        }
        die();
    }
    if ($CMSNT->site('status_thesieure') == 1 && $CMSNT->site('token_thesieure') != '') {
    $dataPost = array(
    "Loai_api" => "lsgd", 
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.dichvudark.com/api/ApiTsr",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $dataPost,
    CURLOPT_HTTPHEADER => array(
    "Code: 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",
    "Token: ".$CMSNT->site('token_thesieure'))
    ));
    $result = curl_exec($curl);
    $result = json_decode($result, true);
    if ($result['status'] != true) {
        die('Lấy dữ liệu thất bại');
    }
    foreach ($result['tranList'] as $data) {
        if ($data['type'] == 'nhantien'){
        $partnerId      = $data['username_send_or_receive'];                    // SỐ ĐIỆN THOẠI CHUYỂN
        $comment        = $data['comment'];                 // NỘI DUNG CHUYỂN TIỀN
        $tranId         = $data['transId'];                     // MÃ GIAO DỊCH
        $amount         = str_replace(',', '', $data['amount']);
        $amount         = str_replace('đ', '', $amount);               // SỐ TIỀN CHUYỂN
        $user_id        = parse_order_id($comment, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
        // XỬ LÝ AUTO SERVER 2
        if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
            if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tranId' ") == 0){
                    $insertSv2 = $CMSNT->insert("server2_autobank", array(
                        'tid'               => $tranId,
                        'user_id'           => $getUser['id'],
                        'description'       => $comment,
                        'amount'            => $amount,
                        'received'          => checkPromotion($amount),
                        'create_gettime'    => gettime(),
                        'create_time'       => time()
                    ));
                    if ($insertSv2){
                        $received = checkPromotion($amount);
                        $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua web THESIEURE.COM (#$tranId - $comment - $amount)");
                        if($isCong){
                            /** SEND NOTI CHO ADMIN */
                            $my_text = $CMSNT->site('naptien_notification');
                            $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                            $my_text = str_replace('{username}', $getUser['username'], $my_text);
                            $my_text = str_replace('{method}', 'THESIEURE.COM', $my_text);
                            $my_text = str_replace('{amount}', format_cash($amount), $my_text);
                            $my_text = str_replace('{price}', format_currency($received), $my_text);
                            $my_text = str_replace('{time}', gettime(), $my_text);
                            sendMessAdmin($my_text);
                            echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                        }
                    }
                }
            }
        }
        // XỬ LÝ AUTO SERVER 1
        if($CMSNT->site('sv1_autobank') == 1){
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$comment' AND `tid` = '$tranId' ") > 0){
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
                            $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id']);
                            if (!$isCong) {
                                $CMSNT->update("invoices", [
                                'status'  => 0
                                ], " `id` = '".$row['id']."' ");
                            }
                        }
                        echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                        break;
                    }
                }
            }
        }
    }
}
}