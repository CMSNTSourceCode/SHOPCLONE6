<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thêm sản phẩm',
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
<!-- bs-custom-file-input -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script> 
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['AddProduct'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $url_image = null;
    if (check_img('preview') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 4);
        $uploads_dir = 'assets/storage/images/preview'.$rand.'.png';
        $tmp_name = $_FILES['preview']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $url_image = $uploads_dir;
        }
    }
    $isInsert = $CMSNT->insert("products", [
        'stt'       => isset($_POST['stt']) ? $_POST['stt'] : 0,
        'user_id'   => $getUser['id'],
        'name'      => $_POST['name'],
        'category_id' => check_string($_POST['category_id']),
        'price'     => check_string($_POST['price']),
        'content'   => isset($_POST['content']) ? $_POST['content'] : null,
        'flag'      => isset($_POST['flag']) ? check_string($_POST['flag']) : null,
        'checklive' => isset($_POST['checklive']) ? check_string($_POST['checklive']) : 0,
        'time_delete_account'   => isset($_POST['time_delete_account']) ? check_string($_POST['time_delete_account']) : 0,
        'sold'                  => isset($_POST['sold']) ? check_string($_POST['sold']) : 0,
        'filter_time_checklive' => isset($_POST['filter_time_checklive']) ? check_string($_POST['filter_time_checklive']) : 0,
        'status'    => check_string($_POST['status']),
        'minimum'   => isset($_POST['minimum']) ? $_POST['minimum'] : 1,
        'maximum'   => isset($_POST['maximum']) ? $_POST['maximum'] : 10000,
        'allow_api' => isset($_POST['allow_api']) ? check_string($_POST['allow_api']) : 1,
        'preview'   => $url_image
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm sản phẩm (".$_POST['name'].") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('admin/product-list').'";}</script>');
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
                    <h1 class="m-0">Thêm sản phẩm</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thêm sản phẩm</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/product-list');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-cart-plus mr-1"></i>
                                THÊM SẢN PHẨM MỚI
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Số thự tự hiển thị sản phẩm</label>
                                    <input type="number" class="form-control" name="stt" value="0"
                                        placeholder="Nhập số thứ tự hiển thị sản phẩm">
                                    <i>Số càng thấp, sản phẩm càng lên đầu</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nhập tên sản phẩm"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Loại sản phẩm</label>
                                    <select class="form-control select2bs4" name="category_id" required>
                                        <option value="">Chọn loại sản phẩm</option>
                                        <?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 ") as $list) {?>
                                        <option value="<?=$list['id'];?>"><?=$list['name'];?></option>
                                        <?php }?>
                                    </select>
                                    <i>Thêm chuyên mục <a href="<?=BASE_URL('admin/category-list');?>" target="_blank">tại đây</a></i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" class="form-control" name="price"
                                        placeholder="Nhập giá sản phẩm" required>
                                        <i>Vui lòng nhập giá VND</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chi tiết sản phẩm</label>
                                    <textarea class="form-control" name="content"
                                        placeholder="Nhập chi tiết sản phẩm"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Quốc gia</label>
                                    <input type="text" class="form-control" name="flag"
                                        placeholder="Nếu là Việt Nam thì ghi vn">
                                    <i>Xem ISO CODE Quốc Gia tại đây: <a target="_blank"
                                            href="https://countrycode.org/">https://countrycode.org/</a>, vui lòng không ghi IN HOA</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Ảnh xem trước sản phẩm</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="preview">
                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                    <i>Không bắt buộc</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <select class="form-control" name="status" required>
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="checklive" value="1"
                                            id="customCheckbox2">
                                        <label for="customCheckbox2" class="custom-control-label">Tự động check
                                            live tài khoản facebook</label>
                                    </div>
                                    <small>Chỉ tích vào khi bạn bán tài khoản Facebook cần check live.</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thời gian xoá tài khoản</label>
                                    <input type="number" class="form-control" value="0" name="time_delete_account"
                                        placeholder="Tắt chức năng này vui lòng nhập: 0" required>
                                        <i>Hệ thống sẽ tự động xoá các tài khoản chưa bán sau khi đủ thời gian cần xoá, tính theo giây 1 = 1 giây (dùng cho các tài khoản cần bán trong thời gian ngắn vd: hotmail, proxy v.v).<br>
                                    Để số 0 nếu muốn tắt chức năng này.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng mua tối thiểu</label>
                                    <input type="number" class="form-control" value="1" name="minimum"
                                        placeholder="Nhập số lượng mua tối thiểu" required>
                                        <i>Số lượng mua tối thiểu trong 1 lần mua.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng mua tối đa</label>
                                    <input type="number" class="form-control" value="10000" name="maximum"
                                        placeholder="Nhập số lượng mua tối đa" required>
                                        <i>Số lượng mua tối đa trong 1 lần mua.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thứ tự mua</label>
                                    <select class="form-control" name="filter_time_checklive" required>
                                        <option value="1">Check live gần nhất sẽ ưu tiên bán trước</option>
                                        <option value="0">Acc nào up lên web trước bán trước</option>
                                        <option value="2">Acc nào up lên web sau bán trước</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Cho phép đấu API</label>
                                    <select class="form-control" name="allow_api" required>
                                        <option value="1">ON</option>
                                        <option value="0">OFF</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng đã bán</label>
                                    <input type="number" class="form-control" name="sold" value="0"
                                        placeholder="Nhập số lượng đã bán" <?=checkAddon(211) != true ? 'readonly' : '';?> required>
                                    <i>Số lượng thật sẽ tự cộng dồn vào đây, bạn chỉ có thể tuỳ chỉnh số lượng khi đã mua <a href="<?=base_url_admin('addons');?>">Addon</a></i>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="AddProduct" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Thêm Ngay</button>
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