<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
//require_once (__DIR__.'/../../models/is_user.php');





$CMSNT = new DB();
$data = [];
$i=0;
foreach ($CMSNT->get_list(" SELECT * FROM `products` WHERE `status` = 1  ") as $row) {
    $data[] = [
        'name'      => '<b style="font-size: 14px;">'.$row['name'].'</b> <span class="text-muted fw-bold text-muted d-block fs-7">'.$row['content'].'</span>',
        'flag'      => display_flag($row['flag']),
        'soluong'   => format_cash($CMSNT->num_rows("SELECT * FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")),
        'price'     => format_currency($row['price']),
        'action'    => '<button type="button" onclick="modalBuy('.$row['id'].', '.$row['price'].')" class="btn btn-primary btn-sm px-4">Mua</button>'
    ];
}
echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
exit();
