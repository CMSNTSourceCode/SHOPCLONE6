<?php
if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa tài liệu',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
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
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `documents` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/document-list'));
    }
} else {
    redirect(base_url('admin/document-list'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['SaveDocument'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $isUpdate = $CMSNT->update("documents", [
        'stt'           => check_string($_POST['stt']),
        'user_id'       => $getUser['id'],
        'category_id'   => check_string($_POST['category_id']),
        'name'          => check_string($_POST['name']),
        'content'       => $_POST['content'],
        'price'         => check_string($_POST['price']),
        'status'        => check_string($_POST['status']),
        'update_date'   => gettime()
    ], " `id` = '".$row['id']."' ");
    if ($isUpdate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa tài liệu (".$row['name']." ID ".$row['id'].")."
        ]);
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){window.history.back().location.reload();}</script>');
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
                    <h1 class="m-0">Thêm tài liệu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thêm tài liệu</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/document-list');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-book mr-1"></i>
                                CHỈNH SỬA TÀI LIỆU
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
                                    <label for="exampleInputEmail1">Sắp xếp</label>
                                    <input type="number" class="form-control" name="stt" value="<?=$row['stt'];?>" placeholder="Nhập số thứ tự sắp xếp" required></input>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề tài liệu</label>
                                    <input type="text" class="form-control" name="name" value="<?=$row['name'];?>"
                                        placeholder="Nhập tiêu đề tài liệu" required></input>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chuyên mục tài liệu</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">Chọn chuyên mục</option>
                                        <?php foreach ($CMSNT->get_list("SELECT * FROM `document_categories` WHERE `status` = 1 ") as $list) {?>
                                        <option value="<?=$list['id'];?>"
                                            <?=$list['id'] == $row['category_id'] ? 'selected' : '';?>>
                                            <?=$list['name'];?></option>
                                        <?php }?>
                                    </select>
                                    <i>Thêm chuyên mục <a href="<?=BASE_URL('admin/category-document-list');?>" target="_blank">tại đây</a></i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chi tiết tài liệu</label>
                                    <textarea class="form-control" name="content"><?=$row['content'];?></textarea>
                                    <i>Nội dung này sẽ hiển thị khi user mua thành công.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá mua tài liệu này</label>
                                    <input type="number" class="form-control" value="<?=$row['price'];?>" name="price"
                                        placeholder="Nhập giá bán tài liệu này" required></input>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <select class="form-control" name="status" required>
                                        <option <?=$row['status'] == 1 ? 'selected' : '';?> value="1">Hiển thị</option>
                                        <option <?=$row['status'] == 0 ? 'selected' : '';?> value="0">Ẩn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveDocument" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Thêm Ngay</button>
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