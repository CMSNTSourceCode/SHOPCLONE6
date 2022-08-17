<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__.'/../../config.php');
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/database/users.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status_demo') != 0) {
        die(json_encode(['status' => 'error', 'msg' => 'Bạn không được dùng chức năng này vì đây là trang web demo']));
    }
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if ($CMSNT->site('status_ref') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng nạp thẻ đang được tắt')]));
    }
    if (empty($_POST['token'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (time() - $getUser['time_request'] < $config['max_time_load']) {
        die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
    }
    if (empty($_POST['bank'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn ngân hàng cần rút')]));
    }
    if (empty($_POST['stk'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số tài khoản cần rút')]));
    }
    if (empty($_POST['name'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập tên chủ tài khoản')]));
    }
    if (empty($_POST['amount'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số tiền cần rút')]));
    }
    if($_POST['amount'] < $CMSNT->site('minrut_ref')){
        die(json_encode(['status' => 'error', 'msg' => __('Số tiền rút tối thiểu phải là').' '.format_currency($CMSNT->site('minrut_ref'))]));
    }
    if($getUser['ref_money'] < $_POST['amount']){
        die(json_encode(['status' => 'error', 'msg' => __('Số dư hoa hồng khả dụng của bạn không đủ')]));
    }
    $amount = check_string($_POST['amount']);
    $trans_id = random('123456789QWERTYUIOPASDFGHJKLZXCVBNM', 6);
    $isTru = $CMSNT->tru('users', 'ref_money', $amount, " `id` = '".$getUser['id']."' ");
    if($isTru){
        $CMSNT->insert('log_ref', [
            'user_id'       => $getUser['id'],
            'reason'        => 'Rút số dư hoa hồng #'.$trans_id,
            'sotientruoc'   => $getUser['ref_money'],
            'sotienthaydoi' => $amount,
            'sotienhientai' => $amount - $amount,
            'create_gettime'    => gettime()
        ]);
        if(getRowRealtime('users', $getUser['id'], 'ref_money') < 0){
            $User = new users();
            $User->Banned($getUser['id'], 'Gian lận khi rút số dư hoa hồng');
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã bị khoá tài khoản vì gian lận')]));
        }
        $isInsert = $CMSNT->insert('withdraw_ref', [
            'trans_id'  => $trans_id,
            'user_id'   => $getUser['id'],
            'bank'      => check_string($_POST['bank']),
            'stk'       => check_string($_POST['stk']),
            'name'      => check_string($_POST['name']),
            'amount'    => check_string($_POST['amount']),
            'status'    => 0,
            'create_gettime'    => gettime(),
            'update_gettime'    => gettime(),
            'reason'    => NULL
        ]);
        if($isInsert){
            die(json_encode(['status' => 'success', 'msg' => __('Tạo yêu cầu rút tiền thành công, vui lòng đợi ADMIN xử lý')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('ERROR 1 - Phát hiện lỗi khi rút tiền, vui lòng liên hệ ADMIN')]));
    }else{
        die(json_encode(['status' => 'error', 'msg' => __('ERROR 2 - Phát hiện lỗi khi rút tiền, vui lòng liên hệ ADMIN')]));
    }
}
