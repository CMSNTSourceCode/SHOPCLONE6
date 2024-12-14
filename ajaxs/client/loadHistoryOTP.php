<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");

$CMSNT = new DB();

if (empty($_POST['token'])) {
    die(__('Vui lòng đăng nhập'));
}
if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
    die(__('Vui lòng đăng nhập'));
}
?>

<table id="datatable2" class="table data-table table-hover mb-0">
    <thead class="table-color-heading">
        <tr>
            <th width="5%">#</th>
            <th><?=__('Tên ứng dụng');?></th>
            <th><?=__('Số điện thoại');?></th>
            <th><?=__('Code');?></th>
            <th><?=__('Tin nhắn');?></th>
            <th><?=__('Trạng thái');?></th>
            <th><?=__('Phí');?></th>
            <th><?=__('Thời gian');?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `otp_history` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC  ") as $row) {?>
        <tr>
            <td><?=$i++;?></td>
            <td><b><?=$row['app'];?></b></td>
            <td><span id="copySDT<?=$row['id'];?>"><?=$row['number'];?></span> <button
                    onclick="copy()" data-clipboard-target="#copySDT<?=$row['id'];?>"
                    class="copy btn btn-primary btn-sm"><i class="fas fa-copy"></i></button>
            </td>
            <td><span id="copyCODE<?=$row['id'];?>"><?=$row['code'];?></span> <?php if($row['code'] != ''):?><button
                    onclick="copy()" data-clipboard-target="#copyCODE<?=$row['id'];?>"
                    class="copy btn btn-primary btn-sm"><i class="fas fa-copy"></i></button><?php endif?></td>
            <td><?=$row['sms'];?></td>
            <td><?=display_otp_service($row['status']);?></td>
            <td><b style="color: red;"><?=format_cash($row['price']);?>đ</b></td>
            <td><?=$row['create_gettime'];?></td>
        </tr>
        <?php }?>
    </tbody>
</table>



<script>
$(document).ready(function() {
    $('#datatable2').DataTable();
});
</script>