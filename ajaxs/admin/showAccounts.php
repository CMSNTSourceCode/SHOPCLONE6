<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = '';
    foreach ($CMSNT->get_list(" SELECT * FROM `accounts` WHERE `trans_id` = '".check_string($_POST['trans_id'])."' ORDER BY id DESC ") as $taikhoan) {
        $data .= $taikhoan['account'].PHP_EOL;
    }
    die($data);
}
