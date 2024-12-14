<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Cấu hình mua xu',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- ckeditor -->
<script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
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

if(checkAddon(11522) != true){
    die('Vui lòng kích hoạt <a href="'.base_url_admin('addons').'">Addon</a> trước khi truy cập.');
}

require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
 
if (isset($_POST['SaveSettings'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    foreach ($_POST as $key => $value) {
        $CMSNT->update("settings", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
} ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cấu hình mua xu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Cấu hình mua xu</li>
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
                                <i class="fa-solid fa-gear mr-1"></i>
                                CẤU HÌNH MUA XU TTC
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
                                    <label>ON/OFF bán xu TTC</label>
                                    <select class="form-control select2bs4" name="status_ban_xu_ttc">
                                        <option <?=$CMSNT->site('status_ban_xu_ttc') == 0 ? 'selected' : '';?> value="0">OFF
                                        </option>
                                        <option <?=$CMSNT->site('status_ban_xu_ttc') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                    </select>
                                    <i>Chọn OFF hệ thống sẽ tạm dừng bán xu TTC.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá bán xu TTC</label>
                                    <input type="text" class="form-control" name="rate_ban_xu_ttc"
                                        value="<?=$CMSNT->site('rate_ban_xu_ttc');?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Xu TTC mua tối thiểu</label>
                                    <input type="text" class="form-control" name="min_ban_xu_ttc"
                                        value="<?=$CMSNT->site('min_ban_xu_ttc');?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Xu TTC mua tối đa</label>
                                    <input type="text" class="form-control" name="max_ban_xu_ttc"
                                        value="<?=$CMSNT->site('max_ban_xu_ttc');?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lưu ý</label>
                                    <textarea id="notice_ban_xu_ttc" name="notice_ban_xu_ttc"><?=$CMSNT->site('notice_ban_xu_ttc');?></textarea>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left btn-block m-b-10"
                                    type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-gear mr-1"></i>
                                CẤU HÌNH MUA XU TDS
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
                                    <label>ON/OFF bán xu TDS</label>
                                    <select class="form-control select2bs4" name="status_ban_xu_tds">
                                        <option <?=$CMSNT->site('status_ban_xu_tds') == 0 ? 'selected' : '';?> value="0">OFF
                                        </option>
                                        <option <?=$CMSNT->site('status_ban_xu_tds') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                    </select>
                                    <i>Chọn OFF hệ thống sẽ tạm dừng bán xu TDS.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá bán xu TDS</label>
                                    <input type="text" class="form-control" name="rate_ban_xu_tds"
                                        value="<?=$CMSNT->site('rate_ban_xu_tds');?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Xu TDS mua tối thiểu</label>
                                    <input type="text" class="form-control" name="min_ban_xu_tds"
                                        value="<?=$CMSNT->site('min_ban_xu_tds');?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Xu TDS mua tối đa</label>
                                    <input type="text" class="form-control" name="max_ban_xu_tds"
                                        value="<?=$CMSNT->site('max_ban_xu_tds');?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lưu ý</label>
                                    <textarea id="notice_ban_xu_tds" name="notice_ban_xu_tds"><?=$CMSNT->site('notice_ban_xu_tds');?></textarea>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left btn-block m-b-10"
                                    type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
CKEDITOR.replace("notice_ban_xu_ttc");
CKEDITOR.replace("notice_ban_xu_tds");
</script>
<?php
require_once(__DIR__.'/footer.php');
?>