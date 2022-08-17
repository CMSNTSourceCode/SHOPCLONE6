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
    $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, "Thanh toán đơn hàng mua tài khoản #".$trans_id);
    if ($isBuy) {
        if (getRowRealtime("users", $getUser['id'], "money") < 0) {
            $User->Banned($getUser['id'], 'Gian lận khi mua tài khoản');
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã bị khoá tài khoản vì gian lận')]));
        }
        $api_trans_id = NULL;
        $id_connect_api = 0;
        if($row['id_api'] != 0){
            // API CMSNT
            if($row_connect_api['type'] == 'CMSNT'){
                $data = curl_get($row_connect_api['domain']."/api/BResource.php?username=".$row_connect_api['username']."&password=".$row_connect_api['password']."&id=".$row['id_api'].'&amount='.$amount);
                $data = json_decode($data, true);
                if($data['status'] == 'error'){
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
            addRef($getUser['id'], $total_payment);
            $CMSNT->update("users", [
                'time_request' => time()
            ], " `id` = '".$getUser['id']."' ");

            /* GỬI EMAIL ĐƠN HÀNG CHO NGƯỜI MUA*/
            if($CMSNT->site('email_smtp') != ''){
                $chu_de = "Xác nhận thanh toán hóa đơn #$trans_id thành công";
                $content = file_get_contents(base_url('libs/mails/buyProduct.php'));
                $content = str_replace('{product_name}', $row['name'], $content);
                $content = str_replace('{amount}', format_cash($amount), $content);
                $content = str_replace('{trans_id}', $trans_id, $content);
                $content = str_replace('{price}', format_currency($total_payment), $content);
                $bcc = $CMSNT->site('title');
                sendCSM($getUser['email'], $getUser['username'], $chu_de, $content, $bcc);
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
            sendMessAdmin($my_text);

            // CỘNG SỐ LƯỢNG ĐÃ BÁN
            $CMSNT->cong('products', 'sold', $amount, " `id` = '".$row['id']."' ");

            die(json_encode(['status' => 'success', 'msg' => __('Thanh toán đơn hàng thành công')]));
        } else {
            // Hoàn tiền người mua
            $User->RefundCredits($getUser['id'], $total_payment, "Hoàn tiền đơn hàng mua tài khoản #".$trans_id);
            die(json_encode(['status' => 'error', 'msg' => __('Số lượng trong hệ thống không đủ')]));
        }
    }
    die(json_encode(['status' => 'error', 'msg' => __('Không thể thanh toán, vui lòng thử lại')]));
} else {
    die('The Request Not Found');
}
