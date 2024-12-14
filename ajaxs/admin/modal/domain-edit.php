<?php

define("IN_SITE", true);

require_once(__DIR__."/../../../libs/db.php");
require_once(__DIR__."/../../../libs/helper.php");
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__."/../../../libs/database/users.php");

if(!$row = $CMSNT->get_row(" SELECT * FROM `domains` WHERE `id` = '".check_string($_GET['id'])."' ")){
    die('<script type="text/javascript">if(!alert("Thông tin tên miền")){location.reload();}</script>');

}
if(!$user = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '".$row['user_id']."' ")){
    die('<script type="text/javascript">if(!alert("Thông tin khách hàng không tồn tại trong hệ thống!")){location.reload();}</script>');
}

if (isset($_POST['SaveDomain'])){
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){location.href=`'.base_url_admin('withdraw-list').'`;}</script>');
    }
    $isUpdate = $CMSNT->update('domains', [
        'domain'            => check_string($_POST['domain']),
        'admin_note'        => check_string($_POST['admin_note']),
        'status'            => check_string($_POST['status']),
        'update_gettime'    => gettime()
    ], " `id` = '".$row['id']."' ");
    if($isUpdate){
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){location.href=`'.base_url_admin('domain-list').'`;}</script>');
    }
}
?>


<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="modal-header">
    <h5 class="modal-title" id="CharginModalTitle">Chỉnh sửa yêu cầu tạo website ID: <?=$row['id'];?>, Username:
        <?=$user['username'];?></h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div id="modalContent" class="modal-body">
    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
                href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
                aria-selected="true">XỬ LÝ YÊU CẦU</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="custom-content-below-payment-tab" data-toggle="pill"
                href="#custom-content-below-payment" role="tab" aria-controls="custom-content-below-payment"
                aria-selected="false">BIẾN ĐỘNG SỐ DƯ / NHẬT KÝ HOẠT ĐỘNG</a>
        </li>
    </ul>
    <div class="tab-content" id="custom-content-below-tabContent" style="padding-top: 25px">
        <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel"
            aria-labelledby="custom-content-below-home-tab">
            <form method="POST" action="<?=BASE_URL('ajaxs/admin/modal/domain-edit.php?id='.$row['id']);?>"
                accept-charset="UTF-8">
                <div class="form-group">
                    <label>Tên miền:</label>
                    <input type="text" class="form-control" name="domain" value="<?=$row['domain'];?>" required>
                </div>
                <div class="form-group">
                    <label>Ghi chú Admin:</label>
                    <textarea class="form-control" name="admin_note" placeholder="Ghi chú cho Admin, chỉ Admin mới thấy"><?=$row['admin_note'];?></textarea>
                </div>
                <div class="form-group">
                    <label>Trạng thái:</label>
                    <select name="status" class="form-control" style="padding: 6px;">
                        <option <?=$row['status'] == 0 ? 'selected' : '';?> value="0">Đang Xây Dựng</option>
                        <option <?=$row['status'] == 1 ? 'selected' : '';?> value="1">Hoạt Động</option>
                        <option <?=$row['status'] == 2 ? 'selected' : '';?> value="2">Huỷ</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="SaveDomain" class="btn btn-primary btn-block">LƯU THAY ĐỔI</button>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-block">HUỶ
                        THAY ĐỔI</button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="custom-content-below-payment" role="tabpanel"
            aria-labelledby="custom-content-below-payment-tab">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                50 BIẾN ĐỘNG SỐ DƯ GẦN ĐÂY
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table id="bdsd" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Số tiền trước</th>
                                            <th>Số tiền thay đổi</th>
                                            <th>Số tiền hiện tại</th>
                                            <th>Thời gian</th>
                                            <th>Nội dung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE `user_id` = '".$user['id']."' ORDER BY id DESC LIMIT 50 ") as $row) {?>
                                        <tr>
                                            <td class="text-center"><?=$i++;?></td>
                                            <td class="text-center"><b
                                                    style="color: green;"><?=format_currency($row['sotientruoc']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: blue;"><?=format_currency($row['sotiensau']);?></b>
                                            </td>
                                            <td class="text-center"><i><?=$row['thoigian'];?></i></td>
                                            <td><i><?=$row['noidung'];?></i></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                50 NHẬT KÝ HOẠT ĐỘNG GẦN ĐÂY
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table id="logs" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="40%">Action</th>
                                            <th>Time</th>
                                            <th>Ip</th>
                                            <th width="25%">Device</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE `user_id` = '".$user['id']."' ORDER BY id DESC LIMIT 50 ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$row['action'];?></td>
                                            <td><?=$row['createdate'];?></td>
                                            <td><?=$row['ip'];?></td>
                                            <td><?=$row['device'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('#bdsd').DataTable();
});
</script>
<script>
$(function() {
    $('#logs').DataTable();
});
</script>