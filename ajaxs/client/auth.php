<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/sendEmail.php");

$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();
use PragmaRX\Google2FAQRCode\Google2FA;


if (isset($_POST['action'])) {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('The system is under maintenance, please come back later!')]));
    }
    if($_POST['action'] == 'ForgotPassword'){
        if ($CMSNT->site('status_demo') != 0) {
            die(json_encode(['status' => 'error', 'msg' => __('This function is not available on the demo site!')]));
        }
        if (empty($_POST['email'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập địa chỉ Email')]));
        }
        if($CMSNT->site('reCAPTCHA_status') == 1){
            if (empty($_POST['recaptcha'])) {
                die(json_encode(['status' => 'error', 'msg' => __('Vui lòng xác minh Captcha')]));
            }
            $recaptcha = check_string($_POST['recaptcha']);
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$CMSNT->site('reCAPTCHA_secret_key')."&response=$recaptcha";
            $verify = file_get_contents($url);
            $captcha_success=json_decode($verify);
            if ($captcha_success->success==false) {
                die(json_encode(['status' => 'error', 'msg' => __('Vui lòng xác minh Captcha')]));
            }
        }
        if (!$getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `email` = '".check_string($_POST['email'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Địa chỉ Email này không tồn tại trong hệ thống')]));
        }
        if(time() - $getUser['time_forgot_password'] < 60){
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng thử lại trong ít phút')]));
        }
        if($CMSNT->site('pass_email_smtp') == ''){
            die(json_encode(['status' => 'error', 'msg' => __('SMTP chưa được cấu hình, vui lòng liên hệ Admin')]));
        }
        $token = md5(random('QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 6).time());
        $body = __('Nếu bạn yêu cầu đặt lại mật khẩu, vui lòng nhấp vào liên kết bên dưới để xác minh.').'<br>';
        $body .= '<a target="_blank" href="'.base_url('?action=reset-password&token='.$token).'">'.base_url('?action=reset-password&token='.$token).'</a><br>';
        $body .= '<p>'.__('Nếu không phải là bạn, vui lòng liên hệ ngay với Quản trị viên của bạn để được hỗ trợ về bảo mật.').'</p>';
        $chu_de = __('Khôi phục lại mật khẩu')." - ".$CMSNT->site('title');
        $content = curl_get2(base_url('libs/mails/notification.php'));
        $content = str_replace('{title}', __('Xác nhận khôi phục mật khẩu'), $content);
        $content = str_replace('{content}', $body, $content);
        $bcc = $CMSNT->site('title');
        sendCSM($getUser['email'], $getUser['username'], $chu_de, $content, $bcc);
   
        $isUpdate = $CMSNT->update('users', [
            'token_forgot_password' => $token,
            'time_forgot_password'  => time()
        ], " `id` = '".$getUser['id']."' ");
        if ($isUpdate) {
            die(json_encode(['status' => 'success', 'msg' => __('Vui lòng kiểm tra Email của bạn để hoàn tất quá trình đặt lại mật khẩu')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('Có lỗi hệ thống, vui lòng liên hệ Developer')]));
    }

    if($_POST['action'] == 'ChangePassword'){
        if ($CMSNT->site('status_demo') != 0) {
            die(json_encode(['status' => 'error', 'msg' => __('This function is not available on the demo site!')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if($CMSNT->site('reCAPTCHA_status') == 1){
            if (empty($_POST['recaptcha'])) {
                die(json_encode(['status' => 'error', 'msg' => __('Vui lòng xác minh Captcha')]));
            }
            $recaptcha = check_string($_POST['recaptcha']);
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$CMSNT->site('reCAPTCHA_secret_key')."&response=$recaptcha";
            $verify = file_get_contents($url);
            $captcha_success=json_decode($verify);
            if ($captcha_success->success==false) {
                die(json_encode(['status' => 'error', 'msg' => __('Vui lòng xác minh Captcha')]));
            }
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Liên kết không tồn tại')]));
        }
        if($getUser['token_forgot_password'] == NULL){
            die(json_encode(['status' => 'error', 'msg' => __('Liên kết không tồn tại')]));
        }
        if(strlen($_POST['newpassword']) < 5){
            die(json_encode(['status' => 'error', 'msg' => __('Mật khẩu mới quá ngắn')]));
        }
        if (empty($_POST['renewpassword'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Xác nhận mật khẩu không chính xác')]));
        }
        if ($_POST['renewpassword'] != $_POST['newpassword']) {
            die(json_encode(['status' => 'error', 'msg' => __('Xác nhận mật khẩu không chính xác')]));
        }
        $isUpdate = $CMSNT->update("users", [
            'token_forgot_password' => NULL,
            'password'  => isset($_POST['newpassword']) ? TypePassword(check_string($_POST['newpassword'])) : null,
            'token'     => md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 12).time())
        ], " `token` = '".check_string($_POST['token'])."' ");
        if ($isUpdate) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => __('Password Recovery')
            ]);
            die(json_encode(['status' => 'success', 'msg' => __('Thay đổi mật khẩu thành công')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('Thay đổi mật khẩu thất bại')]));
    }
}