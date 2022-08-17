<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Đánh giá của khách hàng',
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
                    <h1 class="m-0">Đánh giá của khách hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Đánh giá của khách hàng</li>
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
                                <i class="fas fa-comment-dots mr-1"></i>
                                NHẬT KÝ ĐÁNH GIÁ SẢN PHẨM
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
                                <table id="datatable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5px;">#</th>
                                            <th>Khách hàng</th>
                                            <th>Đơn hàng</th>
                                            <th>Đánh giá</th>
                                            <th>Phản hồi</th>
                                            <th>Thời gian</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0;
                                        foreach ($CMSNT->get_list("SELECT * FROM `reviews` ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Mã giao dịch:
                                                        <b><?=getRowRealtime("orders", $row['order_id'], 'trans_id');?></b>
                                                    </li>
                                                    <?php if($row['product_id'] !=0):?>
                                                    <li>Sản phẩm:
                                                        <a href="<?=base_url_admin('product-edit/'.$row['product_id']);?>"><b><?=getRowRealtime("products", $row['product_id'], 'name');?></b></a>
                                                    </li>
                                                    <?php elseif($row['document_id'] !=0):?>
                                                    <li>Sản phẩm:
                                                        <a href="<?=base_url_admin('document-edit/'.$row['product_id']);?>"><b><?=getRowRealtime("documents", $row['document_id'], 'name');?></b></a>
                                                    </li>    
                                                    <?php endif?>
                                                    <li>Số lượng mua:
                                                        <b><?=format_cash(getRowRealtime("orders", $row['order_id'], 'amount'));?></b>
                                                    </li>
                                                    <li>Thanh toán:
                                                        <b><?=format_currency(getRowRealtime("orders", $row['order_id'], 'pay'));?></b>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td><?php $average_rating = $row['rating'];?>
                                                <i
                                                    class="fas fa-star <?=$average_rating >= 1 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                                <i
                                                    class="fas fa-star <?=$average_rating >= 2 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                                <i
                                                    class="fas fa-star <?=$average_rating >= 3 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                                <i
                                                    class="fas fa-star <?=$average_rating >= 4 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                                <i
                                                    class="fas fa-star <?=$average_rating >= 5 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                            </td>
                                            <td><?=$row['review'];?></td>
                                            <td><?=timeAgo($row['datetime']);?></td>
                                            <td><button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>')"
                                                    class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                </button></td>
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
function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/removeReview.php');?>",
        type: 'POST',
        dataType: "JSON",
        data: {
            id: id
        },
        success: function(response) {
            if (response.status == 'success') {
                cuteToast({
                    type: "success",
                    message: "Đã xóa thành công item " + id,
                    timer: 3000
                });
            } else {
                cuteToast({
                    type: "error",
                    message: "Đã xảy ra lỗi khi xoá item " + id,
                    timer: 5000
                });
            }
        }
    });
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
$(document).ready(function() {
    $('#check_all').on('click', function() {
        if (this.checked) {
            $('.checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkbox').each(function() {
                this.checked = false;
            });
        }
    });
    $('.checkbox').on('click', function() {
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#check_all').prop('checked', true);
        } else {
            $('#check_all').prop('checked', false);
        }
    });
});
</script>
<script type="text/javascript">
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Feedback",
        message: "Bạn có chắc chắn muốn xóa review này không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            postRemove(id);
            location.reload();
        }
    })
}
</script>
<script>
$(function() {
    $('#datatable1').DataTable();
});
</script>