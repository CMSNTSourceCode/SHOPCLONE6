<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa mã giảm giá',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '

';
$body['footer'] = '

';
require_once(__DIR__.'/../../../models/is_admin.php');
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `coupons` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/coupon-list'));
    }
} else {
    redirect(base_url('admin/coupon-list'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['SaveCoupon'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->update("coupons", [
        'amount'        => check_string($_POST['amount']),
        'min'           => check_string($_POST['min']),
        'max'           => check_string($_POST['max']),
        'discount'      => check_string($_POST['discount']),
        'updatedate'    => gettime()
    ], " `id` = '".$row['id']."' ");
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa mã giảm giá (".$row['code']." ID ".$row['id'].")."
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
                    <h1 class="m-0">Chỉnh sửa mã giảm giá</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa mã giảm giá</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/coupon-list');?>"
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
                                CHỈNH SỬA MÃ GIẢM GIÁ
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
                                    <label for="exampleInputEmail1">Mã giảm giá</label>
                                    <div class="row">
                                        <div class="col-lg-12 mr-1 mb-3">
                                            <input type="text" class="form-control" value="<?=$row['code'];?>" 
                                                placeholder="Nhập mã giảm giá cần tạo" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng</label>
                                    <input type="number" class="form-control" name="amount" value="<?=$row['amount'];?>"
                                        placeholder="Nhập số lượng mã" required>
                                    <i>Số lượng mã cần dùng, VD số lượng 2 thì mã sẽ dùng được 2 lần 2 tài khoản khác
                                        nhau.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Đơn hàng tối thiểu</label>
                                    <input type="number" class="form-control" name="min" value="<?=$row['min'];?>"
                                        placeholder="Nhập giá trị đơn hàng tối thiểu" required>
                                    <i>Giá trị đơn hàng tối thiểu được dùng mã giảm giá này</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Đơn hàng tối đa</label>
                                    <input type="number" class="form-control" name="max" value="<?=$row['max'];?>"
                                        placeholder="Nhập giá trị đơn hàng tối đa" required>
                                    <i>Giá trị đơn hàng tối đa được dùng mã giảm giá này</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giảm</label>
                                    <input type="text" class="form-control" name="discount" value="<?=$row['discount'];?>"
                                        placeholder="Nhập chiết khấu giảm giá VD: 10 (tức giảm 10% khi nhập coupon)"
                                        required>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveCoupon" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
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