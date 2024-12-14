<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/lang.php');
    require_once(__DIR__.'/../libs/sendEmail.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_sending_email')) {
        if (time() - $CMSNT->site('check_time_cron_sending_email') < 10) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }

    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron_sending_email' ");


    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    ); 

    $checkAddon = checkAddon(11469);
    
    foreach($CMSNT->get_list(" SELECT * FROM `email_campaigns` WHERE `status` = 0 ") as $camp){

        foreach($CMSNT->get_list(" SELECT * FROM `email_sending` WHERE `camp_id` = '".$camp['id']."' AND `status` = 0 ORDER BY id ASC LIMIT 20 ") as $row){

            $content = $camp['content'];
            $title = $camp['subject'];
            $content_email = curl_get2(base_url('libs/mails/notification.php'), false, stream_context_create($arrContextOptions));
            $content_email = str_replace('{title}', $title, $content_email);
            $content_email = str_replace('{content}', $content, $content_email);
            $email = getRowRealtime('users', $row['user_id'], 'email');
            $response = 'Vui lòng kích hoạt Addon này';
            $status = 2;
            if($email == ''){
                $response = 'Không tìm thấy Email người nhận';
                $status = 2;
            }
            if($CMSNT->site('email_smtp') == '' || $CMSNT->site('pass_email_smtp') == ''){
                $response = 'Vui lòng cấu hình SMTP';
                $status = 2;
            }
            if($checkAddon == true){
                $response = sendCSM($email, $camp['cc'], $title, $content_email, $camp['bcc']);
                $status = 1;
            }

            $CMSNT->update('email_sending', [
                'status'            => $status,
                'update_gettime'    => gettime(),
                'response'          => $response
            ], " `id` = '".$row['id']."' ");
        }



        
        if(!$CMSNT->get_row(" SELECT * FROM `email_sending` WHERE `camp_id` = '".$camp['id']."' AND `status` = 0  ")){
            $CMSNT->update('email_campaigns', [
                'status'            => 1,
                'update_gettime'    => gettime()
            ], " `id` = '".$camp['id']."' ");
        }


    }
 


