<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_user.php');


$CMSNT = new DB();
$data = [];
$i=0;
foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE `user_id` = '".$getUser['id']."'  ORDER BY id DESC  ") as $row) {
    $data[] = [
        'stt'           => $i++,
        'sotientruoc'   => format_currency($row['sotientruoc']),
        'sotienthaydoi' => format_currency($row['sotienthaydoi']),
        'sotiensau'     => format_currency($row['sotiensau']),
        'thoigian'      => $row['thoigian'],
        'noidung'       => $row['noidung']
    ];
}
echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
exit();
