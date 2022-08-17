<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Đơn hàng sản phẩm',
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
                    <h1 class="m-0">Đơn hàng sản phẩm</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Đơn hàng sản phẩm</li>
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
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                DANH SÁCH 1000 ĐƠN MUA TÀI KHOẢN
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
                                    <a onclick="exportExcel()" href="javascript:;" type="button"
                                        class="btn btn-success btn-sm"><i class="fas fa-file-csv mr-1"></i>XUẤT
                                        EXCEL</a>
                                </div>
                                <div class="col-sm-6">
                                     
                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Khách hàng</th>
                                            <th>Đơn hàng</th>
                                            <th>Thời gian</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach ($CMSNT->get_list("SELECT * FROM `orders` WHERE `product_id` != 0 AND `fake` = 0 ORDER BY id DESC LIMIT 1000 ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td>
                                                <ul>
                                                    <li>Username: <b><a
                                                                href="<?=base_url('admin/user-edit/'.$row['buyer']);?>"><?=getRowRealtime("users", $row['buyer'], "username");?></a>
                                                            (<?=__($row['buyer']);?>)</b></li>
                                                    <li>Money: <b style="color: red;"><?=format_currency(getRowRealtime("users", $row['buyer'], "money"));?></b></li>        
                                                    <li>Total money: <b><?=format_currency(getRowRealtime("users", $row['buyer'], "total_money"));?></b></li>
                                                    <li>Email: <b><?=getRowRealtime("users", $row['buyer'], "email");?></b></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Mã giao dịch: <b>#<?=$row['trans_id'];?></b></li>
                                                    <li>Mã giao dịch API (nếu có): <b>#<?=$row['api_trans_id'];?></b></li>
                                                    <li>Server API (nếu có): <a href="<?=getRowRealtime('connect_api', $row['id_connect_api'], 'domain');?>" target="_blank"><?=$row['id_connect_api'] != 0 ? getRowRealtime('connect_api', $row['id_connect_api'], 'domain') : '';?></a></li>
                                                    <li>Sản phẩm:
                                                        <b><?=getRowRealtime("products", $row['product_id'], 'name');?></b>
                                                    </li>
                                                    <li>Số lượng: <b
                                                            style="color:blue;"><?=format_cash($row['amount']);?></b>
                                                    </li>
                                                    <li>Thanh toán: <b
                                                            style="color:red;"><?=format_currency($row['pay']);?></b>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td><?=$row['create_date'];?></td>
                                            <td><button type="button" onclick="showAccounts(`<?=$row['trans_id'];?>`)"
                                                    class="btn btn-primary btn-sm showAccounts">Xem Thêm</button></td>
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
<div class="modal fade" id="modalAccounts" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tài khoản đơn hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="coypyBox" rows="20" readonly></textarea>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary copy" onclick="copy()"
                    data-clipboard-target="#coypyBox">Sao chép</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function exportExcel() {
    cuteAlert({
        type: "question",
        title: "CẢNH BÁO",
        message: "Hệ thống sẽ tải về dữ liệu đơn hàng nếu bạn xác nhận Đồng Ý",
        confirmText: "<?=__('Đồng Ý');?>",
        cancelText: "<?=__('Hủy');?>"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/exportExcel.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    type: "product-order"
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        downloadCSV(respone.filename, respone.accounts);
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
function downloadCSV(filename, text) {
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(text));
  element.setAttribute('download', filename);
  element.style.display = 'none';
  document.body.appendChild(element);
  element.click();
  document.body.removeChild(element);
}
</script>

<script type="text/javascript">
$(function() {
    $('#datatable').DataTable();
});
</script>
<script type="text/javascript">
function showAccounts(trans_id) {
    $.ajax({
        url: "<?=base_url('ajaxs/admin/showAccounts.php');?>",
        method: "POST",
        data: {
            trans_id: trans_id
        },
        success: function(respone) {
            $('#modalAccounts').modal();
            $('#coypyBox').val(respone);
        }
    });
}
</script>
<script>
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "Đã sao chép vào bộ nhớ tạm",
        timer: 5000
    });
}
</script>