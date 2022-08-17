<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Hoá đơn',
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
                    <h1 class="m-0">Hoá đơn</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Hoá đơn</li>
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
                                <i class="fas fa-file-invoice mr-1"></i>
                                DANH SÁCH HOÁ ĐƠN
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
                            <form action="" id="form" method="post">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <a onclick="exportExcel()" href="javascript:;" type="button" class="btn btn-success btn-sm"><i class="fas fa-file-csv mr-1"></i>XUẤT EXCEL</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="float-right btn btn-danger btn-sm" type="button"
                                            onclick="deleteConfirm()" name="btn_delete"><i
                                                class="fas fa-trash mr-1"></i>Delete</button>
                                    </div>
                                </div>
                                <div class="table-responsive p-0">
                                    <table id="datatable1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <th width="5px;"><input type="checkbox" name="check_all" id="check_all"
                                                        value="option1"></th>
                                                <th>Username</th>
                                                <th>TransID</th>
                                                <th>Method</th>
                                                <th>Amount</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Createdate</th>
                                                <th>Updatedate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `invoices` WHERE  `type` = 'deposit_money' AND `fake` = 0 ORDER BY `id` DESC ") as $inv) {?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><input type="checkbox" data-id="<?=$inv['id'];?>" name="checkbox"
                                                        class="checkbox" value="<?=$inv['id'];?>" /></td>
                                                <td><a
                                                        href="<?=base_url('admin/user-edit/'.$inv['user_id']);?>"><?=getRowRealtime("users", $inv['user_id'], "username");?></a>
                                                </td>
                                                <td><a href="<?=base_url('client/payment/'.$inv['trans_id']);?>"><i
                                                            class="fas fa-file-alt"></i>
                                                        <?=$inv['trans_id'];?></a></td>
                                                <td><b style="font-size:15px;"><?=$inv['payment_method'];?></b></td>
                                                <td><b style="color: red;"><?=format_currency($inv['amount']);?></b>
                                                </td>
                                                <td><b style="color: green;"><?=format_cash($inv['pay']);?>đ</b></td>
                                                <td><?=display_invoice($inv['status']);?></td>
                                                <td><?=$inv['create_date'];?></td>
                                                <td><?=$inv['update_date'];?></td>
                                                <td>
                                                    <a aria-label=""
                                                        href="<?=base_url('admin/invoice-edit/'.$inv['id']);?>"
                                                        style="color:white;"
                                                        class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                                                        <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                    </a>
                                                    <button style="color:white;" onclick="RemoveRow(<?=$inv['id'];?>)"
                                                        class="btn btn-danger btn-sm btn-icon-left m-b-10"
                                                        type="button">
                                                        <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
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



<script type="text/javascript">
function exportExcel() {
    cuteAlert({
        type: "question",
        title: "CẢNH BÁO",
        message: "Hệ thống sẽ tải về dữ liệu users nếu bạn xác nhận Đồng Ý",
        confirmText: "<?=__('Đồng Ý');?>",
        cancelText: "<?=__('Hủy');?>"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/exportExcel.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    type: "invoices"
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
function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/removeInvoice.php');?>",
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
        title: "Xác Nhận Xóa Hoá Đơn",
        message: "Bạn có chắc chắn muốn xóa hoá đơn này không ?",
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