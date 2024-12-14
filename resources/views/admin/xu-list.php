<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
error_reporting(0);
$body = [
    'title' => 'Quản lý xu',
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
$password = '';
$token = '';
$cookie = '';

if(!empty($_GET['username'])){
    $username = check_string($_GET['username']);
    $where .= ' AND `username` LIKE "%'.$username.'%" ';
}
if(!empty($_GET['password'])){
    $password = check_string($_GET['password']);
    $where .= ' AND `password` LIKE "%'.$password.'%" ';
}
if(!empty($_GET['token'])){
    $token = check_string($_GET['token']);
    $where .= ' AND `token` LIKE "%'.$token.'%" ';
}
if(!empty($_GET['cookie'])){
    $cookie = check_string($_GET['cookie']);
    $where .= ' AND `cookie` LIKE "%'.$cookie.'%" ';
}
if(!empty($_GET['server'])){
    $server = check_string($_GET['server']);
    $where .= ' AND `server` = "'.$server.'" ';
}

$listDatatable = $CMSNT->get_list("SELECT * FROM `list_tds_ttc` WHERE $where ORDER BY id DESC LIMIT $from,$limit  ");
$totalDatatable = $CMSNT->num_rows(" SELECT * FROM `list_tds_ttc` WHERE $where ORDER BY id DESC ");
$urlDatatable = pagination(base_url_admin("xu-list&limit=$limit&username=$username&server=$server&password=$password&token=$token&cookie=$cookie&"), $from, $totalDatatable, $limit);



require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý xu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý xu</li>
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
                        <a class="btn btn-primary btn-icon-left m-b-10" href="<?=BASE_URL('admin/xu-add');?>"
                            type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm xu</a>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-dolly-flatbed mr-1"></i>
                                DANH SÁCH XU
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
                                        <input type="hidden" name="action" value="xu-list">
                                        <div class="row">
                                            <input class="form-control col-sm-3 mb-2" value="<?=$username;?>"
                                                name="username" placeholder="Username">
                                            <input class="form-control col-sm-3 mb-2" value="<?=$password;?>"
                                                name="password" placeholder="Password">
                                            <input class="form-control col-sm-3 mb-2" value="<?=$cookie;?>"
                                                name="cookie" placeholder="Cookie">
                                            <input class="form-control col-sm-3 mb-2" value="<?=$token;?>" name="token"
                                                placeholder="Token">
                                            <select class="form-control select2bs4 col-sm-3 mb-2" name="server">
                                                <option value="">Server</option>
                                                <option <?=$server == 'TDS' ? 'selected' : '';?> value="TDS">TDS
                                                </option>
                                                <option <?=$server == 'TTC' ? 'selected' : '';?> value="TTC">TTC
                                                </option>
                                            </select>
                                            <div class="col-sm-4 mb-2">
                                                <button type="submit" name="submit" value="filter"
                                                    class="btn btn-warning"><i class="fa fa-search"></i>
                                                    Tìm kiếm
                                                </button>
                                                <a class="btn btn-danger"
                                                    href="<?=BASE_URL('index.php?module=admin&action=xu-list');?>"><i
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
                                            <th width="5px;"><input type="checkbox" name="check_all" id="check_all"
                                                    value="option1"></th>
                                            <th>Server</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Cookie</th>
                                            <th>Porxy Host</th>
                                            <th>Porxy User</th>
                                            <th>Coin</th>
                                            <th>Chạy trong ngày</th>
                                            <th>Hiển thị</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listDatatable as $row):?>
                                        <tr onchange="updateForm(`<?=$row['id'];?>`)">
                                            <td><input type="checkbox" data-id="<?=$row['id'];?>" name="checkbox"
                                                    class="checkbox" value="<?=$row['id'];?>" /></td>
                                            <td width="10%">
                                                <select class="form-control" id="server<?=$row['id'];?>" required>
                                                    <option <?=$row['server'] == 'TDS' ? 'selected' : '';?> value="TDS">
                                                        TDS</option>
                                                    <option <?=$row['server'] == 'TTC' ? 'selected' : '';?> value="TTC">
                                                        TTC</option>
                                                </select>
                                            </td>
                                            <td><textarea class="form-control" id="username<?=$row['id'];?>"
                                                    rows="1"><?=$row['username'];?></textarea></td>
                                            <td><textarea class="form-control" id="password<?=$row['id'];?>"
                                                    rows="1"><?=$row['password'];?></textarea></td>
                                            <td><textarea class="form-control" id="cookie<?=$row['id'];?>"
                                                    rows="1"><?=$row['cookie'];?></textarea></td>
                                            <td><textarea class="form-control" id="proxy_host<?=$row['id'];?>"
                                                    rows="1"><?=$row['proxy_host'];?></textarea></td>
                                            <td><textarea class="form-control" id="proxy_user<?=$row['id'];?>"
                                                    rows="1"><?=$row['proxy_user'];?></textarea></td>
                                            <td><input class="form-control" value="<?=$row['coin'];?>" id="coin<?=$row['id'];?>"></td>
                                            <td><input class="form-control" value="<?=$row['day_limit'];?>" readonly></td>
                                            <td class="text-center fs-base">
                                                <input class="form-select" type="checkbox" id="status<?=$row['id'];?>"
                                                    value="1" <?=$row['status'] == 1 ? 'checked=""' : '';?>>
                                            </td>
                                            <td>
                                                <button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>')"
                                                    class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
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
function updateForm(id) {
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/update.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'update_list_tds_ttc',
            id: id,
            username: $("#username" + id).val(),
            password: $("#password" + id).val(),
            coin: $("#coin" + id).val(),
            server: $("#server" + id).val(),
            proxy_user: $("#proxy_user" + id).val(),
            proxy_host: $("#proxy_host" + id).val(),
            cookie: $("#cookie" + id).val(),
            status: $('#status' + id + ':checked').val()
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

function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/remove.php');?>",
        type: 'POST',
        dataType: "JSON",
        data: {
            action: 'list_tds_ttc',
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