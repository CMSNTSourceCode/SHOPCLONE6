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
        die(json_encode(['status' => 'error', 'msg' => __('Bạn không được dùng chức năng này vì đây là trang web demo')]));
    }
    if ($CMSNT->site('status_thuesim') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang được bảo trì')]));
    }
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if (empty($_POST['id'])) {
        die(json_encode(['status' => 'error', 'msg' => __('ID dịch vụ không tồn tại trong hệ thống')]));
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
    if (time() > $getUser['time_request']) {
        if (time() - $getUser['time_request'] < $CMSNT->site('max_time_buy')) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
        }
    }
    if ($_POST['amount'] <= 0) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
    }
    if ($_POST['amount'] > 10) {
        die(json_encode(['status' => 'error', 'msg' => __('Số lượng mua tối đa 1 lần là 10')]));
    }
    if (!$row = $CMSNT->get_row("SELECT * FROM `service_otp` WHERE `id` = '".check_string($_POST['id'])."' AND `status` = 1 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này không tồn tại trong hệ thống')]));
    }
    $id = check_string($_POST['id']);
    $amount = check_string($_POST['amount']);
    $price = $row['price'];
    $total_payment = $amount * $row['price'];
    $total_payment = $total_payment - $total_payment * $getUser['chietkhau'] / 100;
    $telco = '';
    $phone = '';

    if(isset($_POST['telco'])){
        foreach($_POST['telco'] as $b){
            $telco .= $b.',';
        }
        $telco = substr($telco, 0, -1);
    }
    if(isset($_POST['phone'])){
        foreach($_POST['phone'] as $b){
            $phone .= $b.',';
        }
        $phone = substr($phone, 0, -1);
    }


    if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
        die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
    }

    for ($i=0; $i < $amount; $i++) { 
        if(getRowRealtime("users", $getUser['id'], "money") < $price){
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }

        $trans_id = random("QWETYUIOPASDFGHJKLXCVBNM", 4).time();
        $isBuy = $User->RemoveCredits($getUser['id'], $price, "".__('Thanh toán đơn hàng thuê OTP')." #".$trans_id);
        if ($isBuy){
            if (getRowRealtime("users", $getUser['id'], "money") < 0) {
                $User->Banned($getUser['id'], __('Gian lận khi mua tài khoản'));
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đã bị khoá tài khoản vì gian lận')]));
            }

            if($CMSNT->site('server_thuesim') == 'API_1'){
                $telco = str_replace('Vinaphone', 'Vina', $telco);
                $telco = str_replace('Mobifone', 'Mobi', $telco);
                $telco = str_replace('Vietnamobile', 'VNMB', $telco);
                $data = curl_get($CMSNT->site('domain_thuesim').'api?act=number&apik='.$CMSNT->site('token_thuesim').'&appId='.$row['id_api'].'&carrier='.$telco.'&prefix='.$phone);
                $data = json_decode($data, true);
                if(!isset($data)){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __('Không thể kết nối đến server, vui lòng liên hệ Admin')]));
                }
                if($data['ResponseCode'] != 0){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __($data['Msg'])]));
                }
                $CMSNT->insert('otp_history', [
                    'transid'           => $trans_id,
                    'id_service_otp'    => $row['id'],
                    'user_id'           => $getUser['id'],
                    'number'            => '0'.$data['Result']['Number'],
                    'id_order_api'      => $data['Result']['Id'],
                    'app'               => $data['Result']['App'],
                    'cost'              => $data['Result']['Cost'] * 1000,
                    'price'             => $price,
                    'code'              => '',
                    'sms'               => '',
                    'create_gettime'    => gettime(),
                    'create_time'       => time(),
                    'update_time'       => time(),
                    'status'            => 1
                ]);
            }

            if($CMSNT->site('server_thuesim') == 'API_2'){

                $data = array(
                    'package_id' => $row['id_api']
                );
                $data = json_encode($data);
                $ch = curl_init($CMSNT->site('domain_thuesim')."api/sms/buy");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data),
                'Authorization: Bearer '.$CMSNT->site('token_thuesim')
                )
                );
                $result = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($result, true);
                if(!$data){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __('Không thể kết nối đến server, vui lòng liên hệ Admin')]));
                }
                if($data['success'] != true){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __($data['error'])]));
                }
                $CMSNT->insert('otp_history', [
                    'transid'           => $trans_id,
                    'id_service_otp'    => $row['id'],
                    'user_id'           => $getUser['id'],
                    'number'            => $data['data']['status'] == 0 ? $data['data']['phone'] : __('Đang chờ lấy số điện thoại'),
                    'id_order_api'      => $data['data']['order_id'],
                    'app'               => $row['name'],
                    'cost'              => $row['price_api'],
                    'price'             => $price,
                    'code'              => '',
                    'sms'               => '',
                    'create_gettime'    => gettime(),
                    'create_time'       => time(),
                    'update_time'       => time(),
                    'status'            => 1
                ]);
            }

            if($CMSNT->site('server_thuesim') == 'API_3'){
                $telco = str_replace('Viettel', 'VIETTEL', $telco);
                $telco = str_replace('Vinaphone', 'VINAPHONE', $telco);
                $telco = str_replace('Mobifone', 'MOBIFONE', $telco);
                $telco = str_replace('Vietnamobile', 'VIETNAMOBILE', $telco);
                $telco = str_replace(',', '|', $telco);
                $phone = str_replace(',', '|', $phone);

                $data = curl_get($CMSNT->site('domain_thuesim').'request/getv2?token='.$CMSNT->site('token_thuesim').'&serviceId='.$row['id_api'].'&network='.$telco.'&prefix='.$phone);
                $data = json_decode($data, true);
                if(!$data){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __('Không thể kết nối đến server, vui lòng liên hệ Admin')]));
                }
                if($data['status_code'] != 200){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
                }
                $CMSNT->insert('otp_history', [
                    'transid'           => $trans_id,
                    'id_service_otp'    => $row['id'],
                    'user_id'           => $getUser['id'],
                    'number'            => $data['data']['phone_number'],
                    'id_order_api'      => $data['data']['request_id'],
                    'app'               => $row['name'],
                    'cost'              => $row['price_api'],
                    'price'             => $price,
                    'code'              => '',
                    'sms'               => '',
                    'create_gettime'    => gettime(),
                    'create_time'       => time(),
                    'update_time'       => time(),
                    'status'            => 1
                ]);
            }

            if($CMSNT->site('server_thuesim') == 'API_4'){
                $telco = str_replace('Viettel', 'viettel', $telco);
                $telco = str_replace('Vinaphone', 'vinaphone', $telco);
                $telco = str_replace('Mobifone', 'mobifone', $telco);
                $telco = str_replace('Vietnamobile', 'vietnamobile', $telco);
                $telco = str_replace(',', '|', $telco);
                $phone = str_replace(',', '|', $phone);
                $abb = "0";
                $phone = str_replace($abb, "", $phone);
                $data = curl_get($CMSNT->site('domain_thuesim').'api?action=number&apikey='.$CMSNT->site('token_thuesim').'&service='.$row['id_api'].'&operator='.$telco.'&prefix='.$phone);
                $data = json_decode($data, true);
                if(!$data){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __('Không thể kết nối đến server, vui lòng liên hệ Admin')]));
                }
                if($data['ResponseCode'] != 0){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __('[ERROR '.check_string($data['ResponseCode']).'] Không thể lấy SIM')]));
                }
                $CMSNT->insert('otp_history', [
                    'transid'           => $trans_id,
                    'id_service_otp'    => $row['id'],
                    'user_id'           => $getUser['id'],
                    'number'            => $data['Result']['number'],
                    'id_order_api'      => $data['Result']['id'],
                    'app'               => $row['name'],
                    'cost'              => $row['price_api'],
                    'price'             => $price,
                    'code'              => '',
                    'sms'               => '',
                    'create_gettime'    => gettime(),
                    'create_time'       => time(),
                    'update_time'       => time(),
                    'status'            => 1
                ]);
            }

            if($CMSNT->site('server_thuesim') == 'API_5'){
                $data = curl_get($CMSNT->site('domain_thuesim').'api/?action=get_number&key='.$CMSNT->site('token_thuesim').'&id='.$row['id_api']);
                $data = json_decode($data, true);
                if(!$data){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __('Không thể kết nối đến server, vui lòng liên hệ Admin')]));
                }
                if(isset($data['message'])){
                    $User->RefundCredits($getUser['id'], $price, "[Error] Hoàn tiền đơn hàng thuê OTP #".$trans_id);
                    die(json_encode(['status' => 'error', 'msg' => __('[ERROR '.check_string($data['message']).'] Không thể lấy SIM')]));
                }
                $CMSNT->insert('otp_history', [
                    'transid'           => $trans_id,
                    'id_service_otp'    => $row['id'],
                    'user_id'           => $getUser['id'],
                    'number'            => '0'.check_string($data['number']),
                    'id_order_api'      => check_string($data['request_id']),
                    'app'               => $row['name'],
                    'cost'              => $row['price_api'],
                    'price'             => $price,
                    'code'              => '',
                    'sms'               => '',
                    'create_gettime'    => gettime(),
                    'create_time'       => time(),
                    'update_time'       => time(),
                    'status'            => 1
                ]);
            }


        } 
    }
    die(json_encode(['status' => 'success', 'msg' => __('Lấy số thành công!')]));
} else {
    die('The Request Not Found');
}
