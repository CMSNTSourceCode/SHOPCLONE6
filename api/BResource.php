<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/lang.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
$User = new users();
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if (isset($_GET['username']) && isset($_GET['password'])) {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".check_string($_GET['username'])."'  ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => __('Thông tin đăng nhập không chính xác')
        ]));
    }
    $password = check_string($_GET['password']);
    if ($CMSNT->site('type_password') == 'bcrypt') {
        if (!password_verify($password, $getUser['password'])) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Thông tin đăng nhập không chính xác')
            ]));
        }
    } else {
        if ($getUser['password'] != TypePassword($password)) {
            die(json_encode(['status' => 'error','msg' => __('Thông tin đăng nhập không chính xác')]));
        }
    }
    if (time() > $getUser['time_request']) {
        if (time() - $getUser['time_request'] < $CMSNT->site('max_time_buy')) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
        }
    }
    if($getUser['admin'] == 1){
        // kiểm tra ip có trong whitelist
        if($CMSNT->site('status_security') == 1){
            if(!$CMSNT->get_row("SELECT * FROM `ip_white` WHERE `ip` = '".myip()."' ")){
                die(json_encode(['status' => 'error','msg' => __('IP của bạn không được phép truy cập')]));
            }
        }
    }
    if (!isset($_GET['id'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập id sản phẩm cần mua')]));
    }
    if (!isset($_GET['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng tài nguyên cần mua')]));
    } 
    $id = check_string($_GET['id']);
    $amount = check_string($_GET['amount']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `products` WHERE `id` = '$id' AND `status` = 1 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Sản phẩm không tồn tại trong hệ thống')]));
    }
    if($_GET['amount'] < $row['minimum']){
        die(json_encode(['status' => 'error', 'msg' => __('Số lượng mua tối thiểu là ').$row['minimum']]));
    }
    if($_GET['amount'] > $row['maximum']){
        die(json_encode(['status' => 'error', 'msg' => __('Số lượng mua tối đa là ').$row['maximum']]));
    }
    if($row['id_api'] != 0){
        // LẤY ROW TABLE CONNECT_API
        $row_connect_api = $CMSNT->get_row(" SELECT * FROM `connect_api` WHERE `id` = '".$row['id_connect_api']."' ");

        // API CMSNT
        if($row_connect_api['type'] == 'CMSNT'){
            $data = curl_get($row_connect_api['domain']."/api/InfoResource.php?username=".$row_connect_api['username']."&password=".$row_connect_api['password']."&id=".$row['id_api']);
            $data = json_decode($data, true);
            if($data['status'] != 'success'){
                die(json_encode(['status' => 'error', 'msg' => __($data['msg'])]));
            }
            if($amount > $data['data']['amount']){
                die(json_encode(['status' => 'error', 'msg' => __('Số lượng trong hệ thống không đủ')]));
            }
        }
        // API 1
        else if($row_connect_api['type'] == 'API_1'){
            if($amount > $row['api_stock']){
                die(json_encode(['status' => 'error', 'msg' => __('Số lượng trong hệ thống không đủ')]));
            }
        }

    }else{
        // SỐ LƯỢNG HỆ THỐNG
        if ($amount > $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '$id' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)']) {
            die(json_encode(['status' => 'error', 'msg' => __('Số lượng trong hệ thống không đủ')]));
        }
    }
    $total_payment = $amount * $row['price'];
    $total_payment = $total_payment - $total_payment * $getUser['chietkhau'] / 100;
    if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
        die(json_encode(['status' => 'error', 'msg' => __('Số dư API không đủ, vui lòng liên hệ admin')]));
    }
    $trans_id = random("QWETYUIOPASDFGHJKLXCVBNM", 4).time();
    $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, "[API] Thanh toán đơn hàng mua tài khoản #".$trans_id);
    if ($isBuy) {
        if (getRowRealtime("users", $getUser['id'], "money") < 0) {
            $User->Banned($getUser['id'], '[API] Gian lận khi mua tài khoản');
            die(json_encode(['status' => 'error', 'msg' => 'Bạn đã bị khoá tài khoản vì gian lận.']));
        }
        $api_trans_id = NULL;
        $id_connect_api = 0;
        if($row['id_api'] != 0){
            // API CMSNT
            if($row_connect_api['type'] == 'CMSNT'){
                $data = curl_get($row_connect_api['domain']."/api/BResource.php?username=".$row_connect_api['username']."&password=".$row_connect_api['password']."&id=".$row['id_api'].'&amount='.$amount);
                $data = json_decode($data, true);
                if($data['status'] != 'success'){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['msg'])]));
                }
                $api_trans_id = $data['data']['trans_id'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['data']['lists'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account['account'],
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    =>  $row['id']
                    ]);
                }
            }
            // API 1
            else if($row_connect_api['type'] == 'API_1'){
                $dataPost = [
                    'api_key' => $row_connect_api['password'],
                    'id_product' => $row['id_api'],
                    'quantity' => $amount,
                ];
                $response = buy_API_1($row_connect_api['domain'], $dataPost);
                $data = json_decode($response, true);
                if($data['status'] != true){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['msg'])]));
                }
                $api_trans_id = $data['order_id'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                $response = order_API_1($row_connect_api['domain'], $row_connect_api['password'], $data['order_id']);
                $data_account = json_decode($response, true);
                foreach($data_account['data'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account['full_info'],
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }
        }else{
            $order_by = 'ORDER BY `id` ASC';
            if($row['filter_time_checklive'] == 1){
                $order_by = 'ORDER BY `time_live` DESC';
            }
            // MUA TÀI KHOẢN TỪ HỆ THỐNG
            $isUpdateAccount = $CMSNT->update_value("accounts", [
                'buyer' => $getUser['id'],
                'trans_id' => $trans_id,
                'update_date' => gettime()
            ], " `product_id` = '$id' AND `buyer` IS NULL AND `status` = 'LIVE' $order_by ", $amount);
        }
        if ($isUpdateAccount) {
            /* THÊM ĐƠN HÀNG VÀO HỆ THỐNG */
            $CMSNT->insert("orders", [
                'trans_id'      => $trans_id,
                'api_trans_id'  => $api_trans_id,
                'id_connect_api'  => $id_connect_api,
                'seller'        => $row['user_id'],
                'buyer'         => $getUser['id'],
                'product_id'    => $row['id'],
                'amount'        => $amount,
                'pay'           => $total_payment,
                'cost'          => $row['cost'] * $amount,
                'create_date'   => gettime(),
                'create_time'   => time()
            ]);

            /** SEND NOTI CHO ADMIN */
            $my_text = $CMSNT->site('buy_notification');
            $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
            $my_text = str_replace('{username}', $getUser['username'], $my_text);
            $my_text = str_replace('{product_name}', $row['name'], $my_text);
            $my_text = str_replace('{amount}', $amount, $my_text);
            $my_text = str_replace('{price}', $total_payment, $my_text);
            $my_text = str_replace('{trans_id}', $trans_id, $my_text);
            $my_text = str_replace('{time}', gettime(), $my_text);
            $my_text = str_replace('{method}', 'API', $my_text);
            sendMessAdmin($my_text);
            
            addRef($getUser['id'], $total_payment);
            claimSpin($getUser['id'], $trans_id, $total_payment);

            // CỘNG SỐ LƯỢNG ĐÃ BÁN
            $CMSNT->cong('products', 'sold', $amount, " `id` = '".$row['id']."' ");


            // Nhập thời gian request chống spam
            $CMSNT->update("users", [
                'time_request' => time()
            ], " `id` = '".$getUser['id']."' ");
            $accounts = [];
            foreach ($CMSNT->get_list("SELECT * FROM `accounts` WHERE `trans_id` = '$trans_id' ") as $taikhoan) {
                $accounts[] =
                [
                    'account'   => $taikhoan['account']
                ];
            }
            die(json_encode([
                'status'    => 'success',
                'msg'       => 'Thanh toán đơn hàng thành công.',
                'data'      =>
                [
                    'trans_id'  => $trans_id,
                    'category'  => getRowRealtime("categories", $row['category_id'], 'name'),
                    'name'      => $row['name'],
                    'amount'    => $amount,
                    'time'      => time(),
                    'lists'     => $accounts
                ]
            ]));
        } else {
            // Hoàn tiền người mua
            $User->RefundCredits($getUser['id'], $total_payment, "[API] Hoàn tiền đơn hàng mua tài khoản #".$trans_id);
            die(json_encode(['status' => 'error', 'msg' => 'Không thể thanh toán, vui lòng thử lại.']));
        }
    }
    die(json_encode(['status' => 'error', 'msg' => 'Không thể thanh toán, vui lòng thử lại.']));
}
