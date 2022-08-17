<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa đơn dịch vụ',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '

';
$body['footer'] = '

';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/../../../libs/database/users.php');
$user = new users();
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `service_order` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/service-order'));
    }
} else {
    redirect(base_url('admin/service-order'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['SaveServiceOrder'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($row['status'] == 2) {
        die('<script type="text/javascript">if(!alert("Hoá đơn này đã huỷ và hoàn tiền, không thể điều chỉnh.")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->update("service_order", [
        'status' => isset($_POST['status']) ? check_string($_POST['status']) : 0,
        'update_date' => gettime()
    ], " `id` = '".$row['id']."' ");
    if ($isInsert) {
        if ($_POST['status'] == 2) {
            $user->AddCredits($row['buyer'], $row['pay'], 'Hoàn tiền đơn hàng dịch vụ #'.$row['trans_id']);
        }
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa đơn dịch vụ (#".$row['trans_id'].")."
        ]);
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){window.history.back().location.reload();}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Lưu thất bại!")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh sửa đơn dịch vụ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa đơn dịch vụ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-1"></i>
                                CHỈNH SỬA ĐƠN HÀNG #<?=$row['trans_id'];?>
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
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Seller</label>
                                    <input type="text" class="form-control" value="<?=$row['seller'];?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Buyer</label>
                                    <input type="text" class="form-control" value="<?=$row['buyer'];?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Buyer</label>
                                    <input type="text" class="form-control" value="<?=$row['buyer'];?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Service</label>
                                    <input type="text" class="form-control" value="<?=getRowRealtime("services", $row['service_id'], 'name');?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Url</label>
                                    <input type="text" class="form-control" value="<?=$row['url'];?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" class="form-control" value="<?=format_cash($row['amount']);?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Payment</label>
                                    <input type="text" class="form-control" value="<?=format_currency($row['pay']);?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Createdate</label>
                                    <input type="text" class="form-control" value="<?=$row['create_date'];?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Updatedate</label>
                                    <input type="text" class="form-control" value="<?=$row['update_date'];?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="form-control" name="status" required>
                                        <option <?=$row['status'] == 0 ? 'selected' : '';?> value="0"><?=display_service(0);?></option>
                                        <option <?=$row['status'] == 1 ? 'selected' : '';?> value="1"><?=display_service(1);?></option>
                                        <option <?=$row['status'] == 2 ? 'selected' : '';?> value="2"><?=display_service(2);?></option>
                                    </select>
                                    <i>Hệ thống sẽ hoàn tiền nếu đơn hàng điều chỉnh về <?=display_service(2);?></i>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveServiceOrder" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                <a class="btn btn-danger btn-icon-left m-b-10"
                                    href="<?=base_url('admin/service-order');?>" type="button"><i
                                        class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>