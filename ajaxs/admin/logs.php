<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');


// lấy nhật ký hoạt động theo user_id

if (isset($_GET['id'])) {
    $CMSNT = new DB();
    $data = [];
    $i=0;
    foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE `user_id` = '".check_string($_GET['id'])."'  ORDER BY id DESC  ") as $row) {
        $data[] = [
            'stt' => $i++,
            'user_id' => '<a href="'.base_url('admin/user-edit/'.$row['user_id']).'">'.getUser($row['user_id'], 'username').'</a>',
            'action' => $row['action'],
            'createdate' => $row['createdate'],
            'ip' => $row['ip'],
            'device' => $row['device']
        ];
    }
    echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
    exit();
}



$CMSNT = new DB();
$data = [];
$i=0;
foreach ($CMSNT->get_list("SELECT * FROM `logs` ORDER BY id DESC  ") as $row) {
    $data[] = [
        'stt' => $i++,
        'user_id' => '<a href="'.base_url('admin/user-edit/'.$row['user_id']).'">'.getUser($row['user_id'], 'username').'</a>',
        'action' => $row['action'],
        'createdate' => $row['createdate'],
        'ip' => $row['ip'],
        'device' => $row['device']
    ];
}
echo json_encode(['data' => $data], JSON_PRETTY_PRINT);
exit();
