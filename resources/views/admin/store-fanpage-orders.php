<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Đơn hàng mua Fanpage/Group',
    'desc'   => '',
    'keyword' => ''
];
$body['header'] = '
    <!-- ckeditor -->
    <script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- bs-custom-file-input -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Page specific script -->
    <script>
    $(function () {
    bsCustomFileInput.init();
    });
    </script> 
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
                    <h1 class="m-0">Đơn hàng mua Fanpage/Group</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Đơn hàng mua Fanpage/Group</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                    <div class="mb-3">
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/store-fanpage');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th-list mr-1"></i>
                                ĐƠN HÀNG MUA FANPAGE/GROUP
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
                            <div class="table-responsive">

                                <table id="datatable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5px;">#</th>
                                            <th>Người bán</th>
                                            <th>Người mua</th>
                                            <th>Fanpage/Group</th>
                                            <th>Chi tiết sản phẩm</th>
                                            <th>Ghi chú đơn hàng</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `store_fanpage` WHERE `buyer` != 0 ORDER BY `update_gettime` DESC ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td>
                                                <ul>
                                                    <li>Username: <b><a
                                                                href="<?=base_url('admin/user-edit/'.$row['seller']);?>"><?=getRowRealtime("users", $row['seller'], "username");?></a>
                                                            (<?=__($row['seller']);?>)</b></li>
                                                    <li>Money: <b style="color: red;"><?=format_currency(getRowRealtime("users", $row['seller'], "money"));?></b></li>              
                                                    <li>Total money: <b><?=format_currency(getRowRealtime("users", $row['seller'], "total_money"));?></b></li>
                                                    <li>Email: <b><?=getRowRealtime("users", $row['seller'], "email");?></b></li>
                                                </ul>
                                            </td>
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
                                                <a href="https://www.facebook.com/<?=$row['uid'];?>" target="_blank" class="d-block">
                                                    <img src="<?=base_url($row['icon']);?>" width="50px" height="50px"
                                                        class="img-circle elevation-2 mr-2"
                                                        alt="<?=$row['name'];?><"><b>
                                                        <?=$row['name'];?></b></a>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Loại: <b><?=$row['type'];?></b></li>
                                                    <li>Số lượng Like/Member: <b><?=format_cash($row['sl_like']);?></b></li>
                                                    <li>Thời gian tạo: <b><?=$row['nam_tao_fanpage'];?></b></li>
                                                    <li>Giá: <b style="color: blue;"><?=format_currency($row['price']);?></b></li>
                                                    <li>FB Admin mới: <a href="<?=$row['url'];?>" target="_blank"><?=$row['url'];?></a></li>
                                                    <li>Tên Fanpage cần thay đổi: <b><?=$row['new_name'];?></b></li>
                                                    <li>Thời gian bán: <b><?=$row['update_gettime'];?></b>
                                                        (<b><?=timeAgo($row['update_time']);?></b>)</li>
                                                </ul>
                                            </td>
                                            <td><textarea id="note<?=$row['id'];?>" onchange="updateForm(`<?=$row['id'];?>`)" placeholder="Nhập ghi chú đơn hàng cho người mua thấy nếu có"
                                                class="form-control" rows="5"><?=$row['note'];?></textarea></td>
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

<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/update.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'changeStoreFanpage',
            id: id,
            note: $("#note" + id).val()
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

function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Fanpage/Group",
        message: "Bạn có chắc chắn muốn xóa Fanpage/Group ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/remove.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    action: 'removeStoreFanpage'
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

 

<?php
require_once(__DIR__.'/footer.php');
?>