<?php

use Detection\MobileDetect;

 if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
 
require_once(__DIR__.'/../../../models/is_admin.php');
 
if (isset($_GET['id'])){
    $CMSNT = new DB();
    $id = check_string($_GET['id']);
    $user = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '$id' ");
    if (!$user) {
        redirect(base_url_admin());
    }
    $Mobile_Detect = new MobileDetect();
    $CMSNT->insert("logs", [
        'user_id'       => $getUser['id'],
        'ip'            => myip(),
        'device'        => $Mobile_Detect->getUserAgent(),
        'createdate'    => gettime(),
        'action'        => 'Login user '.$user['username']
    ]);
    setcookie("token", $user['token'], time() + $CMSNT->site('session_login'), "/");
    $_SESSION['login'] = $user['token'];
    redirect(base_url());
}
redirect(base_url_admin());
