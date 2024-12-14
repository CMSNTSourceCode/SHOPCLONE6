<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/sendEmail.php");
require_once(__DIR__."/../../libs/database/users.php");

$User = new users();
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status_demo') != 0) {
        die(json_encode(['status' => 'error', 'msg' => 'Bạn không được dùng chức năng này vì đây là trang web demo']));
    }
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if (empty($_POST['id'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Sản phẩm không tồn tại trong hệ thống')]));
    }
    if (empty($_POST['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
    }
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if($getUser['banned'] == 1){
        die(json_encode(['status' => 'error', 'msg' => __('Tài khoản của bạn đã bị cấm truy cập')]));
    }
    if($getUser['admin'] != 1){
        if($getUser['ctv'] == 1){
            die(json_encode(['status' => 'error', 'msg' => __('CTV không được sử dụng tính năng này')]));
        }
    }
    if (time() > $getUser['time_request']) {
        if (time() - $getUser['time_request'] < $CMSNT->site('max_time_buy')) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
        }
    }
    if ($_POST['amount'] <= 0) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
    }
    if (!$row = $CMSNT->get_row("SELECT * FROM `products` WHERE `id` = '".check_string($_POST['id'])."' AND `status` = 1 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Sản phẩm không tồn tại trong hệ thống')]));
    }
    if($_POST['amount'] < $row['minimum']){
        die(json_encode(['status' => 'error', 'msg' => __('Số lượng mua tối thiểu là ').$row['minimum']]));
    }
    if($_POST['amount'] > $row['maximum']){
        die(json_encode(['status' => 'error', 'msg' => __('Số lượng mua tối đa là ').$row['maximum']]));
    }
    $id = check_string($_POST['id']);
    $amount = check_string($_POST['amount']);
    if (is_numeric($amount) && floor($amount) != $amount) {
        die(json_encode(['status' => 'error', 'msg' => __('Số lượng mua không hợp lệ')]));
    }
    if($row['id_connect_api'] != 0){
        // LẤY ROW TABLE CONNECT_API
        $row_connect_api = $CMSNT->get_row(" SELECT * FROM `connect_api` WHERE `id` = '".$row['id_connect_api']."' ");
        if($amount > $row['api_stock']){
            die(json_encode(['status' => 'error', 'msg' => __('Số lượng trong hệ thống không đủ')]));
        }

    }else{
        // SỐ LƯỢNG HỆ THỐNG
        if ($amount > $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '$id' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)']) { 
            die(json_encode(['status' => 'error', 'msg' => __('Số lượng trong hệ thống không đủ')]));
        }
    }
    $total_payment = $amount * $row['price'];
    $total_payment = $total_payment - $total_payment * getDiscount($amount, $id) / 100;
    $total_payment = $total_payment - $total_payment * $getUser['chietkhau'] / 100;
    // Xử lý coupon
    if (!empty($_POST['coupon'])) {
        $discount = checkCoupon(check_string($_POST['coupon']), $getUser['id'], $total_payment);
    }
    // Tính tiền coupon
    if (isset($discount)) {
        $total_payment = $total_payment - $total_payment * $discount / 100;
    }
    if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
        die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
    }
    $trans_id = random("QWETYUIOPASDFGHJKLXCVBNM", 4).time();
    $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua tài khoản')." (".check_string($row['name']).")"." #".$trans_id, 'BUY_WEBSITE_'.uniqid().'_'.$trans_id);
    if ($isBuy) {
        if (getRowRealtime("users", $getUser['id'], "money") < 0) {
            $User->Banned($getUser['id'], __('Gian lận khi mua tài khoản'));
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã bị khoá tài khoản vì gian lận')]));
        }
        $api_trans_id = NULL;
        $id_connect_api = 0;
        if($row['id_connect_api'] != 0){


            // API CMSNT
            if($row_connect_api['type'] == 'CMSNT'){
                $data = curl_get2($row_connect_api['domain']."/api/BResource.php?username=".$row_connect_api['username']."&password=".$row_connect_api['password']."&id=".$row['id_api'].'&amount='.$amount);
                $data = json_decode($data, true);
                if($data['status'] == 'error'){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']);
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


            // API SHOPCLONE7
            if($row_connect_api['type'] == 'SHOPCLONE7'){
                $data = buy_API_SHOPCLONE7($row_connect_api['domain'], $row_connect_api['username'], $row_connect_api['password'], $row['id_api'], $amount);
                $data = json_decode($data, true);
                if($data['status'] == 'error'){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['msg'])]));
                }
                $api_trans_id = $data['trans_id'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['data'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    =>  $row['id']
                    ]);
                }
            }

            // API 1
            if($row_connect_api['type'] == 'API_1'){
                $dataPost = [
                    'api_key' => $row_connect_api['password'],
                    'id_product' => $row['id_api'],
                    'quantity' => $amount,
                ];
                $response = buy_API_1($row_connect_api['domain'], $dataPost);
                $data = json_decode($response, true);
                if($data['status'] == false){
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

            // API 4
            if($row_connect_api['type'] == 'API_4'){
                $response = buy_API_4($row_connect_api['domain'], $row_connect_api['token'], $row['id_api'], $amount);
                $data = json_decode($response, true);
                if(!isset($data['data'])){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['message']['messageVNI'])]));
                } 
                $api_trans_id = NULL;
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['data'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // DONGVANFB
            if($row_connect_api['type'] == 'DONGVANFB'){
                $response = buy_API_DONGVANFB($row_connect_api['domain'], $row_connect_api['password'], $row['id_api'], $amount);
                $data = json_decode($response, true);
                if($data['status'] == false){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
                } 
                $api_trans_id = $data['data']['order_code'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['data']['list_data'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // API 6
            if($row_connect_api['type'] == 'API_6'){
                $response = curl_get2($row_connect_api['domain'].'/api.php?apikey='.$row_connect_api['password'].'&action=create-order&service_id='.$row['id_api'].'&amount='.$amount);
                $data = json_decode($response, true);
                if($data['code'] != 200){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
                }
                $api_trans_id = $data['order_id'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                for ($i=1; $i >= 1 ; $i++) {
                    $response = curl_get2($row_connect_api['domain'].'/api.php?apikey='.$row_connect_api['password'].'&action=get-order-detail&order_id='.$api_trans_id);
                    $data_account = json_decode($response, true);
                    if($data_account['order']['status'] == 1){
                        break;
                    }
                }
                if(explode(PHP_EOL, $data_account['order']['data'])){
                    $lines = explode(PHP_EOL, $data_account['order']['data']);
                }else{
                    // FIX DO API BMTRAU THAY ĐỔI JSON API
                    $lines = $data_account['order']['data'];
                }
                foreach($lines as $account){
                    if($account == ''){
                        continue;
                    }
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => check_string($account),
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // API 7
            if($row_connect_api['type'] == 'API_7'){
                $response = buy_API_7($row_connect_api['domain'], $row_connect_api['password'], $row['id_api'], $amount);
                $data = json_decode($response, true);
                if($data['success']['status'] != 'completed'){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __('Sản phẩm này không đủ, vui lòng thử lại sau')]));
                } 
                $api_trans_id = '';
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['success']['products'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // API 8
            if($row_connect_api['type'] == 'API_8'){
                $dataPost = [
                    'is_agency'     => 0,
                    'group_id'      => $row['id_api'],
                    'quantity'      => $amount
                ];
                $response = buy_API_8($row_connect_api['domain'], $row_connect_api['password'], $dataPost);
                $data = json_decode($response, true);
                if($data['success'] != true){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __("Error code ".$data['error'])]));
                } 
                $api_trans_id = $data['data']['order_id'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['data']['full_accounts'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // API 9
            if($row_connect_api['type'] == 'API_9'){
                $dataPost = [
                    'type_id' => $row['id_api'],
                    'quantity' => $amount
                ];
                $response = buy_API_9($row_connect_api['domain'], $row_connect_api['password'], $dataPost);
                $data = json_decode($response, true);
                if($data['error'] != 0){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __("Error code ".$data['error'])]));
                } 
                $api_trans_id = $data['data']['buy_id'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['data']['data'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // API 10
            if($row_connect_api['type'] == 'API_10'){
                $response = curl_get2($row_connect_api['domain'].'mail/buy?apikey='.$row_connect_api['password'].'&mailcode='.$row['name_api'].'&quantity='.$amount);
                $data = json_decode($response, true);
                if($data['Code'] != 0){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __("Error ".$data['Message'])]));
                } 
                $api_trans_id = $data['Data']['TransId'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['Data']['Emails'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account['Email'].'|'.$account['Password'],
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }
            
            //API 11
            if($row_connect_api['type'] == 'API_11'){
                $response = curl_get2($row_connect_api['domain'].'user/buy_facebook?apikey='.$row_connect_api['password'].'&account_type='.$row['id_api'].'&quality='.$amount);
                $data = json_decode($response, true);
                if($data['status'] == false){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
                } 
                $api_trans_id = $data['data']['order_code'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['data']['list_data'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            //API 12
            if($row_connect_api['type'] == 'API_12'){
                $response = buy_API_12($row_connect_api['domain'], $row_connect_api['password'], $row['id_api'], $amount);
                $data = json_decode($response, true);
                if($data['error_code'] == 1){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
                }
                $order_id = check_string($data['order_id']);
                $data = json_decode(getOrder_API_12($row_connect_api['domain'], $row_connect_api['password'], $order_id), true);
                if($data['error_code'] == 1){
                    die(json_encode(['status' => 'error', 'msg' => __('Vui lòng liên hệ Admin để nhận đơn hàng lỗi')]));
                }
                $api_trans_id = $data['data']['id'];
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                $listAccount = explode(PHP_EOL, $data['data']['data']);
                foreach($listAccount as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            //API 13
            if($row_connect_api['type'] == 'API_13'){
                $response = buy_API_13($row_connect_api['domain'], $row_connect_api['username'], $row_connect_api['password'], $row['id_api'], $amount, $trans_id);
                $data = json_decode($response, true);
                if($data['IsSuccessed'] != true){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['Message'])]));
                }
                $order_id = check_string($data['Data']);
                sleep(5);
                $data = json_decode(getOrder_API_13($row_connect_api['domain'], $row_connect_api['username'], $row_connect_api['password'], $order_id), true);
                if($data['IsSuccessed'] != true){
                    die(json_encode(['status' => 'error', 'msg' => __('Vui lòng liên hệ Admin để nhận đơn hàng lỗi')]));
                }
                $api_trans_id = $order_id;
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['Data'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => $account,
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // API 14
            if($row_connect_api['type'] == 'API_14'){
                $response = buy_API_14($row_connect_api['domain'], $row_connect_api['username'], $row_connect_api['password'], $row['id_api'], $amount, $trans_id);
                 
                $data = json_decode($response, true);
                if($data['error_code'] == 1){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']);
                    die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
                }
                $order_id = check_string($data['order_id']);
                sleep(2);
                $data_account = json_decode(getOrder_API_14($row_connect_api['domain'], $row_connect_api['username'], $row_connect_api['password'], $order_id), true);
                if(!isset($data_account['data'])){
                    die(json_encode(['status' => 'error', 'msg' => __('Vui lòng liên hệ Admin để nhận đơn hàng lỗi')]));
                }
                $api_trans_id = $order_id;
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                $lines = explode(PHP_EOL, $data_account['data']['data']);
                foreach($lines as $account){
                    if($account == ''){
                        continue;
                    }
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => check_string($account),
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // API 15
            if($row_connect_api['type'] == 'API_15'){
                $response = buy_API_15($row_connect_api['domain'], $row_connect_api['username'], $row_connect_api['password'], $row['id_api'], $amount, $trans_id);
                $data = json_decode($response, true);
                if($data['status'] != true){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']." (".$data['message'].")");
                    die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
                }
                $order_id = check_string($data['data']['order_code']);
                $api_trans_id = $order_id;
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach($data['data']['list_data'] as $account){
                    // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                    $CMSNT->insert("accounts", [
                        'seller'        => $row['user_id'],
                        'buyer'         => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'api_trans_id'  => $api_trans_id,
                        'account'       => check_string($account),
                        'status'        => 'LIVE',
                        'update_date'   => gettime(),
                        'create_date'   => gettime(),
                        'product_id'    => $row['id']
                    ]);
                }
            }

            // API 17
            if($row_connect_api['type'] == 'API_17'){
                $data = curl_get2($row_connect_api['domain']."/api/BuyProduct.php?username=".$row_connect_api['username']."&password=".$row_connect_api['password']."&id=".$row['id_api'].'&amount='.$amount);
                $data = json_decode($data, true);
                if($data['status'] == 'error'){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']);
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
            
            // API 23
            if($row_connect_api['type'] == 'API_23'){
                $response = buy_API_23($row_connect_api['domain'], $row_connect_api['password'], $row['id_api'], $amount);
                $data = json_decode($response, true);
                if($data['status'] != 'success'){
                    $User->RefundCredits($getUser['id'], $total_payment, "[Error] ".__('Hoàn tiền đơn hàng mua tài khoản')." #".$trans_id." - ".$row['name']." (".$data['message'].")");
                    die(json_encode(['status' => 'error', 'msg' => __($data['detail'])]));
                }
                $order_id = NULL;
                $api_trans_id = $order_id;
                $id_connect_api = $row['id_connect_api'];
                $isUpdateAccount = 1;
                foreach(explode(',', $data['data']) as $account){
                    if (!empty($account)) {
                        // THÊM TÀI KHOẢN TỪ API VÀO HỆ THỐNG
                        $CMSNT->insert("accounts", [
                            'seller'        => $row['user_id'],
                            'buyer'         => $getUser['id'],
                            'trans_id'      => $trans_id,
                            'api_trans_id'  => $api_trans_id,
                            'account'       => check_string($account),
                            'status'        => 'LIVE',
                            'update_date'   => gettime(),
                            'create_date'   => gettime(),
                            'product_id'    => $row['id']
                        ]);
                    }
                }
            }

        }else{
            $order_by = 'ORDER BY `id` ASC';
            if($row['filter_time_checklive'] == 1){
                $order_by = 'ORDER BY `time_live` DESC';
            } else if($row['filter_time_checklive'] == 2){
                $order_by = 'ORDER BY `id` DESC';
            }
            // MUA TÀI KHOẢN TỪ HỆ THỐNG
            $isUpdateAccount = $CMSNT->update_value("accounts", [
                'buyer' => $getUser['id'],
                'trans_id' => $trans_id,
                'update_date' => gettime()
            ], " `product_id` = '$id' AND `buyer` IS NULL AND `status` = 'LIVE' $order_by ", $amount);
        }
        if ($isUpdateAccount) {
            if($CMSNT->num_rows(" SELECT * FROM `accounts` WHERE `trans_id` = '$trans_id' AND `buyer` = '".$getUser['id']."' ") == 0){
                // Hoàn tiền người mua
                $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
                die(json_encode(['status' => 'error', 'msg' => __('Số lượng trong hệ thống không đủ')]));
            }
            /* THÊM ĐƠN HÀNG VÀO HỆ THỐNG */
            $CMSNT->insert("orders", [
                'trans_id'      => $trans_id,
                'name'          => $row['name'],
                'api_trans_id'  => $api_trans_id,
                'id_connect_api'    => $id_connect_api,
                'seller'        => $row['user_id'],
                'buyer'         => $getUser['id'],
                'product_id'    => $row['id'],
                'amount'        => $amount,
                'pay'           => $total_payment,
                'cost'          => $row['cost'] * $amount,
                'create_date'   => gettime(),
                'create_time'   => time()
            ]);


            /* SỬ DỤNG MÃ GIẢM GIÁ */
            if (isset($discount) && $discount > 0) {
                $isAddCoupon = $CMSNT->cong("coupons", "used", 1, " `code` = '".check_string($_POST['coupon'])."' ");
                if ($isAddCoupon) {
                    $CMSNT->insert("coupon_used", [
                        'coupon_id'     => $CMSNT->get_row("SELECT * FROM `coupons` WHERE `code` = '".check_string($_POST['coupon'])."' ")['id'],
                        'user_id'       => $getUser['id'],
                        'trans_id'      => $trans_id,
                        'createdate'    => gettime()
                    ]);
                }
            }


            /* CỘNG LƯỢT QUAY CHO ĐƠN HÀNG ĐỦ ĐIỀU KIỆN */
            claimSpin($getUser['id'], $trans_id, $total_payment);
            // CỘNG REF
            addRef($getUser['id'], $total_payment, __('Đơn hàng mua tài khoản')." #".$trans_id);
            $CMSNT->update("users", [
                'time_request' => time()
            ], " `id` = '".$getUser['id']."' ");

            if($CMSNT->site('status_addfun_seller') == 1 ){
                /* CỘNG DOANH THU CHO NGƯỜI BÁN */
                $User->AddCredits($row['user_id'], $total_payment, __('Doanh thu đơn hàng bán tài khoản')." #".$trans_id);
            }
            
            /* GỬI EMAIL ĐƠN HÀNG CHO NGƯỜI MUA*/
            if($CMSNT->site('pass_email_smtp') != ''){
                // TẠO FILE TXT
                $file_txt_email = '';
                foreach ($CMSNT->get_list(" SELECT * FROM `accounts` WHERE `trans_id` = '$trans_id' ORDER BY id DESC ") as $clone_txt) {
                    $file_txt_email .= htmlspecialchars_decode($clone_txt['account']).PHP_EOL;
                }
                $file_txt_name = $trans_id.".txt";
                file_put_contents($file_txt_name, $file_txt_email);
                // GỬI EMAIL
                $chu_de = __('Xác nhận thanh toán hóa đơn')." #$trans_id ".__('thành công');
                $content = curl_get2(base_url('libs/mails/buyProduct.php'));
                $content = str_replace('{product_name}', $row['name'], $content);
                $content = str_replace('{amount}', format_cash($amount), $content);
                $content = str_replace('{trans_id}', $trans_id, $content);
                $content = str_replace('{price}', format_currency($total_payment), $content);
                $bcc = $CMSNT->site('title');
                sendCSM($getUser['email'], $getUser['username'], $chu_de, $content, $bcc, $file_txt_name);
                if (file_exists($file_txt_name)) {
                    unlink($file_txt_name);
                } 
            }

            /** SEND NOTI CHO ADMIN */
            $my_text = $CMSNT->site('buy_notification');
            $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
            $my_text = str_replace('{username}', $getUser['username'], $my_text);
            $my_text = str_replace('{product_name}', $row['name'], $my_text);
            $my_text = str_replace('{amount}', format_cash($amount), $my_text);
            $my_text = str_replace('{price}', format_currency($total_payment), $my_text);
            $my_text = str_replace('{trans_id}', $trans_id, $my_text);
            $my_text = str_replace('{time}', gettime(), $my_text);
            $my_text = str_replace('{method}', 'Website', $my_text);
            $my_text = str_replace('{available}', $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '$id' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'], $my_text);
            sendMessAdmin($my_text);

            // CỘNG SỐ LƯỢNG ĐÃ BÁN
            $CMSNT->cong('products', 'sold', $amount, " `id` = '".$row['id']."' ");

            die(json_encode(['status' => 'success', 'transid' => $trans_id, 'msg' => __('Thanh toán đơn hàng thành công')]));
        } else {
            // Hoàn tiền người mua
            $User->RefundCredits($getUser['id'], $total_payment, "[Error] Hoàn tiền đơn hàng mua tài khoản #".$trans_id." - ".$row['name']);
            die(json_encode(['status' => 'error', 'msg' => __('Số lượng trong hệ thống không đủ')]));
        }
    }
    die(json_encode(['status' => 'error', 'msg' => __('Không thể thanh toán, vui lòng thử lại')]));
} else {
    die('The Request Not Found');
}
