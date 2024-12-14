<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
error_reporting(0);
$body = [
    'title' => 'Danh sách tài khoản đang bán',
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
 
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

if(isset($_GET['limit'])){
    $limit = intval(check_string($_GET['limit']));
}else{
    $limit = 10;
}
if(isset($_GET['page'])){
    $page = check_string(intval($_GET['page']));
}
else{
    $page = 1;
}
$from = ($page - 1) * $limit;

$where = ' `product_id` = "'.$row['id'].'" AND `buyer` IS NULL ';
$account = '';
$buyer = '';
$status = '';

if(!empty($_GET['account'])){
    $account = check_string($_GET['account']);
    $where .= ' AND `account` LIKE "%'.$account.'%" ';
}

if(!empty($_GET['status'])){
    $status = check_string($_GET['status']);
    $where .= ' AND `status` = "'.$status.'" ';
}
$listAccount = $CMSNT->get_list("SELECT * FROM `accounts` WHERE $where ORDER BY id DESC LIMIT $from,$limit  ");
$totalDatatable = $CMSNT->num_rows(" SELECT * FROM `accounts` WHERE $where ORDER BY id DESC ");
$urlDatatable = pagination(base_url("index.php?module=admin&action=account-view&id=$id&status=$status&account=$account&limit=$limit&"), $from, $totalDatatable, $limit);



require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách tài khoản đang bán '<?=$row['name'];?>'</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách tài khoản đang bán</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <a type="button" href="<?=base_url('admin/accounts/'.check_string($_GET['id']));?>"
                    class="btn btn-danger btn-block mb-5">QUAY LẠI</a>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i
                                class="fa-solid fa-cart-shopping"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tài khoản đang bán LIVE</span>
                            <span
                                class="info-box-number"><?=format_cash($CMSNT->get_row("SELECT COUNT(id)  FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i
                                class="fa-solid fa-cart-shopping"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tài khoản đang bán DIE</span>
                            <span
                                class="info-box-number"><?=format_cash($CMSNT->get_row("SELECT COUNT(id)  FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NULL AND `status` = 'DIE' ")['COUNT(id)']);?></span>
                        </div>
                    </div>
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-dolly-flatbed mr-1"></i>
                                DANH SÁCH TÀI KHOẢN ĐANG BÁN
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
                                    <form action="" id="formSearch" name="formSearch" method="GET">
                                        <input type="hidden" name="module" value="admin">
                                        <input type="hidden" name="action" value="account-view">
                                        <input type="hidden" name="id" value="<?=$id;?>">
                                        <div class="row">
                                            <input class="form-control col-sm-2 mb-2" value="<?=$account;?>"
                                                name="account" placeholder="Tìm tài khoản">

                                            <select class="form-control select2bs4 col-sm-2 mb-2" name="status">
                                                <option value="">Trạng thái</option>
                                                <option <?=$status == 'LIVE' ? 'selected' : '';?> value="LIVE">LIVE
                                                </option>
                                                <option <?=$status == 'DIE' ? 'selected' : '';?> value="DIE">DIE
                                                </option>
                                            </select>

                                            <div class="col-sm-4 mb-2">
                                                <button type="submit" 
                                                    class="btn btn-warning"><i class="fa fa-search"></i>
                                                    Tìm kiếm
                                                </button>
                                                <a class="btn btn-danger"
                                                    href="<?=BASE_URL('index.php?module=admin&action=account-view&id='.$id);?>"><i
                                                        class="fa fa-trash"></i>
                                                    Bỏ lọc
                                                </a>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <div class="dataTables_length">
                                                    <label>Show :
                                                        <select name="limit" id="limit" onchange="this.form.submit()"
                                                            class="custom-select custom-select-sm form-control form-control-sm">
                                                            <option <?=$limit == 5 ? 'selected' : '';?> value="5">5
                                                            </option>
                                                            <option <?=$limit == 10 ? 'selected' : '';?> value="10">10
                                                            </option>
                                                            <option <?=$limit == 20 ? 'selected' : '';?> value="20">20
                                                            </option>
                                                            <option <?=$limit == 50 ? 'selected' : '';?> value="50">50
                                                            </option>
                                                            <option <?=$limit == 100 ? 'selected' : '';?> value="100">
                                                                100
                                                            </option>
                                                            <option <?=$limit == 500 ? 'selected' : '';?> value="500">
                                                                500
                                                            </option>
                                                            <option <?=$limit == 1000 ? 'selected' : '';?> value="1000">
                                                                1000
                                                            </option>
                                                            <option <?=$limit == 10000 ? 'selected' : '';?> value="10000">
                                                                10000
                                                            </option>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5px;"><input type="checkbox" name="check_all" id="check_all"
                                                    value="option1"></th>
                                            <th>Người bán</th>
                                            <th>Tài khoản</th>
                                            <th>Thời gian đưa lên</th>
                                            <th>Trạng thái</th>
                                            <th>Check live gần nhất</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listAccount as $row) {?>
                                        <tr>
                                            <td><input type="checkbox" data-id="<?=$row['id'];?>" name="checkbox"
                                                    class="checkbox" value="<?=$row['id'];?>" /></td>
                                            <td><a
                                                    href="<?=base_url('admin/user-edit/'.$row['seller']);?>"><?=getRowRealtime("users", $row['seller'], "username");?></a>
                                            </td>
                                            <td><textarea class="form-control" readonly><?=$row['account'];?></textarea>
                                            </td>
                                            <td><?=$row['create_date'];?></td>
                                            <td><?=display_live($row['status']);?></td>
                                            <td><?=timeAgo($row['time_live']);?></td>
                                            <td>
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
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <p class="page-info">Showing <?=$limit;?> of <?=$totalDatatable;?> Results</p>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <?=$totalDatatable > $limit ? $urlDatatable : '';?>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-danger btn-sm" type="button" onclick="deleteConfirm()"
                                        name="btn_delete"><i class="fas fa-trash mr-1"></i>Xoá đã chọn</button>
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
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Tài Khoản",
        message: "Bạn có chắc chắn muốn xóa tài khoản ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/removeAccount.php");?>",
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
<script type="text/javascript">
function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/removeAccount.php');?>",
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
        //location.reload();
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