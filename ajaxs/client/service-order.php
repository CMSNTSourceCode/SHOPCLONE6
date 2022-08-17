<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/sendEmail.php");
require_once(__DIR__."/../../libs/database/users.php");
$User = new users();
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Hệ thống đang bảo trì.']));
    }
    if (empty($_POST['id'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng chọn dịch vụ cần mua.']));
    }
    if (empty($_POST['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập số lượng cần mua.']));
    }
    if (empty($_POST['url'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập link cần tăng.']));
    }
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng đăng nhập.']));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng đăng nhập.']));
    }
    if (time() - $getUser['time_request'] < 2) {
        die(json_encode(['status' => 'error', 'msg' => 'Bạn đang thao tác quá nhanh, vui lòng chờ.']));
    }
    if ($_POST['amount'] <= 0) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập số lượng cần mua.']));
    }
    if (!$row = $CMSNT->get_row("SELECT * FROM `services` WHERE `id` = '".check_string($_POST['id'])."' AND `status` = 1 ")) {
        die(json_encode(['status' => 'error', 'msg' => 'Sản phẩm không tồn tại trong hệ thống.']));
    }
    $id = check_string($_POST['id']);
    $amount = check_string($_POST['amount']);
    $total_payment = $amount * $row['price'];
    if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
        die(json_encode(['status' => 'error', 'msg' => 'Số dư không đủ, vui lòng nạp thêm.']));
    }
    $trans_id = random("QWETYUIOPASDFGHJKLXCVBNM", 4).time();
    $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, "Thanh toán đơn hàng dịch vụ #".$trans_id);
    if ($isBuy) {
        if (getRowRealtime("users", $getUser['id'], "money") < 0) {
            $User->banned($getUser['id'], 'Gian lận khi order dịch vụ');
            die(json_encode(['status' => 'error', 'msg' => 'Bạn đã bị khoá tài khoản vì gian lận.']));
        }
        $isInsertOrder = $CMSNT->insert("service_order", [
            'trans_id'  => $trans_id,
            'seller'    => $row['user_id'],
            'buyer'     => $getUser['id'],
            'service_id'=> $row['id'],
            'url'       => check_string($_POST['url']),
            'amount'    => $amount,
            'pay'       => $total_payment,
            'create_date'=> gettime(),
            'update_date'=> gettime()
        ]);
        if ($isInsertOrder) {
            $guitoi = $CMSNT->site('email');
            $subject = 'Thông báo có đơn đặt hàng dịch vụ cần được xử lý';
            $bcc = $CMSNT->site('title');
            $hoten ='CMSNT BOT';
            $noi_dung = '<h2>Thông tin đơn hàng mới</h2>
            <table >
            <tbody>
            <tr>
            <td>Mã giao dịch:</td>
            <td><b>'.$trans_id.'</b></td>
            </tr>
            <tr>
            <td>Dịch vụ:</td>
            <td><b style="color:blue;">'.$row['name'].'</b></td>
            </tr>
            <tr>
            <td>Số lượng cần mua:</td>
            <td><b>'.format_cash($amount).'</b></td>
            </tr>
            <tr>
            <td>Liên kết cần tăng:</td>
            <td><b>'.$_POST['url'].'</b></td>
            </tr>
            <tr>
            <td>Số tiền thanh toán</td>
            <td><b>'.format_currency($total_payment).'</b></td>
            </tr>
            <tr>
            <td>Thời gian thanh toán:</td>
            <td><b>'.gettime().'</b></td>
            </tr>
            <tr>
            <td>Khách hàng</td>
            <td><b style="color:red;">'.$getUser['username'].'</b></td>
            </tr>
            </tbody>
            </table>';
            sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);
            die(json_encode(['status' => 'success', 'msg' => 'Thanh toán đơn hàng thành công.']));
        } else {
            $User->AddCredits($getUser['id'], $total_payment, "Hoàn tiền đơn hàng dịch vụ #".$trans_id);
            die(json_encode(['status' => 'error', 'msg' => 'Không thể thanh toán, vui lòng thử lại.']));
        }
    }
    die(json_encode(['status' => 'error', 'msg' => 'Không thể thanh toán, vui lòng thử lại.']));
} else {
    die('The Request Not Found');
}
