<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');

if (isset($_POST['type'])) {
    if ($CMSNT->site('status_demo') != 0) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Không được dùng chức năng này vì đây là trang web demo'
        ]);
        die($data);
    }
    if($_POST['type'] == 'resetTopNap'){
        $isReset = $CMSNT->update("users",[
            'total_money'   => 0
        ], " `total_money` > 0 ");
        if ($isReset) {
            $Mobile_Detect = new Mobile_Detect();
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => 'Reset tổng nạp toàn bộ user'
            ]);
            $data = json_encode([
                'status'    => 'success',
                'msg'       => 'Reset tổng nạp thành công!'
            ]);
            die($data);
        }else{
            die(json_encode(['status' => 'error','msg' => 'Reset tổng nạp thất bại' ]));
        }
    }
}
else {
    $data = json_encode([
        'status'    => 'error',
        'msg'       => 'Dữ liệu không hợp lệ'
    ]);
    die($data);
}
