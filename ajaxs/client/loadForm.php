<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
 
$CMSNT = new DB();
 
if(isset($_POST['type']) && $_POST['type'] == 'loadService'){
    $option = '<option value="">-- '.__('Chọn máy chủ').' --</option>';
    foreach($CMSNT->get_list(" SELECT * FROM `services` WHERE `category_id` = '".check_string($_POST['category'])."'  AND `price` > 0 AND `status` = 1 ") as $row){
        $option .= '<option value="'.$row['id'].'">'.__($row['name']).' | '.__('giá').' '.format_currency($row['price']).'</option>';
    }
    die($option);
}

if(isset($_GET['type']) && $_GET['type'] == 'loadHotDeal'){
    if(!$row = $CMSNT->get_row(" SELECT * FROM `discounts` WHERE `product_id` = '".check_string($_GET['id'])."'  ")){
        die('');
    }
    $html = '<p>';
    $html .= '  <span>📢 Hot Deal: </span><br>';
    foreach($CMSNT->get_list(" SELECT * FROM `discounts` WHERE `product_id` = '".check_string($_GET['id'])."' ORDER BY `amount` ASC ") as $row){
        $money = getRowRealtime('products', $row['product_id'], 'price') * $row['amount'];
        $money = $money - $money * $row['discount'] / 100;
        $html .= '  <span>🏷 '.__('Mua').' <b style="color:blue;">'.$row['amount'].'</b> '.__('nick').' '.__('giá').' <b style="color:red;">'.format_currency($money).'</b></span> <br>';
    }
    $html .= '</p>';
    die($html);
}

 

 
