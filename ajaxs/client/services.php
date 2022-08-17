<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_user.php');


$CMSNT = new DB();
$data = [];
$i=0;
foreach ($CMSNT->get_list("SELECT * FROM `service_order` WHERE `buyer` = '".$getUser['id']."'  ORDER BY id DESC  ") as $row) {
    $data[] = [
        'stt'           => $i++,
        'service_id'    => '<b>'.getRowRealtime("services", $row['service_id'], 'name').'</b>',
        'amount'        => '<b style="color:blue;">'.format_cash($row['amount']).'</b>',
        'pay'           => '<b style="color:red;">'.format_currency($row['pay']).'</b>',
        'url'           => '<textarea readonly>'.$row['url'].'</textarea>',
        'create_date'   => gettime(),
        'update_date'   => gettime(),
        'status'        => display_service($row['status'])
    ];
}
echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
exit();
