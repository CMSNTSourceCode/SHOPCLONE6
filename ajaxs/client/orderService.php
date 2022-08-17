<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/sendEmail.php");
require_once(__DIR__."/../../libs/database/users.php");
require_once(__DIR__."/../../libs/apiAutoFB.php");

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
    if($CMSNT->site('status_buff_like_sub') != 1){
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang được bảo trì')]));
    }
    if($_POST['type'] == 'buffsub-sale'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_buffsub_sale($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'buffsub-sale',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    if($_POST['type'] == 'buffsub-speed'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_buffsub_speed($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'buffsub-speed',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    if($_POST['type'] == 'buffsub-slow'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_buffsub_slow($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'buffsub-slow',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    if($_POST['type'] == 'bufflikefanpagesale'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_bufflikefanpagesale($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'bufflikefanpagesale',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    if($_POST['type'] == 'bufflikefanpage'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_bufflikefanpage($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'bufflikefanpage',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    if($_POST['type'] == 'buffsubfanpage'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_buffsubfanpage($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'buffsubfanpage',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    if($_POST['type'] == 'bufflikecommentsharelike'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_bufflikecommentshare($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'bufflikecommentsharelike',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    if($_POST['type'] == 'bufflikecommentshareshare'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_bufflikecommentshareshare($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'bufflikecommentshareshare',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    if($_POST['type'] == 'buffviewstory'){
        if (empty($_POST['profile_user'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập URL hoặc ID cần tăng')]));
        }
        if (empty($_POST['loaiseeding'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn dịch vụ cần mua')]));
        }
        if (empty($_POST['amount'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        $uid = check_string($_POST['profile_user']);            // id cần tăng
        $id_rate_autofb = check_string($_POST['loaiseeding']);  // id dịch vụ
        $amount = check_string($_POST['amount']);               // số lượng cần muna
        $token = check_string($_POST['token']);                 // token tài khoản
    
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if(!$row = $CMSNT->get_row("SELECT * FROM `rate_autofb` WHERE `id` = '$id_rate_autofb' ")){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ không tồn tại trong hệ thống')]));
        }
        if($row['price'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
        }
        $total_payment = $amount * $row['price'];
        if (getRowRealtime("users", $getUser['id'], "money") < $total_payment) {
            die(json_encode(['status' => 'error', 'msg' => __('Số dư không đủ, vui lòng nạp thêm')]));
        }
        $trans_id = random("QWETYUOPASDFGHJKXCVBNM123456789", 6);
        $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, __('Thanh toán đơn hàng mua follow')." #".$trans_id);
        if ($isBuy) {
            $data = order_buffviewstory($uid, $row['loaiseeding'], $amount, "TransID: $trans_id - Username: ".$getUser['username']." - Website: ".$_SERVER['HTTP_HOST']);
            if($data['status'] == 200){
                $isInsert = $CMSNT->insert("order_autofb", [
                    'user_id'           => $getUser['id'],
                    'trans_id'          => $trans_id,
                    'id_rate_autofb'    => $row['id'],
                    'insertId'          => $data['data']['insertId'],
                    'payment'           => $total_payment,
                    'uid'               => $uid,
                    'quantity'          => $amount,
                    'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : '',
                    'server'            => $row['loaiseeding'],
                    'type'              => 'buffviewstory',
                    'create_time'       => time(),
                    'create_gettime'    => gettime(),
                    'update_time'       => time(),
                    'update_gettime'    => gettime()
                ]);
                if($isInsert){
                    die(json_encode(['status' => 'success', 'msg' => __($data['message'])]));
                }
                die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo lịch sử, vui lòng liên hệ admin')]));
            }else{
                // Hoàn tiền người mua
                $User->AddCredits($getUser['id'], $total_payment, __('Hoàn tiền đơn hàng mua follow')." #".$trans_id);
                die(json_encode(['status' => 'error', 'msg' => __($data['message'])]));
            }
        }
    }

    die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập đầy đủ dữ liệu')]));
} else {
    die('The Request Not Found');
}
