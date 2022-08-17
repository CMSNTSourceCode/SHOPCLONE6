<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');


// lấy log dòng tiền theo user_id
if (isset($_GET['id'])) {
    $CMSNT = new DB();
    $data = [];
    $i=0;
    foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE `user_id` = '".check_string($_GET['id'])."'  ORDER BY id DESC  ") as $row) {
        $data[] = [
            'stt' => $i++,
            'user_id' => '<a href="'.base_url('admin/user-edit/'.$row['user_id']).'">'.getUser($row['user_id'], 'username').'</a>',
            'sotientruoc'   => format_currency($row['sotientruoc']),
            'sotienthaydoi' => format_currency($row['sotienthaydoi']),
            'sotiensau'     => format_currency($row['sotiensau']),
            'thoigian' => $row['thoigian'],
            'noidung' => $row['noidung']
        ];
    }
    echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
    exit();
}
// lấy log dòng tiền toàn bộ user
else {
    $CMSNT = new DB();
    $data = [];
    $i=0;
    foreach ($CMSNT->get_list("SELECT * FROM `dongtien` ORDER BY id DESC  ") as $row) {
        $data[] = [
            'stt'           => $i++,
            'user_id' => '<a href="'.base_url('admin/user-edit/'.$row['user_id']).'">'.getUser($row['user_id'], 'username').'</a>',
            'sotientruoc'   => format_currency($row['sotientruoc']),
            'sotienthaydoi' => format_currency($row['sotienthaydoi']),
            'sotiensau'     => format_currency($row['sotiensau']),
            'thoigian'      => $row['thoigian'],
            'noidung'       => $row['noidung']
        ];
    }
    echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
    exit();
}
