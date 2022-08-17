<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_checklivefb')) {
        if (time() - $CMSNT->site('check_time_cron_checklivefb') < 3) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    /* Thời gian check live cách nhau mỗi giây */
    $timeCheck = $CMSNT->site('time_check_live');

    /* Số lượng tài khoản check trên mỗi sản phẩm mỗi phút */
    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron_checklivefb' ");
    $where_is_checklive = NULL;

    foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `checklive` != 1  ") as $product) {
        $where_is_checklive .= " AND `product_id` != '".$product['id']."' ";
    }
    $i = 0;
    foreach ($CMSNT->get_list("SELECT * FROM `accounts` WHERE `buyer` IS NULL AND `status` = 'LIVE' AND ".time()." - `time_live` > $timeCheck $where_is_checklive ORDER BY `time_live` ASC ") as $account) {
        $status = CheckLiveClone(explode("|", $account['account'])[0]);
        $CMSNT->update("accounts", [
            'status'    => $status,
            'time_live' => time()
        ], " `id` = '".$account['id']."' ");
        echo '['.$i++.'] '.$status.' <br>';
    }

    echo 'Success!';
