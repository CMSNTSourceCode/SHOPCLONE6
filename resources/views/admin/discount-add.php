<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thêm điều kiện giảm giá',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

';
$body['footer'] = '
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
    $(".select2").select2()
    $(".select2bs4").select2({
        theme: "bootstrap4"
    });
});
</script>
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['AddDiscount'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->insert("discounts", [
        'product_id'        => check_string($_POST['product_id']),
        'amount'            => check_string($_POST['amount']),
        'discount'          => check_string($_POST['discount']),
        'create_gettime'       => gettime(),
        'update_gettime'        => gettime()
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm điều kiện giảm giá (".getRowRealtime('products', check_string($_POST['product_id']), 'name')." | ".format_cash(check_string($_POST['amount']))." | ".check_string($_POST['discount'])."%)."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('admin/discount-add').'";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm điều kiện giảm giá</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thêm điều kiện giảm giá</li>
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
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-tag mr-1"></i>
                                THÊM ĐIỀU KIỆN GIẢM GIÁ
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
                                    <select class="form-control select2bs4" name="product_id" id="product_id"
                                        onchange="loadHistory()" required>
                                        <option value="">-- Chọn sản phẩm --</option>
                                        <?php foreach($CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 ") as $row):?>
                                        <option value="<?=$row['id'];?>">
                                            <?=$row['name'];?>
                                        </option>
                                        <?php endforeach?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="exampleInputEmail1">Mua tối thiểu bao nhiêu tài khoản</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="amount" id="amount" onkeyup="total()"
                                            placeholder="Nhập số tài khoản tối thiểu khi mua để được giảm giá" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Tài khoản</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="exampleInputEmail1">Chiết khấu giảm giá</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="discount" id="discount" onkeyup="total()"
                                            placeholder="Nhập chiết khấu giảm 10% thì nhập số 10" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-info col-lg-12">
                                Mua từ <b style="color:yellow;" id="show_amount">0</b> tài khoản trở lên được giảm <b style="color:red;" id="show_discount">0</b>%.
                                </div>

                            </div>
                            <div class="card-footer clearfix">
                                <button name="AddDiscount" class="btn btn-primary btn-block btn-icon-left m-b-10"
                                    type="submit"><i class="fas fa-plus mr-1"></i>Thêm Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-clock-rotate-left mr-1"></i>
                                VỪA THÊM GẦN ĐÂY
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
                            <div id="loadHistory"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


<script>
function total(){
    $("#show_discount").html($("#discount").val());
    $("#show_amount").html($("#amount").val());
}
function loadHistory() {
    var id = $('#product_id').val();
    $.get("<?=BASE_URL('ajaxs/admin/loadHistoryDiscount.php?id=');?>" + id, function(data) {
        $("#loadHistory").html(data);
    });
}
</script>
<?php
require_once(__DIR__.'/footer.php');
?>