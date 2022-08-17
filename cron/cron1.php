<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron1')) {
        if (time() - $CMSNT->site('check_time_cron1') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron1' ");

    if($CMSNT->site('time_delete_clone_die') > 0){
        /** XOÁ TÀI KHOẢN DIE KHI ĐỦ THỜI GIAN */
        $CMSNT->remove("accounts", " `status` = 'DIE' AND ".time()." - `time_live` > ".$CMSNT->site('time_delete_clone_die')." ");
    }
