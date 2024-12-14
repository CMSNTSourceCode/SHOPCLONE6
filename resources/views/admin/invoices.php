<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Hoá đơn',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
$body['footer'] = '
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
    $(".select2").select2()
    $(".select2bs4").select2({
        theme: "bootstrap4"
    });
});
</script>
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');

$sotin1trang = 10;
if(isset($_GET['page'])){
    $page = check_string(intval($_GET['page']));
}
else{
    $page = 1;
}
$from = ($page - 1) * $sotin1trang;
$where = " `type` = 'deposit_money' AND `fake` = 0 ";
$user_id = '';
$trans_id = '';
$status = '';
$method = '';
$create_date = '';


if(!empty($_GET['user_id'])){
    $user_id = check_string($_GET['user_id']);
    $where .= ' AND `user_id` = "'.$user_id.'" ';
}
if(!empty($_GET['trans_id'])){
    $trans_id = check_string($_GET['trans_id']);
    $where .= ' AND `trans_id` LIKE "%'.$trans_id.'%" ';
}
if(!empty($_GET['status'])){
    $status = intval(check_string($_GET['status']));
    if($status == 1){
        $where .= ' AND `status` = 0 ';
    }else if($status == 2){
        $where .= ' AND `status` = 1 ';
    }else if($status == 3){
        $where .= ' AND `status` = 2 ';
    }
}
if(!empty($_GET['method'])){
    $method = check_string($_GET['method']);
    $where .= ' AND `payment_method` = "'.$method.'" ';
}
if(!empty($_GET['create_date'])){
    $create_date = check_string($_GET['create_date']);
    $create_date_1 = $create_date;
    $create_date_1 = explode(' - ', $create_date_1);
    if($create_date_1[0] != $create_date_1[1]){
        $create_date_1 = [$create_date_1[0].' 00:00:00', $create_date_1[1].' 23:59:59'];
        $where .= " AND `create_date` >= '".$create_date_1[0]."' AND `create_date` <= '".$create_date_1[1]."' ";
    }
}

$listInvoice = $CMSNT->get_list(" SELECT * FROM `invoices` WHERE $where ORDER BY `id` DESC LIMIT $from,$sotin1trang ");
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
                            <div class="row mb-2">
                             
                                <div class="col-sm-12 mb-3">
                                    <form action="" name="formSearch" method="GET">
                                        <input type="hidden" name="module" value="admin">
                                        <input type="hidden" name="action" value="invoices">
                                        <div class="row">
                                            <input class="form-control col-sm-2 mb-2" value="<?=$user_id;?>"
                                                name="user_id" placeholder="ID Khách hàng">   
                                            <input class="form-control col-sm-2 mb-2" value="<?=$trans_id;?>"
                                                name="trans_id" placeholder="TransID">
                                            <select class="form-control select2bs4 col-sm-2 mb-2" name="method">
                                            <option value="">Method</option>
                                            <?php foreach($config_listbank as $key => $value):?>
                                            <option <?=$method == $key ? 'selected' : '';?>
                                                value="<?=$key;?>">
                                                <?=$key;?>
                                            </option>
                                            <?php endforeach?>
                                            </select>
                                            <select class="form-control  col-sm-2 mb-2" name="status">
                                            <option value="">Status</option>
                                            <option <?=$status == 1 ? 'selected' : '';?> value="1"><?=__('Đang chờ thanh toán');?></option>
                                            <option <?=$status == 2 ? 'selected' : '';?> value="2"><?=__('Đã thanh toán');?></option>
                                            <option <?=$status == 3 ? 'selected' : '';?> value="3"><?=__('Huỷ bỏ');?></option>
                                            </select>
                                            <div class="form-group col-sm-2 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="create_date" value="<?=$create_date;?>"
                                                        class="form-control float-right" id="reservationtime">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <button type="submit" name="submit" value="filter"
                                                    class="btn btn-warning"><i class="fa fa-search"></i>
                                                    Tìm kiếm
                                                </button>
                                                <a class="btn btn-danger"
                                                    href="<?=BASE_URL('index.php?module=admin&action=invoices');?>"><i
                                                        class="fa fa-trash"></i>
                                                    Bỏ lọc
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <style>
                                .table-module thead td, .table-module thead th {
    border-bottom-width: 1px;
}
.table-module thead th {
    white-space: nowrap;
}
.table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table-module td, .table-module th {
    padding: 0.35rem;
    font-size: 13.5px;
    vertical-align: middle;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
                            </style>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
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
                                        <?php $i=0; foreach ($listInvoice as $inv) {?>
                                        <tr>
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
                                                <a aria-label="" href="<?=base_url('admin/invoice-edit/'.$inv['id']);?>"
                                                    style="color:white;"
                                                    class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </a>
                                                <button style="color:white;" onclick="RemoveRow(<?=$inv['id'];?>)"
                                                    class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <button class="btn btn-danger btn-sm" type="button" onclick="deleteConfirm()"
                                        name="btn_delete"><i class="fas fa-trash mr-1"></i>Delete</button>
                                        <a onclick="exportExcel()" href="javascript:;" type="button"
                                        class="btn btn-success btn-sm"><i class="fas fa-file-csv mr-1"></i>XUẤT
                                        EXCEL</a>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <?php
                                $total = $CMSNT->num_rows(" SELECT * FROM `invoices` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(base_url("index.php?module=admin&action=invoices&user_id=$user_id&trans_id=$trans_id&status=$status&method=$method&create_date=$create_date&"), $from, $total, $sotin1trang) . '</center>';}?>
                                </div>
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
<script>
$(function() {
    $('#reservationtime').daterangepicker({
        locale: {
            format: 'YYYY/MM/DD/'
        }
    })
    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    
});
</script>