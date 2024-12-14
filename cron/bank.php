<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/lang.php');
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
    if (time() > $CMSNT->site('check_time_cron_bank')) {
        if (time() - $CMSNT->site('check_time_cron_bank') < 10) {
            die('[ÉT O ÉT ]Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", ['value' => time()], " `name` = 'check_time_cron_bank' ");

    queryCancelInvoices();
    curl_get2(base_url('cron/cron1.php?pin='.$CMSNT->site('pin_cron')));




    
    if ($CMSNT->site('status_bank') != 1) {
        die('Chức năng đang tắt.');
    }
    if ($CMSNT->site('token_bank') == '') {
        die('Thiếu Token Bank');
    }

    $token = trim($CMSNT->site('token_bank'));
    $stk = trim($CMSNT->site('stk_bank'));
    $mk = trim($CMSNT->site('mk_bank'));
 
    if ($CMSNT->site('type_bank') == 'VietinBank') {
         $result = curl_get2("https://api.web2m.com/historyapivtb/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['transactions'] as $data) {
            $tid            = check_string($data['trxId']);
            $description    = check_string($data['remark']);
            $amount         = check_string(intval($data['amount']));
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' ") == 0){
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua Vietinbank (#$tid - $description - $amount)");
                            if($isCong){
                                /** SEND NOTI CHO ADMIN */
                                $my_text = $CMSNT->site('naptien_notification');
                                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                $my_text = str_replace('{method}', 'Techcombank - Server 2', $my_text);
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
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
                continue;
            }
            if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('VietinBank', $amount) as $row) {
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
                    ], " `id` = '".$row['id']."' AND `status` = 0 ");
                    if ($isUpdate) {
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
                        if (!$isCong) {
                            $CMSNT->update("invoices", [
                            'status'  => 0
                            ], " `id` = '".$row['id']."' ");
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'Techcombank - Server 1', $my_text);
                        $my_text = str_replace('{amount}', format_cash($row['pay']), $my_text);
                        $my_text = str_replace('{price}', format_currency($row['amount']), $my_text);
                        $my_text = str_replace('{time}', gettime(), $my_text);
                        sendMessAdmin($my_text);
                        echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                        break;
                    }
                }
            }
        }
    }
    if ($CMSNT->site('type_bank') == 'Techcombank') {
        $result = curl_get2("https://api.web2m.com/historyapitcb/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['transactions'] as $data) {
            $tid            = check_string($data['TransID']);
            $description    = check_string($data['Description']);
            $amount         = check_string(str_replace(',', '', $data['Amount']));
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' ") == 0){
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua Techcombank (#$tid - $description - $amount)");
                            if($isCong){
                                /** SEND NOTI CHO ADMIN */
                                $my_text = $CMSNT->site('naptien_notification');
                                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                $my_text = str_replace('{method}', 'Techcombank - Server 2', $my_text);
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
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
                continue;
            }
            if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('Techcombank', $amount) as $row) {
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
                    ], " `id` = '".$row['id']."' AND `status` = 0 ");
                    if ($isUpdate) {
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
                        if (!$isCong) {
                            $CMSNT->update("invoices", [
                            'status'  => 0
                            ], " `id` = '".$row['id']."' ");
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'Techcombank - Server 1', $my_text);
                        $my_text = str_replace('{amount}', format_cash($row['pay']), $my_text);
                        $my_text = str_replace('{price}', format_currency($row['amount']), $my_text);
                        $my_text = str_replace('{time}', gettime(), $my_text);
                        sendMessAdmin($my_text);
                        echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                        break;
                    }
                }
            }
        }
    }
    if ($CMSNT->site('type_bank') == 'Vietcombank') {
        $result = curl_get2("https://api.web2m.com/historyapivcb/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['data']['ChiTietGiaoDich'] as $data) {
            $tid            = check_string($data['SoThamChieu']);
            $description    = check_string($data['MoTa']);
            $amount         = check_string(str_replace(',', '', $data['SoTienGhiCo']));
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `description` = '$description'  ") == 0){
                        if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description'  ") == 0){
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
                                $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua Vietcombank (#$tid - $description - $amount)");
                                if($isCong){
                                    /** SEND NOTI CHO ADMIN */
                                    $my_text = $CMSNT->site('naptien_notification');
                                    $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                    $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                    $my_text = str_replace('{method}', 'Vietcombank - Server 2', $my_text);
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
            if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('Vietcombank', $amount) as $row) {
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
                    ], " `id` = '".$row['id']."' AND `status` = 0 ");
                    if($isUpdate){
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
                        if (!$isCong) {
                            $CMSNT->update("invoices", [
                            'status'  => 0
                            ], " `id` = '".$row['id']."' ");
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'Vietcombank - Server 1', $my_text);
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
    }
    if ($CMSNT->site('type_bank') == 'VPBank') {
        $result = curl_get2("https://api.web2m.com/historyapivpb/$mk/$token");
        $result = json_decode($result, true);
        foreach ($result['d']['DepositAccountTransactions']['results'] as $data) {
            $tid            = check_string($data['ReferenceNumber']);
            $description    = check_string($data['Description']);
            $amount         = check_string($data['Amount']);
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description'  ") == 0){
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua VPBank (#$tid - $description - $amount)");
                            if($isCong){
                                /** SEND NOTI CHO ADMIN */
                                $my_text = $CMSNT->site('naptien_notification');
                                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                $my_text = str_replace('{method}', 'VPBank - Server 2', $my_text);
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
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
                continue;
            }
            if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('VPBank', $amount) as $row) {
                if($row['description'] == $description && $row['tid'] == $tid){
                    continue;
                }
                if (isset(explode($row['trans_id'], strtoupper($description))[1])) {
                    $isInsert = $CMSNT->update("invoices", [
                        'status'        => 1,
                        'description'   => $description,
                        'tid'           => $tid,
                        'update_date'   => gettime(),
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 0 ");
                    if($isInsert){
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
                        if (!$isCong) {
                            $CMSNT->update("invoices", [
                            'status'  => 0
                            ], " `id` = '".$row['id']."' ");
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'VPBank - Server 1', $my_text);
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
    }
    if ($CMSNT->site('type_bank') == 'ACB') {
        $result = curl_get2("https://api.web2m.com/historyapiacb/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['transactions'] as $data) {
            $tid            = check_string($data['transactionNumber']);
            $description    = check_string($data['description']);
            $amount         = check_string($data['amount']);
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description'  ") == 0){
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua ACB (#$tid - $description - $amount)");
                            if($isCong){
                                /** SEND NOTI CHO ADMIN */
                                $my_text = $CMSNT->site('naptien_notification');
                                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                $my_text = str_replace('{method}', 'ACB - Server 2', $my_text);
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
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
                continue;
            }
            if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('ACB', $amount) as $row) {
                if($row['description'] == $description && $row['tid'] == $tid){
                    continue;
                }
                if (isset(explode($row['trans_id'], strtoupper($description))[1])) {
                    $isInsert = $CMSNT->update("invoices", [
                        'status'        => 1,
                        'description'   => $description,
                        'tid'           => $tid,
                        'update_date'   => gettime(),
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 0 ");
                    if($isInsert){
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
                        if (!$isCong) {
                            $CMSNT->update("invoices", [
                            'status'  => 0
                            ], " `id` = '".$row['id']."' ");
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'ACB - Server 1', $my_text);
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
    }
    if ($CMSNT->site('type_bank') == 'MBBank') {
        $result = curl_get2("https://api.web2m.com/historyapimbnoti/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['data'] as $data) {
            $tid            = check_string($data['refNo']);
            $description    = check_string($data['description']);
            $amount         = check_string($data['creditAmount']);
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description'  ") == 0){
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
            // XỬ LÝ AUTO SERVER 1
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
                continue;
            }
            if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description' ") > 0){
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
                    ], " `id` = '".$row['id']."' AND `status` = 0 ");
                    if($isUpdate){
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
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
    }
    if ($CMSNT->site('type_bank') == 'TPBank') {
        $result = curl_get2("https://api.web2m.com/historyapitpb/$token");
        $result = json_decode($result, true);
        foreach ($result['transactionInfos'] as $data) {
            $tid            = check_string($data['reference']);
            $description    = check_string($data['description']);
            $amount         = check_string($data['amount']);
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description'  ") == 0){
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua TPBank (#$tid - $description - $amount)");
                            if($isCong){
                                /** SEND NOTI CHO ADMIN */
                                $my_text = $CMSNT->site('naptien_notification');
                                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                $my_text = str_replace('{method}', 'TPBank - Server 2', $my_text);
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
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
                continue;
            }
            if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('TPBank', $amount) as $row) {
                if($row['description'] == $description && $row['tid'] == $tid){
                    continue;
                }
                if (isset(explode($row['trans_id'], strtoupper($description))[1])) {
                    $isInsert = $CMSNT->update("invoices", [
                        'status'        => 1,
                        'description'   => $description,
                        'tid'           => $tid,
                        'update_date'   => gettime(),
                        'update_time'   => time()
                    ], " `id` = '".$row['id']."' AND `status` = 0 ");
                    if($isInsert){
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
                        if (!$isCong) {
                            $CMSNT->update("invoices", [
                            'status'  => 0
                            ], " `id` = '".$row['id']."' ");
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'TPBank - Server 1', $my_text);
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
    }
    if ($CMSNT->site('type_bank') == 'BIDV') {
        $result = curl_get2("https://api.web2m.com/historyapibidv/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['data']['ChiTietGiaoDich'] as $data) {
            $tid            = check_string($data['SoThamChieu']);
            $description    = check_string(str_replace(' ', '', $data['MoTa']));
            $amount         = check_string(str_replace(',', '', $data['SoTienGhiCo']));
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            // XỬ LÝ AUTO SERVER 2
            if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description'  ") == 0){
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua BIDV (#$tid - $description - $amount)");
                            if($isCong){
                                /** SEND NOTI CHO ADMIN */
                                $my_text = $CMSNT->site('naptien_notification');
                                $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                                $my_text = str_replace('{username}', $getUser['username'], $my_text);
                                $my_text = str_replace('{method}', 'BIDV - Server 2', $my_text);
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
            if($CMSNT->num_rows(" SELECT * FROM `invoices` WHERE `description` = '$description' AND `tid` = '$tid' ") > 0){
                continue;
            }
            if($CMSNT->num_rows(" SELECT * FROM `server2_autobank` WHERE `tid` = '$tid' AND `description` = '$description' ") > 0){
                continue;
            }
            foreach (whereInvoicePending('BIDV', $amount) as $row) {
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
                    ], " `id` = '".$row['id']."' AND `status` = 0 ");
                    if($isUpdate){
                        $isCong = $user->AddCredits($row['user_id'], $row['amount'], "Thanh toán hoá đơn nạp tiền #".$row['trans_id'], 'INVOICE_'.$row['trans_id']);
                        if (!$isCong) {
                            $CMSNT->update("invoices", [
                            'status'  => 0
                            ], " `id` = '".$row['id']."' ");
                        }
                        /** SEND NOTI CHO ADMIN */
                        $my_text = $CMSNT->site('naptien_notification');
                        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
                        $my_text = str_replace('{username}', getRowRealtime('users', $row['user_id'], 'username'), $my_text);
                        $my_text = str_replace('{method}', 'Vietcombank - Server 1', $my_text);
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
    }

    // THU HỒI TIỀN THỪA KHI DOUBLE
    // foreach($CMSNT->get_list(" SELECT * FROM `invoices` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 10 ") as $take){
    //     if($CMSNT->num_rows(" SELECT * FROM `dongtien` WHERE `noidung` LIKE '%"."#".$take['trans_id']."%' ") >= 2){
    //         $DBUser = new users();
    //         $isTake = $DBUser->RemoveCredits($take['user_id'], $take['amount'], "[Auto] ".__('Thu hồi lại hoá đơn nạp lỗi')." - invoice_wrong_".$take['trans_id']);
    //         if($isTake){
    //             echo $take['trans_id'];
    //             $CMSNT->remove("dongtien", " `noidung` LIKE '%"."#".$take['trans_id']."%' ORDER BY `id` DESC LIMIT 1 ");
    //         }
    //     }
    // }

        

    curl_get2(base_url('cron/cron.php?pin='.$CMSNT->site('pin_cron')));