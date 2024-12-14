<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
error_reporting(0);
$body = [
    'title' => 'Đơn hàng mua xu',
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
 
if(checkAddon(11522) != true){
    die('Vui lòng kích hoạt <a href="'.base_url_admin('addons').'">Addon</a> trước khi truy cập.');
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
$where = ' `id` > 0 ';
$username = '';
$server = '';
$user_nhan = '';
$trans_id = '';
$status = '';

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
if (!empty($_GET['username'])) {
    $username = check_string($_GET['username']);
    if($idUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `username` = '$username' ")){
        $where .= ' AND `user_id` =  "'.$idUser['id'].'" ';
    }else{
        $where .= ' AND `user_id` =  "" ';
    }
}
if(!empty($_GET['user_nhan'])){
    $user_nhan = check_string($_GET['user_nhan']);
    $where .= ' AND `user_nhan` LIKE "%'.$user_nhan.'%" ';
}
if(!empty($_GET['trans_id'])){
    $trans_id = check_string($_GET['trans_id']);
    $where .= ' AND `trans_id` LIKE "%'.$trans_id.'%" ';
}
if(!empty($_GET['server'])){
    $server = check_string($_GET['server']);
    $where .= ' AND `server` = "'.$server.'" ';
}

$listDatatable = $CMSNT->get_list("SELECT * FROM `order_tds_ttc` WHERE $where ORDER BY id DESC LIMIT $from,$limit  ");
$totalDatatable = $CMSNT->num_rows(" SELECT * FROM `order_tds_ttc` WHERE $where ORDER BY id DESC ");
$urlDatatable = pagination(base_url_admin("xu-order&limit=$limit&username=$username&server=$server&user_nhan=$user_nhan&status=$status&trans_id=$trans_id&"), $from, $totalDatatable, $limit);



require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Đơn hàng mua xu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Đơn hàng mua xu</li>
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
                                DANH SÁCH ĐƠN MUA XU
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
                                    <form action="<?=base_url();?>" name="formSearch" method="GET">
                                        <input type="hidden" name="module" value="admin">
                                        <input type="hidden" name="action" value="xu-order">
                                        <div class="row">
                                            <input class="form-control col-sm-3 mb-2" value="<?=$trans_id;?>"
                                                name="trans_id" placeholder="TransID">
                                            <input class="form-control col-sm-3 mb-2" value="<?=$username;?>"
                                                name="username" placeholder="Username">
                                            <input class="form-control col-sm-3 mb-2" value="<?=$user_nhan;?>"
                                                name="user_nhan" placeholder="User nhận xu">
                                            <select class="form-control col-sm-3 mb-2" name="server">
                                                <option value="">Server</option>
                                                <option <?=$server == 'TDS' ? 'selected' : '';?> value="TDS">TDS
                                                </option>
                                                <option <?=$server == 'TTC' ? 'selected' : '';?> value="TTC">TTC
                                                </option>
                                            </select>
                                            <select class="form-control col-sm-3 mb-2" name="status">
                                                <option value="">Trạng thái</option>
                                                <option <?=$status == 2 ? 'selected' : '';?> value="2">Hoàn tất
                                                </option>
                                                <option <?=$status == 3 ? 'selected' : '';?> value="3">Hủy
                                                </option>
                                                <option <?=$status == 1 ? 'selected' : '';?> value="1">Đang xử lý
                                                </option>
                                            </select>
                                            <div class="col-sm-4 mb-2">
                                                <button type="submit" name="submit" value="filter"
                                                    class="btn btn-warning"><i class="fa fa-search"></i>
                                                    Tìm kiếm
                                                </button>
                                                <a class="btn btn-danger"
                                                    href="<?=BASE_URL('index.php?module=admin&action=xu-order');?>"><i
                                                        class="fa fa-trash"></i>
                                                    Bỏ lọc
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>TransID</th>
                                            <th>Username</th>
                                            <th>Server</th>
                                            <th>User nhận xu</th>
                                            <th>Số xu mua</th>
                                            <th>Số xu còn lại</th>
                                            <th>Thanh toán</th>
                                            <th><?=__('Thời gian');?></th>
                                            <th>Cập nhật</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listDatatable as $row):?>
                                        <tr>
                                            <td><?=$row['trans_id'];?></td>
                                            <td><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getRowRealtime("users", $row['user_id'], "username");?></a>
                                            </td>
                                            <td class="text-center">
                                               <?=$row['server'] == 'TDS' ? '<span class="badge badge-info">'.$row['server'].'</span>' : '<span class="badge badge-primary">'.$row['server'].'</span>';?>
                                            </td>
                                            <td><?=$row['user_nhan'];?></td>
                                            <td class="text-right"><b
                                                    style="color:green;"><?=format_cash($row['amount']);?></b></td>
                                            <td class="text-right"><b
                                                    style="color:red;"><?=format_cash($row['remaining']);?></b></td>
                                            <td class="text-right"><b
                                                    style="color:blue;"><?=format_currency($row['money']);?></b></td>
                                            <td><small><?=$row['create_gettime'];?></small></td>
                                            <td><small><?=$row['update_gettime'];?></small></td>
                                            <td class="text-center"><?=display_mua_xu($row['status']);?></td>
                                            <td class="text-center">
                                                <button type="button"
                                                    onclick="modalEdit(`<?=$row['id'];?>`)"
                                                    class="btn btn-sm btn-default" data-bs-toggle="tooltip"
                                                    title="<?=__('See details');?>">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button"
                                                    onclick="modalView(`<?=$row['id'];?>`)"
                                                    class="btn btn-sm btn-default" data-bs-toggle="tooltip"
                                                    title="<?=__('See details');?>">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button onclick="RemoveRow('<?=$row['id'];?>')"
                                                    class="btn btn-sm btn-default" type="button">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">

                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <?=$totalDatatable > $limit ? $urlDatatable : '';?>
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

<div class="modal fade" id="OpenModal" tabindex="-1" aria-labelledby="modal-block-popout" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content">
            <div id="modalViewEdit"></div>
        </div>
    </div>
</div>

<script>
function modalEdit(id) {
    $("#modalViewEdit").html('');
    $.get("<?=BASE_URL('ajaxs/admin/modal/xu-edit.php?id=');?>" + id, function(data) {
        $("#modalViewEdit").html(data);
    });
    $('#OpenModal').modal('show')
}
</script>
<script>
function modalView(id) {
    $("#modalViewEdit").html('');
    $.get("<?=BASE_URL('ajaxs/admin/modal/xu-view.php?id=');?>" + id, function(data) {
        $("#modalViewEdit").html(data);
    });
    $('#OpenModal').modal('show')
}
</script>


<script type="text/javascript">

function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/remove.php');?>",
        type: 'POST',
        dataType: "JSON",
        data: {
            action: 'order_tds_ttc',
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
        title: "CẢNH BÁO",
        message: "Bạn có chắc chắn muốn xóa dữ liệu ID " + id + " không ?",
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
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}
</script>
<script>
$(function() {
    bsCustomFileInput.init();
});
</script>