<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendCSM($mail_nhan, $ten_nhan, $chu_de, $noi_dung, $bcc = '', $path = ''){
    $CMSNT = new DB();
    if($CMSNT->site('pass_email_smtp') != ''){
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail ->Debugoutput = "html";
        $mail->isSMTP();
        $mail->Host = $CMSNT->site('host_smtp');
        $mail->SMTPAuth = true;
        $mail->Username = $CMSNT->site('email_smtp');
        $mail->Password = $CMSNT->site('pass_email_smtp');
        $mail->SMTPSecure = $CMSNT->site('encryption_smtp');
        $mail->Port = $CMSNT->site('port_smtp');
        $mail->setFrom($CMSNT->site('email_smtp'), $bcc);
        $mail->addAddress($mail_nhan, $ten_nhan);
        $mail->addAttachment($path);
        $mail->addReplyTo($CMSNT->site('email_smtp'), $bcc);
        $mail->isHTML(true);
        $mail->Subject = $chu_de;
        $mail->Body    = $noi_dung;
        $mail->CharSet = 'UTF-8';
        $send = $mail->send();
        return $send;
    }
    return 'Chưa cấu hình SMTP';
}
  