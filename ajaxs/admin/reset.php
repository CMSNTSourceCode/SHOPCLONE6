<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');
require_once(__DIR__."/../../libs/sendEmail.php");

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
            if($CMSNT->site('email') != ''){
                $chu_de = 'Cảnh báo bảo mật website '.$CMSNT->site('title');
                $noi_dung = '
    Hệ thống phát hiện <b>'.$getUser['username'].'</b> IP <b style="color:red;">'.myip().'</b> vừa thực hiện reset tổng nạp tất cả tài khoản trên hệ thống.<br>
    Nếu không phải bạn vui lòng liên hệ <a target="_blank" href="https://www.cmsnt.co/">CMSNT.CO</a> để hỗ trợ kiểm tra an toàn cho quý khách.<br>
    <br>
    <ul>
        <li>Thời gian: '.gettime().'</li>
        <li>IP: '.myip().'</li>
        <li>Thiết bị: '.$Mobile_Detect->getUserAgent().'</li>
    </ul>';
                $bcc = $CMSNT->site('title');
                sendCSM($CMSNT->site('email'), $getUser['username'], $chu_de, $noi_dung, $bcc);
            }
            $data = json_encode([
                'status'    => 'success',
                'msg'       => 'Reset tổng nạp thành công!'
            ]);
            die($data);
        }else{
            die(json_encode(['status' => 'error','msg' => 'Reset tổng nạp thất bại' ]));
        }
    }

    if($_POST['type'] == 'logoutALL'){
        foreach($CMSNT->get_list(" SELECT * FROM `users` WHERE `admin` = 0 ") as $row){
            $CMSNT->update('users', [
                'token'     => md5(random('QWERTYUIOPASDFGHJKLZXCVBNM', 6).time())
            ], " `id` = '".$row['id']."' ");
        }
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Đăng xuất toàn bộ thành viên trên hệ thống'
        ]);
        if($CMSNT->site('email') != ''){
            $chu_de = 'Cảnh báo bảo mật website '.$CMSNT->site('title');
            $noi_dung = '
Hệ thống phát hiện <b>'.$getUser['username'].'</b> IP <b style="color:red;">'.myip().'</b> vừa thực hiện đăng xuất tất cả tài khoản trên hệ thống.<br>
Nếu không phải bạn vui lòng liên hệ <a target="_blank" href="https://www.cmsnt.co/">CMSNT.CO</a> để hỗ trợ kiểm tra an toàn cho quý khách.<br>
<br>
<ul>
    <li>Thời gian: '.gettime().'</li>
    <li>IP: '.myip().'</li>
    <li>Thiết bị: '.$Mobile_Detect->getUserAgent().'</li>
</ul>';
            $bcc = $CMSNT->site('title');
            sendCSM($CMSNT->site('email'), $getUser['username'], $chu_de, $noi_dung, $bcc);
        }
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Thoát tất cả tài khoản thành công!'
        ]);
        die($data);
    }



}
else {
    $data = json_encode([
        'status'    => 'error',
        'msg'       => 'Dữ liệu không hợp lệ'
    ]);
    die($data);
}
