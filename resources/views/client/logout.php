<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
//require_once (__DIR__.'/../../../models/is_user.php');
$CMSNT = new DB();

setcookie('token', null, -1, '/');
//setcookie("token", "", time() - $CMSNT->site('session_login'));
session_destroy();
redirect(base_url('client/'));
?>

