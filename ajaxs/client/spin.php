<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__."/../../libs/database/users.php");

$User = new users();
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status_spin') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang được bảo trì')]));
    }
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
        die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
    }
    if (time() - $getUser['time_request'] < $config['max_time_load']) {
        die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
    }
    if ($getUser['spin'] < 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Số lượt quay hiện tại của bạn đã hết')]));
    }
    $CMSNT->update("users", [
        'time_request' => time()
    ], " `id` = '".$getUser['id']."' ");
    $label = [];
    $tile = [];
    $price = [];
    foreach ($CMSNT->get_list("SELECT * FROM `spin_option` WHERE `display` = 1 ") as $row) {
        $label[] = __('Chúc mừng bạn đã quay được phần thường').' ('.$row['name'].')';
        $tile[] = $row['rate'];
        $price[] = $row['price'];
    }
    $out = getRandomWeightedElement($tile);
    $isTru = $CMSNT->tru("users", "spin", 1, " `id` = '".$getUser['id']."' ");
    if ($isTru) {
        $isCong = $User->AddCredits($getUser['id'], $price[$out], $label[$out]);
        if ($isCong) {
            $CMSNT->insert("spin_history", [
                'name'          => $label[$out],
                'user_id'       => $getUser['id'],
                'create_date'   => gettime(),
                'create_time'   => time()
            ]);
        }
    }
    //echo json_encode($data);
    die(json_encode(['location' => $out + 1, 'status' => 'success', 'msg' => $label[$out]]));
}
