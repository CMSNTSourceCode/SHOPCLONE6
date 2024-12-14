<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/database/users.php");

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

use PayPalHttp\HttpException;

$CMSNT = new DB();
$user = new users();

//Client ID và Secret lấy từ https://developer.paypal.com/developer/applications
$clientId = $CMSNT->site('clientId_paypal');
$clientSecret = $CMSNT->site('clientSecret_paypal');
if (isset($_POST['act']) && $_POST['act'] == 'confirm' && isset($_POST['order'])) {
    if ($CMSNT->site('status_paypal') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang được bảo trì')]));
    }
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    // Uncomment nếu dùng trong môi trường production
    $environment = new ProductionEnvironment($clientId, $clientSecret);
    //$environment = new SandboxEnvironment($clientId, $clientSecret);

    $client = new PayPalHttpClient($environment);

    $orderData = $_POST['order'];
    $request = new OrdersGetRequest($orderData['id']);
    try {
        $response = $client->execute($request);
        if ($response->statusCode != 200) {
            die(json_encode(['status' => 'error', 'msg' => __('Đã xảy ra lỗi!')]));
        }
        $order = $response->result;
        if ($order->status != 'COMPLETED') {
            die(json_encode(['status' => 'error', 'msg' => __('Đơn hàng không hợp lệ hoặc chưa thanh toán')]));
        }
        $orderDetail = $order->purchase_units[0];
        if ($CMSNT->num_rows("SELECT * FROM `payment_paypal` WHERE `trans_id` = '".$order->id."' ") > 0) {
            die(json_encode(['status' => 'error', 'msg' => __('Giao dịch này đã được xử lý')]));
        }
        $price = $CMSNT->site('rate_paypal') * $orderDetail->amount->value;
        $isInsert = $CMSNT->insert("payment_paypal", [
            'user_id'       => $getUser['id'],
            'trans_id'      => $order->id,
            'amount'        => $orderDetail->amount->value,
            'price'         => $price,
            'create_date'   => gettime(),
            'create_time'   => time()
        ]);
        if ($isInsert) {
            $user->AddCredits($getUser['id'], $price, "Nạp tiền tự động qua PayPal - $order->id");
            /** SEND NOTI CHO ADMIN */
            $my_text = $CMSNT->site('naptien_notification');
            $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
            $my_text = str_replace('{username}', $getUser['username'], $my_text);
            $my_text = str_replace('{method}', 'PayPal', $my_text);
            $my_text = str_replace('{amount}', $orderDetail->amount->value, $my_text);
            $my_text = str_replace('{price}', $price, $my_text);
            $my_text = str_replace('{time}', gettime(), $my_text);
            sendMessAdmin($my_text);
            die(json_encode(['status' => 'success', 'msg' => __('Nạp tiền thành công')]));
        }
    } catch (HttpException $e) {
        die(json_encode(['status' => 'error', 'msg' => $e->getMessage()]));
    } catch (Exception $e) {
        die(json_encode(['status' => 'error', 'msg' => $e->getMessage()]));
    }
    die();
}
