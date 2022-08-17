<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendCSM($mail_nhan, $ten_nhan, $chu_de, $noi_dung, $bcc)
{
    $CMSNT = new DB();
    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;
    $mail ->Debugoutput = "html";
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $CMSNT->site('email_smtp');
    $mail->Password = $CMSNT->site('pass_email_smtp');
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom($CMSNT->site('email_smtp'), $bcc);
    $mail->addAddress($mail_nhan, $ten_nhan);
    $mail->addReplyTo($CMSNT->site('email_smtp'), $bcc);
    $mail->isHTML(true);
    $mail->Subject = $chu_de;
    $mail->Body    = $noi_dung;
    $mail->CharSet = 'UTF-8';
    $send = $mail->send();
    return $send;
}
 