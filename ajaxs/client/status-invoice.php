<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");

$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    die(display_invoice($CMSNT->get_row("SELECT * FROM `invoices` WHERE `trans_id` = '".check_string($_GET['trans_id'])."' ")['status']));
}
