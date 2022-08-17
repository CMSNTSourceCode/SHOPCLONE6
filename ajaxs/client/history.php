<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_user.php');





$CMSNT = new DB();
$data = [];
$i=0;
foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE `user_id` = '".$getUser['id']."'  ORDER BY id DESC  ") as $row) {
    $data[] = [
        'stt' => $i++,
        'action' => $row['action'],
        'createdate' => $row['createdate'],
        'ip' => $row['ip'],
        'device' => $row['device']
    ];
}
echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
exit();
