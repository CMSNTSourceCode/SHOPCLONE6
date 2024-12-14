<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa hoá đơn',
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
    $row = $CMSNT->get_row("SELECT * FROM `invoices` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/invoices'));
    }
} else {
    redirect(base_url('admin/invoices'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['SaveInvoice'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($row['status'] == 1) {
        die('<script type="text/javascript">if(!alert("Hoá đơn này đã được thanh toán, không thể điều chỉnh.")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->update("invoices", [
        'status' => isset($_POST['status']) ? check_string($_POST['status']) : 0,
        'update_date' => gettime()
    ], " `id` = '".$row['id']."' ");
    if ($isInsert) {
        if ($_POST['status'] == 1) {
            $user->AddCredits($row['user_id'], $row['amount'], '[Admin] '.__('Thanh toán hoá đơn nạp tiền').' #'.$row['trans_id']);
        }
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa hoá đơn (".$row['trans_id'].")."
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
                    <h1 class="m-0">Chỉnh sửa hoá đơn</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa hoá đơn</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                    <div class="mb-3">
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/invoices');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-1"></i>
                                CHỈNH SỬA HOÁ ĐƠN #<?=$row['trans_id'];?>
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
                                    <label for="exampleInputEmail1">Payment Method</label>
                                    <input type="text" class="form-control" value="<?=$row['payment_method'];?>"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" class="form-control"
                                        value="<?=format_currency($row['amount']);?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Pay</label>
                                    <input type="text" class="form-control" value="<?=format_currency($row['pay']);?>"
                                        readonly>
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
                                        <option <?=$row['status'] == 0 ? 'selected' : '';?> value="0">
                                            <?=display_invoice(0);?></option>
                                        <option <?=$row['status'] == 1 ? 'selected' : '';?> value="1">
                                            <?=display_invoice(1);?></option>
                                        <option <?=$row['status'] == 2 ? 'selected' : '';?> value="2">
                                            <?=display_invoice(2);?></option>
                                    </select>
                                    <i>Hệ thống sẽ cộng số dư cho user nếu hoá đơn được điều chỉnh thành <b
                                            style="color: green;">Đã thanh toán</b></i>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveInvoice" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
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