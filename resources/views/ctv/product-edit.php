<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa sản phẩm',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '

';
$body['footer'] = '
<!-- bs-custom-file-input -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script> 
';
require_once(__DIR__.'/../../../models/is_ctv.php');
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `products` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('ctv/product-list'));
    }
} else {
    redirect(base_url('ctv/product-list'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['SaveProduct'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if (check_img('preview') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 4);
        $uploads_dir = 'assets/storage/images/preview'.$rand.'.png';
        $tmp_name = $_FILES['preview']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $CMSNT->update("products", [
                'preview' => $uploads_dir
            ], " `id` = '".$row['id']."' ");
        }
    }
    $isInsert = $CMSNT->update("products", [
        'name' => $_POST['name'],
        'category_id' => check_string($_POST['category_id']),
        'price' => check_string($_POST['price']),
        'content' => isset($_POST['content']) ? $_POST['content'] : null,
        'stt' => isset($_POST['stt']) ? check_string($_POST['stt']) : 0,
        'flag' => isset($_POST['flag']) ? check_string($_POST['flag']) : null,
        'checklive' => isset($_POST['checklive']) ? check_string($_POST['checklive']) : 0,
        'sold' => isset($_POST['sold']) ? check_string($_POST['sold']) : 0,
        'filter_time_checklive' => isset($_POST['filter_time_checklive']) ? check_string($_POST['filter_time_checklive']) : 0,
        'time_delete_account' => isset($_POST['time_delete_account']) ? check_string($_POST['time_delete_account']) : 0,
        'status' => check_string($_POST['status']),
        'minimum'   => isset($_POST['minimum']) ? $_POST['minimum'] : 1,
        'maximum'   => isset($_POST['maximum']) ? $_POST['maximum'] : 10000
    ], " `id` = '".$row['id']."' ");
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa sản phẩm (".$_POST['name']." ID ".$row['id'].")."
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
                    <h1 class="m-0">Chỉnh sửa sản phẩm</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('ctv/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa sản phẩm</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('ctv/product-list');?>"
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
                                CHỈNH SỬA SẢN PHẨM
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
                                    <input type="number" class="form-control" name="stt" value="<?=$row['stt'];?>"
                                        placeholder="Nhập số thứ tự hiển thị sản phẩm">
                                    <i>Số càng thấp, sản phẩm càng lên đầu</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" class="form-control" value="<?=$row['name'];?>" name="name"
                                        placeholder="Nhập tên sản phẩm" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Loại sản phẩm</label>
                                    <select class="form-control select2bs4" name="category_id" required>
                                        <option value="">Chọn loại sản phẩm</option>
                                        <?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `status` = 1 ") as $list) {?>
                                        <option value="<?=$list['id'];?>"
                                            <?=$list['id'] == $row['category_id'] ? 'selected' : '';?>>
                                            <?=$list['name'];?></option>
                                        <?php }?>
                                    </select>
                                    <i>Thêm chuyên mục <a href="<?=BASE_URL('admin/category-list');?>" target="_blank">tại đây</a></i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Quốc gia</label>
                                    <input type="text" class="form-control" name="flag" value="<?=$row['flag'];?>"
                                        placeholder="Nếu là Việt Nam thì ghi vn">
                                    <i>Xem ISO CODE Quốc Gia tại đây: <a target="_blank"
                                            href="https://countrycode.org/">https://countrycode.org/</a></i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <select class="form-control" name="status" required>
                                        <option <?=$row['status'] == 1 ? 'selected' : '';?> value="1">Hiển thị</option>
                                        <option <?=$row['status'] == 0 ? 'selected' : '';?> value="0">Ẩn</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" class="form-control" name="price" value="<?=$row['price'];?>"
                                        placeholder="Nhập giá sản phẩm" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chi tiết sản phẩm</label>
                                    <textarea class="form-control" name="content"
                                        placeholder="Nhập chi tiết sản phẩm"><?=$row['content'];?></textarea>
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
                                    <?=$row['preview'] != null ? '<img src="'.BASE_URL($row["preview"]).'" width="200px">' : '';?>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="checklive" value="1"
                                            id="customCheckbox2" <?=$row['checklive'] == 1 ? 'checked' : '';?>>
                                        <label for="customCheckbox2" class="custom-control-label">Tự động check
                                            live tài khoản facebook</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thời gian xoá tài khoản</label>
                                    <input type="number" class="form-control" name="time_delete_account" value="<?=$row['time_delete_account'];?>"
                                        placeholder="Tắt chức năng này vui lòng nhập: 0" required>
                                        <i>Hệ thống sẽ tự động xoá các tài khoản chưa bán sau khi đủ thời gian cần xoá, tính theo giây 1 = 1 giây (dùng cho các tài khoản cần bán trong thời gian ngắn vd: hotmail, proxy v.v).<br>
                                    Để số 0 nếu muốn tắt chức năng này.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng mua tối thiểu</label>
                                    <input type="number" class="form-control" value="<?=$row['minimum'];?>" name="minimum"
                                        placeholder="Nhập số lượng mua tối thiểu" required>
                                        <i>Số lượng mua tối thiểu trong 1 lần mua.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng mua tối đa</label>
                                    <input type="number" class="form-control" value="<?=$row['maximum'];?>" name="maximum"
                                        placeholder="Nhập số lượng mua tối đa" required>
                                    <i>Số lượng mua tối đa trong 1 lần mua.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thứ tự mua</label>
                                    <select class="form-control" name="filter_time_checklive" required>
                                        <option <?=$row['filter_time_checklive'] == 1 ? 'selected' : '';?> value="1">Check live gần nhất sẽ ưu tiên bán trước</option>
                                        <option <?=$row['filter_time_checklive'] == 0 ? 'selected' : '';?> value="0">Acc nào up lên web trước bán trước</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng đã bán</label>
                                    <input type="number" class="form-control" name="sold" value="<?=$row['sold'];?>"
                                        placeholder="Nhập số lượng đã bán" <?=checkAddon(211) != true ? 'readonly' : '';?> required>
                                    <i>Số lượng thật sẽ tự cộng dồn vào đây, bạn chỉ có thể tuỳ chỉnh số lượng khi đã mua <a href="<?=base_url_admin('addons');?>">Addon</a></i>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveProduct" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
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