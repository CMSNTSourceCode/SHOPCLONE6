<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');

$CMSNT = new DB();
$data = [];
$i=0;
foreach ($CMSNT->get_list("SELECT * FROM `invoices` ORDER BY id DESC  ") as $row) {
    $data[] = [
        'stt'   => $i++,
        'id' => '<input type="checkbox" data-id="'.$row['id'].'" name="checkbox" class="checkbox" value="'.$row['id'].'"/>',
        'user_id' => '<a href="'.base_url('admin/user-edit/'.$row['user_id']).'">'.getUser($row['user_id'], 'username').'</a>',
        'trans_id' => '<a href="'.base_url('client/payment/'.$row['trans_id']).'" target="_blank"><i class="fas fa-file-alt"></i> '.$row['trans_id'].'</a>',
        'payment_method' => $row['payment_method'],
        'amount' => format_currency($row['amount']),
        'pay' => format_currency($row['pay']),
        'status' => display_invoice($row['status']),
        'create_date' => $row['create_date'],
        'update_date' => $row['update_date'],
        'action' => '<a aria-label=""
        href="'.base_url('admin/invoice-edit/'.$row['id']).'"
        style="color:white;" class="btn btn-info btn-sm btn-icon-left m-b-10"
        type="button">
        <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
        </a>
        <button style="color:white;" onclick="RemoveRow('.$row['id'].')" class="btn btn-danger btn-sm btn-icon-left m-b-10"
        type="button">
        <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
        </button>
        '
    ];
}

echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
