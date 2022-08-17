<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($row = $CMSNT->get_row("SELECT * FROM `services` WHERE `id` = '".check_string($_POST['id'])."' ")) {
        die($row['content']);
    }
}
