<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Cấu hình Mua Tương Tác',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
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
                    <h1 class="m-0">Cấu hình Mua Tương Tác</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url_admin('home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Cấu hình Mua Tương Tác</li>
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
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẤU HÌNH API
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
                                    <label for="exampleInputEmail1">Token</label>
                                    <div class="row">
                                        <div class="col-lg-12 mr-1 mb-3">
                                            <textarea class="form-control" name="token_autofb"
                                                required><?=$CMSNT->site('token_autofb');?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status_buff_like_sub">
                                        <option <?=$CMSNT->site('status_buff_like_sub') == 1 ? 'selected' : '';?>
                                            value="1">ON
                                        </option>
                                        <option <?=$CMSNT->site('status_buff_like_sub') == 0 ? 'selected' : '';?>
                                            value="0">
                                            OFF
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                            <i class="fas fa-question-circle mr-1"></i>
                                HƯỚNG DẪN CẤU HÌNH
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
                            <ul>
                                <li>Bước 1: Truy cập website <a target="_blank"
                                        href="<?=$CMSNT->site('domain_autofb');?>"><?=$CMSNT->site('domain_autofb');?></a>
                                    đăng ký 1 tài khoản.</li>
                                <li>Bước 2: Đăng nhập tài khoản mà quý khách vừa mới đăng ký sau đó truy cập vào <a
                                        target="_blank"
                                        href="<?=$CMSNT->site('domain_autofb');?>siteagency"><?=$CMSNT->site('domain_autofb');?>siteagency</a>.
                                </li>
                                <li>Bước 3: Kéo xuống dưới cùng (Token API ( Ai tự dùng API thì mới cần sử dụng token
                                    này!!!)), click vào nút <b>Lấy token API</b>.</li>
                                <li>Bước 4: Copy token vừa lấy, dán vào ô <b>Token</b> phía trên sau đó nhấn lưu là
                                    xong (nhớ nạp sẵn tiền vào web API để sử dụng dịch vụ nhé).</li>
                            </ul>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẬP NHẬT GIÁ
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
                            <div class="callout callout-info">
                                <h5>Lưu ý</h5>
                                <ul>
                                    <li>SET giá về <b style="color: red;">0</b> để bảo trì dịch vụ.</li>
                                    <li>Vui lòng không thay đổi dữ liệu <b>Server</b> nếu bạn không biết gì về nó.</li>
                                </ul>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="20%">Loại</th>
                                            <th width="10%">Server</th>
                                            <th>Tên dịch vụ</th>
                                            <th width="10%">Giá</th>
                                            <th>Ghi chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `rate_autofb` ORDER BY id DESC  ") as $row) {?>
                                        <tr>
                                            <td><?=$row['type_api'];?></td>
                                            <td><textarea id="loaiseeding<?=$row['id'];?>"
                                                    onchange="updateForm(`<?=$row['id'];?>`)"
                                                    class="form-control"><?=$row['loaiseeding'];?></textarea></td>
                                            <td><textarea id="name_loaiseeding<?=$row['id'];?>"
                                                    onchange="updateForm(`<?=$row['id'];?>`)"
                                                    class="form-control"><?=$row['name_loaiseeding'];?></textarea>
                                            </td>
                                            <td><textarea id="price<?=$row['id'];?>"
                                                    onchange="updateForm(`<?=$row['id'];?>`)"
                                                    class="form-control"><?=$row['price'];?></textarea></td>
                                            <td><textarea id="note<?=$row['id'];?>"
                                                    onchange="updateForm(`<?=$row['id'];?>`)"
                                                    class="form-control"><?=$row['note'];?></textarea>
                                                <i>Được phép chèn các thẻ HTML</i>
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
<?php
require_once(__DIR__.'/footer.php');
?>

<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/updateForm.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            table: 'rate_autofb',
            id: id,
            loaiseeding: $("#loaiseeding" + id).val(),
            name_loaiseeding: $("#name_loaiseeding" + id).val(),
            note: $("#note" + id).val(),
            price: $("#price" + id).val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
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
</script>


<script>
$(function() {
    $('#datatable2').DataTable();
});
</script>