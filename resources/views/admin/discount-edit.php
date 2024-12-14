<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa điều kiện giảm giá',
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
    $row = $CMSNT->get_row("SELECT * FROM `discounts` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/discount-list'));
    }
} else {
    redirect(base_url('admin/discount-list'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['SaveDiscount'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->update("discounts", [
        'product_id'        => check_string($_POST['product_id']),
        'amount'            => check_string($_POST['amount']),
        'discount'          => check_string($_POST['discount']),
        'update_gettime'    => gettime()
    ], " `id` = '".$row['id']."' ");
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa điều kiện giảm giá (ID ".$row['id'].")."
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
                    <h1 class="m-0">Chỉnh sửa điều kiện giảm giá</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa điều kiện giảm giá</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/discount-list');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-tag mr-1"></i>
                                CHỈNH SỬA ĐIỀU KIỆN GIẢM GIÁ
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
                            <div class="card-body row">
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Sản phẩm được áp dụng</label>
                                    <select class="form-control select2bs4" name="product_id" required>
                                        <option value="">-- Chọn sản phẩm --</option>
                                        <?php foreach($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 ") as $product):?>
                                        <option <?=$row['product_id'] == $product['id'] ? 'selected' : '';?> value="<?=$product['id'];?>">
                                            <?=$product['name'];?>
                                        </option>
                                        <?php endforeach?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="exampleInputEmail1">Mua tối thiểu bao nhiêu tài khoản</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="amount" value="<?=$row['amount'];?>"
                                            placeholder="Nhập số tài khoản tối thiểu khi mua để được giảm giá" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Tài khoản</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="exampleInputEmail1">Chiết khấu giảm giá</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="discount"
                                            placeholder="Nhập chiết khấu giảm 10% thì nhập số 10" value="<?=$row['discount'];?>" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveDiscount" class="btn btn-info btn-block btn-icon-left m-b-10" type="submit"><i
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