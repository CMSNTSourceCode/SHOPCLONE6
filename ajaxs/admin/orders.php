<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');


$CMSNT = new DB();
$data = [];
$i = 0;
foreach ($CMSNT->get_list("SELECT * FROM `orders` ORDER BY id DESC  ") as $row) {
    $trans_id = $row['trans_id'];
    $data[] = [
        'stt'           => $i++,
        'buyer'         => '<a href="'.base_url('admin/user-edit/'.$row['buyer']).'">'.getUser($row['buyer'], 'username').'</a>',
        'seller'        => '<a href="'.base_url('admin/user-edit/'.$row['seller']).'">'.getUser($row['seller'], 'username').'</a>',
        'trans_id'      => $row['trans_id'],
        'product_id'    => '<b>'.getRowRealtime("products", $row['product_id'], 'name').'</b>',
        'amount'        => '<b style="color:blue;">'.format_cash($row['amount']).'</b>',
        'pay'           => '<b style="color:red;">'.format_currency($row['pay']).'</b>',
        'create_date'   => $row['create_date'],
        'action'        => '<button type="button" onclick="showAccounts(`'.$trans_id.'`)" class="btn btn-primary btn-sm showAccounts">Xem Thêm</button>'
    ];
}
echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
exit();
