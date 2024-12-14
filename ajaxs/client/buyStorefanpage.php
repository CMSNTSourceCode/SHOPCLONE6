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
    if ($CMSNT->site('status_store_fanpage') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang được bảo trì')]));
    }
    if (empty($_POST['id'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Sản phẩm không tồn tại trong hệ thống')]));
    }
    if (empty($_POST['url'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập Link Facebook hoặc UID để set làm admin')]));
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
    if (!$row = $CMSNT->get_row("SELECT * FROM `store_fanpage` WHERE `id` = '".check_string($_POST['id'])."' AND `buyer` = 0 ")) {
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
    $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, "Thanh toán đơn hàng mua Fanpage/Group ".$row['name']);
    if ($isBuy) {
        if (getRowRealtime("users", $getUser['id'], "money") < 0) {
            $User->Banned($getUser['id'], 'Gian lận khi mua Fanpage/Group');
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
        /* CẬP NHẬT ĐƠN HÀNG */
        $CMSNT->update("store_fanpage", [
             'buyer'    => $getUser['id'],
             'url'      => check_string($_POST['url']),
             'new_name' => !empty($_POST['new_name']) ? check_string($_POST['new_name']) : NULL,
             'update_gettime'   => gettime(),
             'update_time'      => time()
        ], " `id` = '".$row['id']."' ");
        $CMSNT->update("users", [
            'time_request' => time()
        ], " `id` = '".$getUser['id']."' ");
        /* CỘNG DOANH THU CHO NGƯỜI BÁN */
        $isAddCreditsRef = $User->AddCredits($row['seller'], $total_payment, "Doanh thu bán Fanpage/Group ".$row['name']);

        $chu_de = '[CMSNT] Thông báo có đơn hàng mua Fanpage/Group mới đang chờ xử lý';
        $noi_dung = '<h5>Thông tin chi tiết đơn hàng!</h5>
        <ul>
            <li>-----------------------------------------------</li>
            <li>Khách hàng: '.$getUser['username'].'</li>
            <li>'.$row['type'].': '.$row['name'].'</li>
            <li>Giá: '.format_currency($row['price']).'</li>
            <li>UID/LINK: '.check_string($_POST['url']).'</li>
            <li>-----------------------------------------------</li>
            <li>Thời gian: '.gettime().'</li>
            <li>IP: '.myip().'</li>
            <li>Thiết bị: '.$Mobile_Detect->getUserAgent().'</li>
        </ul>';
        $bcc = $CMSNT->site('title');
        sendCSM($CMSNT->site('email'), $CMSNT->site('email'), $chu_de, $noi_dung, $bcc);

        /** SEND NOTI CHO ADMIN */
        $my_text = $CMSNT->site('buy_fanpage_notification');
        $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
        $my_text = str_replace('{username}', $getUser['username'], $my_text);
        $my_text = str_replace('{product_name}', $row['type'].': '.$row['name'], $my_text);
        $my_text = str_replace('{price}', format_currency($row['price']), $my_text);
        $my_text = str_replace('{url}', check_string($_POST['url']), $my_text);
        $my_text = str_replace('{time}', gettime(), $my_text);
        $my_text = str_replace('{method}', 'Website', $my_text);
        sendMessAdmin($my_text);


        die(json_encode(['status' => 'success', 'msg' => __('Thanh toán đơn hàng thành công')]));
    }
    die(json_encode(['status' => 'error', 'msg' => __('Không thể thanh toán, vui lòng thử lại')]));
} else {
    die('The Request Not Found');
}
