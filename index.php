<!-- Dev By CMSNT.CO | FB.COM/CMSNT.CO | ZALO.ME/0947838128 | MMO Solution -->
<?php
define("IN_SITE", true);
require_once(__DIR__.'/libs/db.php');
require_once(__DIR__.'/config.php');
require_once(__DIR__.'/libs/lang.php');
require_once(__DIR__.'/libs/helper.php');
require_once(__DIR__.'/libs/database/users.php');
$CMSNT = new DB();
if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
    require_once(__DIR__.'/resources/views/common/maintenance.php');
    exit();
}
$module = !empty($_GET['module']) ? check_string($_GET['module']) : 'client';
$action = !empty($_GET['action']) ? check_string($_GET['action']) : 'home';
if($action == 'footer' || $action == 'header' || $action == 'sidebar' || $action == 'nav'):
    require_once(__DIR__.'/resources/views/common/404.php');
    exit();
endif;
$path = "resources/views/$module/$action.php";
if (file_exists($path)) {
    require_once(__DIR__.'/'.$path);
    exit();
} else {
    require_once(__DIR__.'/resources/views/common/404.php');
    exit();
}
?>
