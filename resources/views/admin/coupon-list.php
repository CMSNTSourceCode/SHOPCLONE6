<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Danh sách mã giảm giá',
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
require_once(__DIR__.'/../../../models/is_license.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách mã giảm giá</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách mã giảm giá</li>
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
                        <a class="btn btn-primary btn-icon-left m-b-10" href="<?=BASE_URL('admin/coupon-add');?>"
                            type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm mã giảm giá</a>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-gift mr-1"></i>
                                DANH SÁCH MÃ GIẢM GIÁ
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
                                <table id="datatable1" class="table table-striped table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 5px;">#</th>
                                            <th>Mã giảm giá</th>
                                            <th>Số lượng</th>
                                            <th>Đã sử dụng</th>
                                            <th>Giảm</th>
                                            <th>Thời gian tạo</th>
                                            <th style="width: 20%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($CMSNT->get_list("SELECT * FROM `coupons` ") as $row) {?>
                                        <tr>
                                            <td><?=$row['id'];?></td>
                                            <td><b><?=$row['code'];?></b> (<?=$row['used'] >= $row['amount'] ? '<span style="color:red">Đã sử dụng hết</span>' : '<span style="color:green">Còn '.$AWWW2=$row['amount'] - $row['used'].' lượt sử dụng</span>';?>)</td>
                                            <td><span style="font-size: 15px;" class="badge badge-info"><?=format_cash($row['amount']);?></span>
                                            </td>
                                            <td><span style="font-size: 15px;" class="badge badge-danger"><?=format_cash($row['used']);?></span>
                                            </td>
                                            <td><span style="font-size: 15px;" class="badge badge-dark"><?=$row['discount'];?>%</span></td>
                                            <td><?=$row['createdate'];?></td>
                                            <td>
                                            <a aria-label="" href="<?=base_url('admin/coupon-log/'.$row['id']);?>"
                                                    style="color:white;"
                                                    class="btn btn-primary btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-history mr-1"></i><span class="">History</span>
                                                </a>
                                                <a aria-label="" href="<?=base_url('admin/coupon-edit/'.$row['id']);?>"
                                                    style="color:white;"
                                                    class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </a>
                                                <button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>', '<?=$row['code'];?>')"
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
                    <p>Xem hướng dẫn sử dụng tại đây: <a target="_blank" href="https://www.youtube.com/watch?v=vlSxfMfoKwY&list=PLylqe6Lzq699BYT-ZXL5ZZg4gaNqwGpEW&index=5">https://www.youtube.com/watch?v=vlSxfMfoKwY&list=PLylqe6Lzq699BYT-ZXL5ZZg4gaNqwGpEW&index=5</a></p>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
<script type="text/javascript">
function RemoveRow(id, code) {
    cuteAlert({
        type: "question",
        title: "Xác nhận xoá hàng",
        message: "Bạn có chắc chắn muốn xóa mã giảm giá " + code + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/removeCoupon.php");?>",
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