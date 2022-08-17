<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Danh sách file backup',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '

<style>
body{margin-top:20px;}
.file-manager-actions {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
.file-manager-actions > * {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
.file-manager-container {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
.file-item {
    position: relative;
    z-index: 1;
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    border: 1px solid #eee;
    cursor: pointer;
}
.file-item:hover,
.file-item.focused {
    border-color: rgba(0, 0, 0, 0.05);
}
.file-item.focused {
    z-index: 2;
}
.file-item * {
    -ms-flex-negative: 0;
    flex-shrink: 0;
    text-decoration:none;
}
.dark-style .file-item:hover,
.dark-style .file-item.focused {
    border-color: rgba(255, 255, 255, 0.2);
}
.file-item-checkbox {
    margin: 0 !important;
}
.file-item-select-bg {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: -1;
    opacity: 0;
}
.file-item-img {
    background-color: transparent;
    background-position: center center;
    background-size: cover;
}
.file-item-name {
    display: block;
    overflow: hidden;
}
.file-manager-col-view .file-item {
    margin: 0 0.25rem 0.25rem 0;
    padding: 1.25rem 0 1rem 0;
    width: 9rem;
    text-align: center;
}
[dir="rtl"] .file-manager-col-view .file-item {
    margin-right: 0;
    margin-left: 0.25rem;
}
.file-manager-col-view .file-item-img,
.file-manager-col-view .file-item-icon {
    display: block;
    margin: 0 auto 0.75rem auto;
    width: 4rem;
    height: 4rem;
    font-size: 2.5rem;
    line-height: 4rem;
}
.file-manager-col-view .file-item-level-up {
    font-size: 1.5rem;
}
.file-manager-col-view .file-item-checkbox,
.file-manager-col-view .file-item-actions {
    position: absolute;
    top: 6px;
}
.file-manager-col-view .file-item-checkbox {
    left: 6px;
}
[dir="rtl"] .file-manager-col-view .file-item-checkbox {
    right: 6px;
    left: auto;
}
.file-manager-col-view .file-item-actions {
    right: 6px;
}
[dir="rtl"] .file-manager-col-view .file-item-actions {
    right: auto;
    left: 6px;
}
.file-manager-col-view .file-item-name {
    width: 100%;
}
.file-manager-col-view .file-manager-row-header,
.file-manager-col-view .file-item-changed {
    display: none;
}
.file-manager-row-view .file-manager-row-header,
.file-manager-row-view .file-item {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    margin: 0 0 0.125rem 0;
    padding: 0.25rem 3rem 0.25rem 2.25em;
    width: 100%;
}
[dir="rtl"] .file-manager-row-view .file-manager-row-header,
[dir="rtl"] .file-manager-row-view .file-item {
    padding-right: 2.25em;
    padding-left: 3rem;
}
.file-manager-row-view .file-item-img,
.file-manager-row-view .file-item-icon {
    display: block;
    margin: 0 1rem;
    width: 2rem;
    height: 2rem;
    text-align: center;
    font-size: 1.25rem;
    line-height: 2rem;
}
.file-manager-row-view .file-item-level-up {
    font-size: 1rem;
}
.file-manager-row-view .file-item-checkbox,
.file-manager-row-view .file-item-actions {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
}
.file-manager-row-view .file-item-checkbox {
    left: 10px;
}
[dir="rtl"] .file-manager-row-view .file-item-checkbox {
    right: 10px;
    left: auto;
}
.file-manager-row-view .file-item-actions {
    right: 10px;
}
[dir="rtl"] .file-manager-row-view .file-item-actions {
    right: auto;
    left: 10px;
}
.file-manager-row-view .file-item-changed {
    display: none;
    margin-left: auto;
    width: 10rem;
}
[dir="rtl"] .file-manager-row-view .file-item-changed {
    margin-right: auto;
    margin-left: 0;
}
.file-manager-row-view .file-item-name {
    width: calc(100% - 4rem);
}
.file-manager-row-view .file-manager-row-header {
    border-bottom: 2px solid rgba(0, 0, 0, 0.05);
    font-weight: bold;
}
.file-manager-row-view .file-manager-row-header .file-item-name {
    margin-left: 4rem;
}
[dir="rtl"] .file-manager-row-view .file-manager-row-header .file-item-name {
    margin-right: 4rem;
    margin-left: 0;
}
.light-style .file-item-name {
    color: #4e5155 !important;
}
.light-style .file-item.selected .file-item-select-bg {
    opacity: 0.15;
}
@media (min-width: 768px) {
    .light-style .file-manager-row-view .file-item-changed {
        display: block;
    }
    .light-style .file-manager-row-view .file-item-name {
        width: calc(100% - 15rem);
    }
}
@media (min-width: 992px) {
    .light-style .file-manager-col-view .file-item-checkbox,
    .light-style .file-manager-col-view .file-item-actions {
        opacity: 0;
    }
    .light-style .file-manager-col-view .file-item:hover .file-item-checkbox,
    .light-style .file-manager-col-view .file-item.focused .file-item-checkbox,
    .light-style .file-manager-col-view .file-item.selected .file-item-checkbox,
    .light-style .file-manager-col-view .file-item:hover .file-item-actions,
    .light-style .file-manager-col-view .file-item.focused .file-item-actions,
    .light-style .file-manager-col-view .file-item.selected .file-item-actions {
        opacity: 1;
    }
}
.material-style .file-item-name {
    color: #4e5155 !important;
}
.material-style .file-item.selected .file-item-select-bg {
    opacity: 0.15;
}
@media (min-width: 768px) {
    .material-style .file-manager-row-view .file-item-changed {
        display: block;
    }
    .material-style .file-manager-row-view .file-item-name {
        width: calc(100% - 15rem);
    }
}
@media (min-width: 992px) {
    .material-style .file-manager-col-view .file-item-checkbox,
    .material-style .file-manager-col-view .file-item-actions {
        opacity: 0;
    }
    .material-style .file-manager-col-view .file-item:hover .file-item-checkbox,
    .material-style .file-manager-col-view .file-item.focused .file-item-checkbox,
    .material-style .file-manager-col-view .file-item.selected .file-item-checkbox,
    .material-style .file-manager-col-view .file-item:hover .file-item-actions,
    .material-style .file-manager-col-view .file-item.focused .file-item-actions,
    .material-style .file-manager-col-view .file-item.selected .file-item-actions {
        opacity: 1;
    }
}
.dark-style .file-item-name {
    color: #fff !important;
}
.dark-style .file-item.selected .file-item-select-bg {
    opacity: 0.15;
}
@media (min-width: 768px) {
    .dark-style .file-manager-row-view .file-item-changed {
        display: block;
    }
    .dark-style .file-manager-row-view .file-item-name {
        width: calc(100% - 15rem);
    }
}
@media (min-width: 992px) {
    .dark-style .file-manager-col-view .file-item-checkbox,
    .dark-style .file-manager-col-view .file-item-actions {
        opacity: 0;
    }
    .dark-style .file-manager-col-view .file-item:hover .file-item-checkbox,
    .dark-style .file-manager-col-view .file-item.focused .file-item-checkbox,
    .dark-style .file-manager-col-view .file-item.selected .file-item-checkbox,
    .dark-style .file-manager-col-view .file-item:hover .file-item-actions,
    .dark-style .file-manager-col-view .file-item.focused .file-item-actions,
    .dark-style .file-manager-col-view .file-item.selected .file-item-actions {
        opacity: 1;
    }
}
</style>
';
$body['footer'] = '

';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['UploadBackup'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $type = check_string($_POST['type']);
    if ($_FILES['listbacup']['name']) {
        foreach ($_FILES['listbacup']['name'] as $name => $value) {
            if ($type == 1) {
                $uid = explode("_", $value)[1];
                $uid = explode(".", $uid)[0];
            } elseif ($type == 2) {
                $uid = explode(".", $value)[0];
            } elseif ($type == 3) {
                $uid = explode("_", $value)[0];
            } elseif ($type == 4) {
                $uid = explode("-", $value)[0];
            } elseif ($type == 5) {
                $uid = explode("-", $value)[1];
                $uid = explode(".", $uid)[0];
            }
            $uploads_dir = 'assets/storage/backup/';
            $tmp_name = $_FILES['listbacup']['tmp_name'][$name];
            $url_img = $uid.".zip";
            move_uploaded_file($tmp_name, $uploads_dir.$url_img);
        }
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "";}</script>');
    }
}

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách file backup</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách file backup</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                </section>
                <section class="col-lg-6 text-right">
                    <div class="mb-3">
                        <button class="btn btn-primary btn-icon-left m-b-10" data-toggle="modal"
                            data-target="#modal-default" type="button"><i class="fas fa-plus-circle mr-1"></i>Tải lên
                            file backup</button>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-archive mr-1"></i>
                                DANH SÁCH FILE BACKUP
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
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                </div>
                                <div class="col-sm-6">
                                    <button class="float-right btn btn-danger btn-sm" type="button"
                                        onclick="deleteConfirm()" name="btn_delete"><i
                                            class="fas fa-trash mr-1"></i>Delete</button>
                                </div>
                            </div>
                            <div class="file-manager-container file-manager-col-view">
                                <?php
                                $dirBackup = 'assets/storage/backup/';
                                $i = COUNT(dirToArray($dirBackup)); foreach (dirToArray($dirBackup) as $row) {
                                    if (explode('.', $row)[1] != 'zip') {
                                        continue;
                                    } ?>
                                <div class="file-item">
                                    <div class="file-item-select-bg bg-primary"></div>
                                    <label class="file-item-checkbox custom-control custom-checkbox">
                                        <input type="checkbox" name="checkbox" value="<?=$row; ?>"
                                            class="custom-control-input" />
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <div
                                        class="file-item-icon far fa-file-<?php echo getFileType($row); ?> text-secondary">
                                    </div>
                                    <b  class="file-item-name">
                                        <?=$row; ?>
                                    </b>
                                    <div class="file-item-changed"><?=timeAgo(GetCorrectMTime($dirBackup.$row)); ?></div>
                                    <div class="file-item-actions btn-group">
                                        <button type="button"
                                            class="btn btn-default btn-sm icon-btn borderless md-btn-flat hide-arrow dropdown-toggle"
                                            data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" target="_blank"
                                                href="<?=base_url('assets/storage/backup/'.$row); ?>">Download</a>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="RemoveRow(`<?=$row; ?>`)">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload File Backup</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Chọn danh sách backup</label>
                        <div class="col-sm-7">
                            <div class="form-line">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="form-control" id="exampleInputFile" name="listbacup[]"
                                            multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Chọn loại backup</label>
                        <div class="col-sm-7">
                            <div class="form-line">
                                <select class="form-control" name="type">
                                    <option value="1">name_uid.zip</option>
                                    <option value="2">uid.zip</option>
                                    <option value="3">uid_name.zip</option>
                                    <option value="4">uid-name.zip</option>
                                    <option value="5">name-uid.zip</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <p>Số lượng tải lên tối đa 1 lần của server bạn là <b
                            style="color: red;"><?=ini_get('max_file_uploads');?></b> file backup.</p>
                            <p>Liên hệ phía cung cấp Hosting/VPS để tăng giới hạn '<b style="color:red;font-size:13px;">max_file_uploads</b>'</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ĐÓNG</button>
                    <button type="submit" name="UploadBackup" class="btn btn-primary">TẢI LÊN</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
<script type="text/javascript">
function postRemove(filename) {
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/removeBackup.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            filename: filename
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                location.reload();
            } else {
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: respone.msg,
                    buttonText: "Okay"
                });
            }
        },
        error: function() {
            alert(html(response));
            location.reload();
        }
    });
}
function RemoveRow(filename) {
    cuteAlert({
        type: "question",
        title: "Xác nhận xoá hàng",
        message: "Bạn có chắc chắn muốn xóa file (" + filename + ") không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            postRemove(filename);
            location.reload();
        }
    })
}
function deleteConfirm() {
    var result = confirm("Bạn có thực sự muốn xóa các bản ghi đã chọn?");
    if (result) {
        var checkbox = document.getElementsByName('checkbox');
        for (var i = 0; i < checkbox.length; i++) {
            if (checkbox[i].checked === true) {
                postRemove(checkbox[i].value);
            }
        }
        location.reload();
    }
}
</script>
<script>
$(function() {
    $('#datatable1').DataTable();
});
</script>