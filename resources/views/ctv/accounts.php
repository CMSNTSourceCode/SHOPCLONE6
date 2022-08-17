<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Quản lý tài khoản',
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
require_once(__DIR__.'/../../../models/is_ctv.php');
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `products` WHERE `id` = '$id' AND `user_id` = '".$getUser['id']."' ");
    if (!$row) {
        redirect(base_url('ctv/product-list'));
    }
} else {
    redirect(base_url('ctv/product-list'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['AddAccounts']) && isset($_POST['listAccount'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $value_add = 0;
    $value_update = 0;
    $list = check_string($_POST['listAccount']);
    $list = explode(PHP_EOL, $list);
    foreach ($list as $clone) {
        if ($CMSNT->num_rows(" SELECT * FROM `accounts` WHERE `account` = '$clone' AND `seller` = '".$getUser['id']."' ") == 0) {
            $isAdd = $CMSNT->insert("accounts", [
                'product_id'    => $row['id'],
                'seller'        => $getUser['id'],
                'account'       => $clone,
                'status'        => 'LIVE',
                'create_date'   => gettime(),
                'update_date'   => gettime()
            ]);
            if ($isAdd) {
                $value_add++;
            }
        } else {
            $row_taikhoan = $CMSNT->get_row(" SELECT * FROM `accounts` WHERE `account` = '$clone' AND `seller` = '".$getUser['id']."' ");
            if (isset($_POST['filter']) && $_POST['filter'] == 1) {
                $isUpdate = $CMSNT->update("accounts", array(
                    'status' => 'LIVE'
                ), " `id` = '".$row_taikhoan['id']."' ");
                if ($isUpdate) {
                    $value_update++;
                }
            } else {
                $isUpdate = $CMSNT->update("accounts", array(
                    'status' => 'LIVE',
                    'buyer'  => null
                ), " `id` = '".$row_taikhoan['id']."' ");
                if ($isUpdate) {
                    $value_add++;
                }
            }
        }
    }
    die('<script type="text/javascript">if(!alert("Thêm '.$value_add.' | Cập nhật '.$value_update.' thành công")){window.history.back().location.reload();}</script>');
}
if (isset($_POST['RemoveAccounts']) && isset($_POST['listAccount'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $list = check_string($_POST['listAccount']);
    $list = explode(PHP_EOL, $list);
    $value_delete = 0;
    foreach ($list as $clone) {
        // xoá tài khoản đã bán
        if (isset($_POST['filter']) && $_POST['filter'] == 1) {
            $isRemove = $CMSNT->remove("accounts", " `account` = '".$clone."' AND `seller` = '".$getUser['id']."' ");
            if ($isRemove) {
                $value_delete++;
            }
        } else {
            $isRemove = $CMSNT->remove("accounts", " `account` = '".$clone."' AND `buyer` IS NULL AND `seller` = '".$getUser['id']."' ");
            if ($isRemove) {
                $value_delete++;
            }
        }
    }
    die('<script type="text/javascript">if(!alert("Xoá thành công '.$value_delete.' tài khoản! ")){window.history.back().location.reload();}</script>');
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý tài khoản</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('ctv/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý tài khoản</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-import mr-1"></i>
                                THÊM TÀI KHOẢN
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
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" class="form-control" value="<?=$row['name'];?>"
                                        placeholder="Nhập tên sản phẩm" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh sách tài khoản</label>
                                    <textarea class="form-control" name="listAccount" rows="5"
                                        placeholder="1 dòng 1 tài khoản"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="filter" value="1"
                                            id="target" checked>
                                        <label for="target" class="custom-control-label">Nếu bạn huỷ tích, hệ thống sẽ
                                            không lọc các tài nguyên đã bán, chỉ nhập tài nguyên chưa bán.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="AddAccounts" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Thêm Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-export mr-1"></i>
                                XOÁ TÀI KHOẢN
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
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" class="form-control" value="<?=$row['name'];?>"
                                        placeholder="Nhập tên sản phẩm" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh sách tài khoản</label>
                                    <textarea class="form-control" name="listAccount" rows="5"
                                        placeholder="1 dòng 1 tài khoản"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="filter" value="1"
                                            id="target" checked>
                                        <label for="target" class="custom-control-label">Xoá tài khoản bao gồm tài khoản đã bán</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="RemoveAccounts" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-trash-alt mr-1"></i>Xoá Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-dolly-flatbed mr-1"></i>
                                DANH SÁCH TÀI KHOẢN
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
                                            <th width="5px;"><input type="checkbox" name="check_all" id="check_all"
                                                    value="option1"></th>
                                            <th>Buyer</th>
                                            <th>Account</th>
                                            <th>Createdate</th>
                                            <th>Updatedate</th>
                                            <th>Status</th>
                                            <th style="width: 20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($CMSNT->get_list("SELECT * FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `seller` = '".$getUser['id']."' ") as $row) {?>
                                        <tr>
                                            <td><input type="checkbox" data-id="<?=$row['id'];?>" name="checkbox"
                                                    class="checkbox" value="<?=$row['id'];?>" /></td>
                                            <td><a href="#"><?=getUser($row['buyer'], 'username');?></a></td>
                                            <td><textarea class="form-control" readonly><?=$row['account'];?></textarea>
                                            </td>
                                            <td><?=$row['create_date'];?></td>
                                            <td><?=$row['update_date'];?></td>
                                            <td><?=display_live($row['status']);?></td>
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
                url: "<?=BASE_URL("ajaxs/ctv/removeAccount.php");?>",
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
        url: "<?=BASE_URL('ajaxs/ctv/removeAccount.php');?>",
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
<script>
$(function() {
    $('#datatable1').DataTable({});
});
</script>