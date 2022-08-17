<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Quản lý sản phẩm Fanpage/Group',
    'desc'   => '',
    'keyword' => ''
];
$body['header'] = '
    <!-- ckeditor -->
    <script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
    <!-- DataTables  & Plugins -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/jszip/jszip.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/vfs_fonts.js"></script>   
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['AddFanpage'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($CMSNT->get_row("SELECT * FROM `store_fanpage` WHERE `uid` = '".check_string($_POST['uid'])."' ")) {
        die('<script type="text/javascript">if(!alert("ID này đã tồn tại trong hệ thống.")){window.history.back().location.reload();}</script>');
    }
    $url_icon = null;
    if (check_img('icon') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 4);
        $uploads_dir = 'assets/storage/images/FanpageGroup'.$rand.'.png';
        $tmp_name = $_FILES['icon']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $url_icon = $uploads_dir;
        }
    }
    $isInsert = $CMSNT->insert("store_fanpage", [
        'seller'        => $getUser['id'],
        'icon'          => $url_icon,
        'name'          => check_string($_POST['name']),
        'uid'           => check_string($_POST['uid']),
        'price'         => check_string($_POST['price']),
        'sl_like'       => check_string($_POST['sl_like']),
        'nam_tao_fanpage'       => check_string($_POST['nam_tao_fanpage']),
        'fb_admin'      => check_string($_POST['fb_admin']),
        'content'       => base64_encode($_POST['content']),
        'type'          => check_string($_POST['type']),
        'create_gettime'    => gettime(),
        'create_time'       => time(),
        'update_time'       => time(),
        'update_gettime'    => gettime()
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm Fanpage/Group (".check_string($_POST['name']).") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "";}</script>');
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
                    <h1 class="m-0">Quản lý sản phẩm Fanpage/Group</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý sản phẩm Fanpage/Group</li>
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
                            data-target="#modal-AddFanpage" type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm
                            sản phẩm mới</button>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th-list mr-1"></i>
                                DANH SÁCH FANPAGE/GROUP
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
                            <div class="table-responsive">

                                <table id="datatable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5px;">#</th>
                                            <th>Fanpage/Group</th>
                                            <th>Chi tiết sản phẩm</th>
                                            <th>Thời gian</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `store_fanpage` ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td>
                                                <a href="https://www.facebook.com/<?=$row['uid'];?>" target="_blank"
                                                    class="d-block">
                                                    <img src="<?=base_url($row['icon']);?>" width="50px" height="50px"
                                                        class="img-circle elevation-2 mr-2"
                                                        alt="<?=$row['name'];?><"><b>
                                                        <?=$row['name'];?></b></a>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Loại: <b><?=$row['type'];?></b></li>
                                                    <li>Thời gian tạo: <b><?=$row['nam_tao_fanpage'];?></b></li>
                                                    <li>Số lượng Like/Member: <b><?=format_cash($row['sl_like']);?></b></li>
                                                    <li>Giá: <b
                                                            style="color: blue;"><?=format_currency($row['price']);?></b>
                                                    </li>
                                                    <li>FB Admin: <a href="<?=$row['fb_admin'];?>"
                                                            target="_blank"><?=$row['fb_admin'];?></a></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Thêm vào: <b><?=$row['create_gettime'];?></b>
                                                        (<b><?=timeAgo($row['create_time']);?></b>)</li>
                                                    <li>Cập nhật: <b><?=$row['update_gettime'];?></b>
                                                        (<b><?=timeAgo($row['update_time']);?></b>)</li>
                                                </ul>
                                            </td>
                                            <td><?=$row['buyer'] != 0 ? '<span class="badge badge-danger">Đã bán<span class="badge badge-success"></span>' : '<span class="badge badge-success">Đang bán</span>';?>
                                            </td>
                                            <td>
                                                <a aria-label=""
                                                    href="<?=base_url('admin/store-fanpage-edit/'.$row['id']);?>"
                                                    style="color:white;"
                                                    class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </a>
                                                <button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>')"
                                                    class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Fanpage/Group",
        message: "Bạn có chắc chắn muốn xóa Fanpage/Group ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/remove.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    action: 'removeStoreFanpage'
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
    })
}
</script>


<div class="modal fade" id="modal-AddFanpage">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">THÊM FANPAGE/GROUP</h4>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <?php if(checkAddon(14232) == true):?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên Fanpage/Group</label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập tên Fanpage/Group cần bán"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ID Fanpage/Group</label>
                        <input type="text" class="form-control" name="uid" placeholder="Nhập UID Fanpage/Group cần bán"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Facebook Admin</label>
                        <input type="text" class="form-control" name="fb_admin"
                            placeholder="Nhập link Facebook của Admin" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Avatar</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="icon" required>
                                <label class="custom-file-label" for="exampleInputFile">Choose
                                    file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Loại</label>
                        <select class="form-control" name="type" required>
                            <option value="Fanpage">Fanpage</option>
                            <option value="Group">Group</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Số lượng Like/Member</label>
                        <input type="number" class="form-control" name="sl_like"
                            placeholder="Nhập số lượng Like Fanpage hoặc Member Group" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Thời gian tạo Fanpage/Group</label>
                        <input type="number" class="form-control" name="nam_tao_fanpage"
                            placeholder="Nhập thời gian tạo Fanpage/Group nếu có">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Giá cần bán</label>
                        <input type="number" class="form-control" name="price" placeholder="Nhập giá cần bán" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mô tả thêm</label>
                        <textarea class="form-control" name="content"
                            placeholder="Nhập mô tả thêm cho sản phẩm nếu có"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button name="AddFanpage" class="btn btn-primary btn-block" type="submit">THÊM NGAY</button>
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">HUỶ</button>
                </div>
                <?php else:?>
                <div class="alert alert-danger" role="alert">
                    <div class="iq-alert-text">Bạn chưa kích hoạt Addon này!</div>
                </div>
                <?php endif?>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<?php
require_once(__DIR__.'/footer.php');
?>