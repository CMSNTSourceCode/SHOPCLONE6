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
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (time() > $getUser['time_request']) {
        if (time() - $getUser['time_request'] < $config['max_time_load']) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
        }
    }
    if (!$row = $CMSNT->get_row("SELECT * FROM `documents` WHERE `id` = '".check_string($_POST['id'])."' AND `status` = 1 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Sản phẩm không tồn tại trong hệ thống')]));
    }
    $id = check_string($_POST['id']);
    $amount = 1;
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
    $trans_id = random("QWETYUIOPASDFGHJKLXCVBNM", 2).time();
    $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, "Thanh toán đơn hàng mua TUT/TRICK #".$trans_id);
    if ($isBuy) {
        if (getRowRealtime("users", $getUser['id'], "money") < 0) {
            $User->Banned($getUser['id'], 'Gian lận khi mua TUT/TRICK');
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã bị khoá tài khoản vì gian lận')]));
        }   
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
        /* THÊM ĐƠN HÀNG VÀO HỆ THỐNG */
        $CMSNT->insert("orders", [
            'trans_id'      => $trans_id,
            'seller'        => $row['user_id'],
            'buyer'         => $getUser['id'],
            'document_id'   => $row['id'],
            'amount'        => $amount,
            'pay'           => $total_payment,
            'create_date'   => gettime(),
            'create_time'   => time(),
            'fake'          => 0
        ]);
        // CỘNG REF
        addRef($getUser['id'], $total_payment);
        /* CỘNG LƯỢT QUAY CHO ĐƠN HÀNG ĐỦ ĐIỀU KIỆN */
        claimSpin($getUser['id'], $trans_id, $total_payment);
        $CMSNT->update("users", [
            'time_request' => time()
        ], " `id` = '".$getUser['id']."' ");

        if($CMSNT->site('status_addfun_seller') == 1 ){
            /* CỘNG DOANH THU CHO NGƯỜI BÁN */
            $User->AddCredits($row['user_id'], $total_payment, "Doanh thu đơn hàng bán tài khoản #".$trans_id);
        }
 


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
        $my_text = str_replace('{amount}', 1, $my_text);
        $my_text = str_replace('{price}', format_currency($total_payment), $my_text);
        $my_text = str_replace('{trans_id}', $trans_id, $my_text);
        $my_text = str_replace('{time}', gettime(), $my_text);
        $my_text = str_replace('{method}', 'Website', $my_text);
        sendMessAdmin($my_text);
        die(json_encode(['status' => 'success', 'msg' => __('Thanh toán đơn hàng thành công')]));
    }
    die(json_encode(['status' => 'error', 'msg' => __('Không thể thanh toán, vui lòng thử lại')]));
} else {
    die('The Request Not Found');
}
