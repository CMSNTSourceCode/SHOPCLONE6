<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
 
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();


if(isset($_GET['uid'])) {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    $uid = check_string($_GET['uid']);
    if(explode("|", $uid)){
        $uid = explode("|", $uid)[0];
    }
    if(CheckLiveClone($uid) == 'DIE'){
        die('DIE');
    }
    else{
        die('LIVE');
    }
}
