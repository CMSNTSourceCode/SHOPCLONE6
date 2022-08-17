<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa phần thưởng',
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
    $row = $CMSNT->get_row("SELECT * FROM `spin_option` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/spin-list'));
    }
} else {
    redirect(base_url('admin/spin-list'));
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
    $isCreate = $CMSNT->update("spin_option", [
        'name'  => check_string($_POST['name']),
        'price' => check_string($_POST['price']),
        'rate'  => check_string($_POST['rate']),
        'display' => check_string($_POST['display'])
    ], " `id` = '".$row['id']."' ");
    if ($isCreate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa phần thưởng vòng quay (".$row['name']." ID ".$row['id'].")."
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
                    <h1 class="m-0">Chỉnh sửa phần thưởng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa phần thưởng</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/spin-list');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-gamepad mr-1"></i>
                                CHỈNH SỬA PHẦN THƯỞNG
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
                                    <label for="exampleInputEmail1">Tên tuỳ chọn</label>
                                    <input type="text" class="form-control" name="name" value="<?=$row['name'];?>"
                                        placeholder="Nhập tên tuỳ chọn phần thưởng" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phần thưởng</label>
                                    <input type="number" class="form-control" name="price" value="<?=$row['price'];?>"
                                        placeholder="Nhập số tiền thưởng nếu có, nhập 0 để set no lucky" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tỷ lệ trúng</label>
                                    <input type="text" class="form-control" name="rate" value="<?=$row['rate'];?>"
                                        placeholder="Nhập tỷ lệ quay ra phần thưởng này, 0 - 100" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <select class="form-control" name="display" required>
                                        <option <?=$row['display'] == 1 ? 'selected' : '';?> value="1">Hiển thị</option>
                                        <option <?=$row['display'] == 0 ? 'selected' : '';?> value="0">Ẩn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="save" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
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