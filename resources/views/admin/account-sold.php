<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Tài khoản đã bán',
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
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
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `products` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/product-list'));
    }
} else {
    redirect(base_url('admin/product-list'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý tài khoản đã bán</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý tài khoản đã bán</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-dolly-flatbed mr-1"></i>
                                DANH SÁCH TÀI KHOẢN ĐÃ BÁN
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
                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5px;">#</th>
                                            <th>Bên bán</th>
                                            <th>Bên mua</th>
                                            <th width="30%">Thông tin </th>
                                            <th>Thời gian đưa lên</th>
                                            <th>Trạng thái</th>
                                            <th>Check live gần đây</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NOT NULL ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td>
                                                <ul>
                                                    <li>ID: <b><?=$row['seller'];?></b></li>
                                                    <li>Username: <b><a href="<?=base_url('admin/user-edit/'.$row['seller']);?>"><?=getRowRealtime("users", $row['seller'], "username");?></a></b></li>
                                                    <li>Email: <b><?=getRowRealtime("users", $row['seller'], "email");?></b></li>
                                                </ul>    
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>ID: <b><?=$row['buyer'];?></b></li>
                                                    <li>Username: <b><a href="<?=base_url('admin/user-edit/'.$row['buyer']);?>"><?=getRowRealtime("users", $row['buyer'], "username");?></a></b></li>
                                                    <li>Email: <b><?=getRowRealtime("users", $row['buyer'], "email");?></b></li>
                                                </ul>    
                                            </td>
                                            <td>
                                                Đơn hàng: <b>#<a target="_blank" href="<?=base_url_admin('product-order');?>"><?=$row['trans_id'];?></a></b>
                                                <textarea class="form-control" readonly><?=$row['account'];?></textarea>
                                            </td>
                                            <td><?=$row['create_date'];?></td>
                                            <td><?=display_live($row['status']);?></td>
                                            <td><?=timeAgo($row['time_live']);?></td>
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
<script>
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}
</script>