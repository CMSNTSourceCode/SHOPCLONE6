<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Danh sách sản phẩm',
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

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách sản phẩm</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách sản phẩm</li>
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
                        <a class="btn btn-primary btn-icon-left m-b-10" href="<?=BASE_URL('admin/product-add');?>"
                            type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm sản phẩm</a>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-shopping-cart mr-1"></i>
                                DANH SÁCH SẢN PHẨM HỆ THỐNG (không tính API)
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
                            <table id="datatable1" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5px;">STT</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Flag</th>
                                        <th>Price</th>
                                        <th>CheckLive</th>
                                        <th>Content</th>
                                        <th>Status</th>
                                        <th>Account</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `id_connect_api` = 0 ORDER BY `stt` ASC ") as $row) {?>
                                    <tr>
                                        <td><?=$row['stt'];?></td>
                                        <td><a
                                                href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getRowRealtime("users", $row['user_id'], "username");?></a>
                                        </td>
                                        <td><?=$row['name'];?></td>
                                        <td><?=getRowRealtime("categories", $row['category_id'], 'name');?></td>
                                        <td><?=display_flag($row['flag']);?></td>
                                        <td><?=format_currency($row['price']);?></td>
                                        <td><?=display_checklive($row['checklive']);?></td>
                                        <td><textarea class="form-control" readonly><?=$row['content'];?></textarea>
                                        </td>
                                        <td><?=display_status_product($row['status']);?></td>
                                        <td>
                                            <ul>
                                                <li>Đang bán:  <b style="color: green;"><?=format_cash($CMSNT->get_row("SELECT COUNT(id)  FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NULL  ")['COUNT(id)']);?></b> <a href="<?=base_url('index.php?module=admin&action=account-view&id='.$row['id']);?>">Xem</a></li>
                                                <li>Đã bán:  <b style="color:blue;"><?=format_cash($CMSNT->get_row("SELECT COUNT(id)  FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NOT NULL ")['COUNT(id)']);?></b> <a href="<?=base_url('index.php?module=admin&action=account-sold&id='.$row['id']);?>">Xem</a></li>
                                                <li>Die: <b style="color: red;"><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `status` = 'DIE' ")['COUNT(id)']);?></b></li>
                                            </ul>
                                           </td>
                                        <td>
                                            <a aria-label="" href="<?=base_url('admin/accounts/'.$row['id']);?>"
                                                style="color:white;" class="btn btn-dark btn-sm btn-icon-left m-b-10"
                                                type="button">
                                                <i class="fas fa-tasks mr-1"></i><span class="">Quản lý tài khoản</span>
                                            </a>
                                            <a aria-label="" href="<?=base_url('admin/product-edit/'.$row['id']);?>"
                                                style="color:white;" class="btn btn-info btn-sm btn-icon-left m-b-10"
                                                type="button">
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
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
<script type="text/javascript">
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Sản Phẩm",
        message: "Bạn có chắc chắn muốn xóa sản phẩm ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/removeProduct.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
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
<script>
$(function() {
    $('#datatable1').DataTable();
});
</script>