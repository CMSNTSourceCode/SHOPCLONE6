<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/nowpayments.php');
    require_once(__DIR__.'/../libs/database/users.php');
 
    $CMSNT = new DB();

    if($CMSNT->site('pin_cron') != ''){
        if(empty($_GET['pin'])){
            die('Vui lòng nhập mã PIN');
        }
        if($_GET['pin'] != $CMSNT->site('pin_cron')){
            die('Mã PIN không chính xác');
        }
    }

    

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_toyyibpay')) {
        if (time() - $CMSNT->site('check_time_cron_toyyibpay') < 10) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", ['value' => time()], " `name` = 'check_time_cron_toyyibpay' ");
    /* END CHỐNG SPAM */
    if ($CMSNT->site('status_toyyibpay') != 1) {
        die('Chức năng đang bảo trì.');
    }
 
 