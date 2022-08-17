<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');


$CMSNT = new DB();
$data = [];
$i=0;
foreach ($CMSNT->get_list("SELECT * FROM `service_order` ORDER BY id DESC  ") as $row) {
    $data[] = [
        'stt'           => $i++,
        'buyer'       => '<a href="'.base_url('admin/user-edit/'.$row['buyer']).'">'.getUser($row['buyer'], 'username').'</a>',
        'service_id'    => '<b>'.getRowRealtime("services", $row['service_id'], 'name').'</b>',
        'amount'        => '<b style="color:blue;">'.format_cash($row['amount']).'</b>',
        'pay'           => '<b style="color:red;">'.format_currency($row['pay']).'</b>',
        'url'           => '<textarea readonly>'.$row['url'].'</textarea>',
        'create_date'   => gettime(),
        'update_date'   => gettime(),
        'status'        => display_service($row['status']),
        'action'        => '<a class="btn btn-info btn-sm btn-icon-left m-b-10" href="'.base_url('admin/service-order-edit/'.$row['id']).'" type="button"><i class="fas fa-edit mr-1"></i><span class="">Edit</span></a>'
    ];
}
echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
exit();
