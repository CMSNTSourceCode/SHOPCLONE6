<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa menu',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- CodeMirror -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/codemirror.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/theme/monokai.css">
<!-- ckeditor -->
<script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
$body['footer'] = '
<!-- bootstrap color picker -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- CodeMirror -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/codemirror.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/css/css.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/xml/xml.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
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
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `menu` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/menu-list'));
    }
} else {
    redirect(base_url('admin/menu-list'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['save'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($CMSNT->get_row("SELECT * FROM `menu` WHERE `name` = '".check_string($_POST['name'])."' AND `id` != ".$row['id']." ")) {
        die('<script type="text/javascript">if(!alert("Tên menu này đã tồn tại trong hệ thống.")){window.history.back().location.reload();}</script>');
    }
    $isCreate = $CMSNT->update("menu", [
        'name'              => check_string($_POST['name']),
        'slug'              => create_slug(check_string($_POST['name'])),
        'href'              => !empty($_POST['href']) ? check_string($_POST['href']) : '',
        'icon'              => $_POST['icon'],
        'position'          => !empty($_POST['position']) ? check_string($_POST['position']) : 3,
        'target'            => !empty($_POST['target']) ? check_string($_POST['target']) : '',
        'content'           => !empty($_POST['content']) ? $_POST['content'] : '',
        'status'            => check_string($_POST['status'])
    ], " `id` = '".$row['id']."' ");
    if ($isCreate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa menu (".$row['name']." ID ".$row['id'].") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Lưu thành công !")){location.href = "";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Lưu menu thất bại, vui lòng thử lại!")){window.history.back().location.reload();}</script>');
    }
}

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh sửa menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa menu</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/menu-list');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bars mr-1"></i>
                                CHỈNH SỬA MENU
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
                                    <label for="exampleInputEmail1">Tên menu</label>
                                    <input type="text" class="form-control" value="<?=$row['name'];?>" placeholder="Nhập tên menu cần tạo"
                                        name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Liên kết</label>
                                    <input type="text" class="form-control" value="<?=$row['href'];?>"
                                        placeholder="Nhập địa chỉ liên kết cần tới khi click vào menu này" name="href"
                                        >
                                        <i>Chỉ áp dụng khi nội dung hiển thị trống</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung hiển thị nếu có</label>
                                    <textarea id="content"
                                        name="content" placeholder="Để trống nếu muốn sử dụng liên kết"><?=$row['content'];?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vị trí hiển thị</label>
                                    <select class="form-control" name="position" required>
                                        <option <?=$row['position'] == 1 ? 'selected' : '';?> value="1">Trong menu SỐ DƯ</option>
                                        <option <?=$row['position'] == 2 ? 'selected' : '';?> value="2">Trong menu NẠP TIỀN</option>
                                        <option <?=$row['position'] == 3 ? 'selected' : '';?> value="3">Trong menu KHÁC</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Icon menu</label>
                                    <input type="text" class="form-control" value='<?=$row['icon'];?>'
                                        placeholder='Ví dụ: <i class="fas fa-home"></i>' name="icon" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tìm thêm icon tại đây</label>
                                    <a target="_blank"
                                        href="https://fontawesome.com/v5.15/icons?d=gallery&p=2">https://fontawesome.com/v5.15/icons?d=gallery&p=2</a>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <select class="form-control" name="status" required>
                                        <option <?=$row['status'] == 1 ? 'selected' : '';?> value="1">Hiển thị</option>
                                        <option <?=$row['status'] == 0 ? 'selected' : '';?> value="0">Ẩn</option>
                                    </select>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="target" value="_blank"
                                        id="customCheckbox2" <?=$row['target'] == '_blank' ? 'checked' : '';?>>
                                    <label for="customCheckbox2" class="custom-control-label">Mở tab mới khi
                                        click</label>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" name="save" class="btn btn-primary"><i
                                        class="fas fa-save mr-1"></i>LƯU NGAY</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
CKEDITOR.replace("content");
</script>
<?php
require_once(__DIR__.'/footer.php');
?>