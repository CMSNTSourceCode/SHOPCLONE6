<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/sendEmail.php");
require_once(__DIR__."/../../libs/database/users.php");
require_once(__DIR__."/../../libs/5gsmm.php");

$User = new users();
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Hệ thống đang bảo trì')
        ]));
    }
    if ($CMSNT->site('status_buff_like_sub') != 1) {
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Chức năng này đang bảo trì')
        ]));
    }
    if(empty($_POST['token'])){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Vui lòng đăng nhập để sử dụng chức năng này')
        ]));
    }
    if(empty($_POST['service'])){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Vui lòng chọn máy chủ cần mua')
        ]));
    }
    if(empty($_POST['url'])){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Vui lòng điền URL hoặc ID cần tăng')
        ]));
    }
    if(empty($_POST['amount'])){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Vui nhập số lượng cần mua')
        ]));
    }
    if(!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Thông tin đăng nhập không chính xác')
        ]));
    }
    if (time() > $getUser['time_request']) {
        if (time() - $getUser['time_request'] < $config['max_time_load']) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
        }
    }
    if(!$row = $CMSNT->get_row("SELECT * FROM `services` WHERE `id` = '".check_string($_POST['service'])."' ")){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Máy chủ không tồn tại trong hệ thống')
        ]));
    }
    if($row['status'] != 1){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Máy chủ này đang bảo trì')
        ]));
    }
    if($row['price'] <= 0){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Máy chủ này đang bảo trì')
        ]));
    }
    if(getRowRealtime('category_service', $row['category_id'], 'display') != 1){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Dịch vụ này đang bảo trì')
        ]));
    }
    $total_amount   = (int)check_string($_POST['amount']); // Tổng số lượng cần tăng
    $url            = check_string($_POST['url']);
    $comment        = '';
    if($row['type'] == 'Mentions'){

        
        if(!empty($_POST['comment_username'])){
            $comment_username   = check_string($_POST['comment_username']);
        }
        if(!empty($_POST['mentionUsernames'])){
            $comment_username   = check_string($_POST['mentionUsernames']);
        }
    }
    if($row['type'] == 'Package'){
        $total_amount   = 1; // Tổng số lượng cần tăng
    }
    if($row['type'] == 'Custom Comments'){
        if(!empty($_POST['comment'])){
            $total_amount = substr_count($_POST['comment'], PHP_EOL) + 1;
            $comment = check_string($_POST['comment']);
            $total_amount = (int)$total_amount;
            if($row['min'] > $total_amount){
                die(json_encode([
                    'status' => 'error',
                    'msg'   => __('Số lượng mua tối thiểu là').' '.format_cash($row['min'])
                ]));
            }
            if($row['max'] < $total_amount){
                die(json_encode([
                    'status' => 'error',
                    'msg'   => __('Số lượng mua tối đa là').' '.format_cash($row['max'])
                ]));
            }
        }
    }else{
        if($row['min'] > $total_amount){
            die(json_encode([
                'status' => 'error',
                'msg'   => __('Số lượng mua tối thiểu là').' '.format_cash($row['min'])
            ]));
        }
        if($row['max'] < $total_amount){
            die(json_encode([
                'status' => 'error',
                'msg'   => __('Số lượng mua tối đa là').' '.format_cash($row['max'])
            ]));
        }
    }
    // TÍNH TOÁN SỐ LƯỢNG * GIÁ
    $total_payment = $total_amount * $row['price'];
    $total_payment = $total_payment - $total_payment * $getUser['chietkhau'] / 100;
    if(getRowRealtime('users', $getUser['id'], 'money') < $total_payment){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Số dư không đủ, vui lòng nạp thêm tiền để tiếp tục sử dụng')
        ]));
    }
    $trans_id = random('QWERTYUPASDFGHKZXCVBN0123456798', 6);
    $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, 'Thanh toán đơn hàng mua dịch vụ #'.$trans_id.' ('.$row['name'].' số lượng '.$total_amount.')');
    if($isBuy){
        if (getRowRealtime("users", $getUser['id'], "money") < 0) {
            $User->Banned($getUser['id'], 'Gian lận khi mua dịch vụ');
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã bị khoá tài khoản vì gian lận')]));
        }
    }
    if($row['source_api'] == '5gsmm.com'){

        $api_5gsmm = new Api($CMSNT->site('token_5gsmm'));

        if($row['type'] == 'Default'){
            $api_5gsmm = $api_5gsmm->order(array('service' => $row['id_api'], 'link' => $url, 'quantity' => $total_amount)); # Default
        }
        if($row['type'] == 'Custom Comments'){
            $api_5gsmm = $api_5gsmm->order(array('service' => $row['id_api'], 'link' => $url, 'comments' => $comment)); # Custom Comments
        }
        if($row['type'] == 'Mentions' || $row['type'] == 'Comment Likes'){
            $api_5gsmm = $api_5gsmm->order(array('service' => $row['id_api'], 'link' => $url, 'quantity' => $total_amount, 'usernames' => $comment_username)); # Mentions, Comment Likes
        }
        if($row['type'] == 'Package'){
            $api_5gsmm = $api_5gsmm->order(array('service' => $row['id_api'], 'link' => $url)); # Package
        }

        if(isset($api_5gsmm['error'])){
            $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$total_amount.')');
            die(json_encode(['status' => 'error', 'msg' => __($api_5gsmm['error'])]));
        }
        // MUA THÀNH CÔNG
        $id_api = $api_5gsmm['order'];
        $isCreateOrder = $CMSNT->insert('order_service', [
            'server'            => $row['source_api'],
            'id_api'            => isset($id_api) ? $id_api : NULL,
            'buyer'             => $getUser['id'],
            'service_id'        => $row['id'],
            'amount'            => $total_amount,
            'remains'           => $total_amount,
            'price'             => $total_payment,
            'url'               => check_string($_POST['url']),
            'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : NULL,
            'trans_id'          => $trans_id,
            'comment'           => $comment,
            'create_time'       => time(),
            'create_gettime'    => gettime(),
            'update_time'       => time(),
            'update_gettime'    => gettime(),
            'status'            => 'Pending'
        ]);
        if($isCreateOrder){
            die(json_encode([
                'status' => 'success',
                'msg'   => __('Thanh toán thành công !')
            ]));
        }

    }





}