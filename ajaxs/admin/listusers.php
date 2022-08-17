<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');

$CMSNT = new DB();
$data = [];
foreach ($CMSNT->get_list("SELECT * FROM `users` ORDER BY id DESC  ") as $row) {
    $data[] = [
        'id' => '<input type="checkbox" data-id="'.$row['id'].'" name="checkbox" class="checkbox" value="'.$row['id'].'"/>',
        'username' => '<ul>
                            <li>Tên đăng nhập: <b>'.$row['username'].'</b> [<b>'.$row['id'].'</b>]'.'</li>
                            <li>Địa chỉ Email: <b style="color:green">'.$row['email'].'</b></li>
                            <li>Số điện thoại: <b style="color:blue">'.$row['phone'].'</b></li>
                        </ul>',
        'money' => '<ul>
                        <li>Số dư khả dụng: <b style="color:blue">'.format_currency($row['money']).'</b></li>
                        <li>Tổng số tiền nạp: <b style="color:red">'.format_currency($row['total_money']).'</b></li>
                        <li>Chiết khấu giảm giá: <b>'.$row['chietkhau'].'%</b></li>
                    </ul>',
        'baomat' => '<ul>
                        <li>IP: <b>'.$row['ip'].'</b></li>
                        <li>Status: <b>'.display_online($row['time_session']).'</b></li>
                        <li>Ngày tham gia: <b>'.$row['create_date'].'</b></li>
                        <li>Hoạt động gần đây: <b>'.$row['update_date'].'</b></li>
                    </ul>',
        'role' => display_mark($row['admin']),
        'ctv' => display_mark($row['ctv']),
        'action' => '<a aria-label=""
        href="'.base_url('admin/user-edit/'.$row['id']).'"
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
