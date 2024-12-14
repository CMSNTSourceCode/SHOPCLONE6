<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa Fanpage/Group',
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
require_once(__DIR__.'/../../../models/is_admin.php');
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `store_fanpage` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/store-fanpage'));
    }
} else {
    redirect(base_url('admin/store-fanpage'));
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
    if (check_img('icon') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 4);
        $uploads_dir = 'assets/storage/images/storeFanpage'.$rand.'.png';
        $tmp_name = $_FILES['icon']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $CMSNT->update("store_fanpage", [
                'icon' => $uploads_dir
            ], " `id` = '".$row['id']."' ");
        }
    }
    $isCreate = $CMSNT->update("store_fanpage", [
        'name'      => check_string($_POST['name']),
        'uid'       => check_string($_POST['uid']),
        'type'      => check_string($_POST['type']),
        'fb_admin'  => check_string($_POST['fb_admin']),
        'sl_like'   => check_string($_POST['sl_like']),
        'nam_tao_fanpage'       => check_string($_POST['nam_tao_fanpage']),
        'price'     => check_string($_POST['price']),
        'content'   => base64_encode($_POST['content'])
    ], " `id` = '".$row['id']."' ");
    if ($isCreate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa sản phẩm (".$row['name']." ID ".$row['id'].") vào hệ thống."
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
                    <h1 class="m-0">Chỉnh sửa Fanpage/Group</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa Fanpage/Group</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/store-fanpage');?>"
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
                                CHỈNH SỬA FANPAGE/GROUP
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
                            <?php if(checkAddon(14232) == true):?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Fanpage/Group</label>
                                    <input type="text" class="form-control" name="name" value="<?=$row['name'];?>"
                                        placeholder="Nhập tên Fanpage/Group cần bán" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">ID Fanpage/Group</label>
                                    <input type="text" class="form-control" name="uid" value="<?=$row['uid'];?>"
                                        placeholder="Nhập UID Fanpage/Group cần bán" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Facebook Admin</label>
                                    <input type="text" class="form-control" name="fb_admin"
                                        value="<?=$row['fb_admin'];?>" placeholder="Nhập link Facebook của Admin"
                                        required>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Avatar</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="icon">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <img width="200px" src="<?=BASE_URL($row['icon']);?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Loại</label>
                                    <select class="form-control" name="type" required>
                                        <option <?=$row['type'] == 'Fanpage' ? 'Selected' : '';?> value="Fanpage">
                                            Fanpage</option>
                                        <option <?=$row['type'] == 'Group' ? 'Selected' : '';?> value="Group">Group
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng Like/Member</label>
                                    <input type="number" class="form-control" value="<?=$row['sl_like'];?>"
                                        name="sl_like" placeholder="Nhập số lượng Like Fanpage hoặc Member Group"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thời gian tạo Fanpage/Group</label>
                                    <input type="number" class="form-control" name="nam_tao_fanpage"
                                        value="<?=$row['nam_tao_fanpage'];?>"
                                        placeholder="Nhập thời gian tạo Fanpage/Group nếu có">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá cần bán</label>
                                    <input type="number" class="form-control" name="price" value="<?=$row['price'];?>"
                                        placeholder="Nhập giá cần bán" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả thêm</label>
                                    <textarea class="form-control" name="content"
                                        placeholder="Nhập mô tả thêm cho sản phẩm nếu có"><?=base64_decode($row['content']);?></textarea>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" name="save" class="btn btn-primary"><i
                                        class="fas fa-save mr-1"></i>LƯU NGAY</button>
                            </div>
                            <?php else:?>
                            <div class="alert alert-danger" role="alert">
                                <div class="iq-alert-text">Bạn chưa kích hoạt Addon này!</div>
                            </div>
                            <?php endif?>
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