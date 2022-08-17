<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thêm menu',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '

';
$body['footer'] = '

';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['create'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $isCreate = $CMSNT->insert("menu", [
        'name'          => check_string($_POST['name']),
        'href'          => check_string($_POST['href']),
        'icon'          => $_POST['icon'],
        'target'        => isset($_POST['target']) ? check_string($_POST['target']) : '',
        'status'        => check_string($_POST['status'])
    ]);
    if ($isCreate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm menu (".check_string($_POST['name']).") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('admin/menu-list').'";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm menu thất bại, vui lòng thử lại!")){window.history.back().location.reload();}</script>');
    }
}

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thêm menu</li>
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
                                THÊM MENU MỚI
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
                                    <input type="text" class="form-control" placeholder="Nhập tên menu cần tạo"
                                        name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Liên kết</label>
                                    <input type="text" class="form-control"
                                        placeholder="Nhập địa chỉ liên kết cần tới khi click vào menu này" name="href"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Icon menu</label>
                                    <input type="text" class="form-control"
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
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="target" value="_blank"
                                        id="customCheckbox2" checked>
                                    <label for="customCheckbox2" class="custom-control-label">Mở tab mới khi
                                        click</label>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" name="create" class="btn btn-primary"><i
                                        class="fas fa-plus mr-1"></i>THÊM NGAY</button>
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