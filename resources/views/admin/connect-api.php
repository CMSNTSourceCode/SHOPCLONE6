<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Quản lý website API',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
    $(function () {
      bsCustomFileInput.init();
    });
    </script> 
    <!-- DataTables  & Plugins -->
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/jszip/jszip.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/pdfmake/vfs_fonts.js"></script>   
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="' . BASE_URL('public/AdminLTE3/') . 'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';
require_once(__DIR__ . '/../../../models/is_admin.php');
require_once(__DIR__ . '/header.php');
require_once(__DIR__ . '/sidebar.php');
require_once(__DIR__ . '/nav.php');
require_once(__DIR__ . '/../../../models/is_license.php');
?>
<?php

if (isset($_POST['SaveSettings'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    foreach ($_POST as $key => $value) {
        $CMSNT->update("settings", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý website API</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL('admin/'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý website API</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lợi nhuận API toàn thời gian</span>
                            <span class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 ")['SUM(`pay`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 ")['SUM(`cost`)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lợi nhuận API tháng <?=date('m', time());?></span>
                            <span class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`pay`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`cost`)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lợi nhuận API trong tuần</span>
                            <span class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`pay`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`cost`)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lợi nhuận API hôm nay</span>
                            <span class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`pay`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`cost`)']);?></span>
                        </div>
                    </div>
                </div>
                <section class="col-lg-12">
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẤU HÌNH
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
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status_connect_api">
                                        <option <?= $CMSNT->site('status_connect_api') == 1 ? 'selected' : ''; ?>
                                            value="1">
                                            ON
                                        </option>
                                        <option <?= $CMSNT->site('status_connect_api') == 0 ? 'selected' : ''; ?>
                                            value="0">
                                            OFF
                                        </option>
                                    </select>
                                    <i>ON/OFF chức năng kết nối sản phẩm API.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tự động cập nhật giá</label>
                                    <input class="form-control" type="text"
                                        placeholder="Vui lòng nhập chiết khấu cập nhật giá tự động, để số 0 để tắt chức năng này"
                                        value="<?= $CMSNT->site('ck_connect_api'); ?>" name="ck_connect_api" />
                                    <i>Hệ thống sẽ tự động tăng giá sản phẩm API lên
                                        <?= $CMSNT->site('ck_connect_api'); ?>%, để 0 nếu muốn tắt chức năng cập nhật
                                        giá tự động.</i>
                                </div>
                                <div class="form-group">
                                    <label>Tự động cập nhật tên sản phẩm</label>
                                    <select class="form-control select2bs4" name="auto_rename_api">
                                        <option <?= $CMSNT->site('auto_rename_api') == 1 ? 'selected' : ''; ?>
                                            value="1">
                                            CÓ
                                        </option>
                                        <option <?= $CMSNT->site('auto_rename_api') == 0 ? 'selected' : ''; ?>
                                            value="0">
                                            KHÔNG
                                        </option>
                                    </select>
                                    <i>Nếu bạn chọn có, hệ thống sẽ tự động cập nhật tên sản phẩm và mô tả
                                            sản phẩm theo API (vui lòng tắt nếu bạn muốn rename tên sản phẩm theo yêu
                                            cầu).</i>
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái Chuyên Mục và Sản Phẩm mặc định khi kết nối API</label>
                                    <select class="form-control select2bs4" name="default_api_product_status">
                                        <option <?= $CMSNT->site('default_api_product_status') == 1 ? 'selected' : ''; ?>
                                            value="1">
                                            Hiển thị
                                        </option>
                                        <option <?= $CMSNT->site('default_api_product_status') == 0 ? 'selected' : ''; ?>
                                            value="0">
                                            Ẩn
                                        </option>
                                    </select>
                                    <i>Nếu bạn chọn Ẩn, các sản phẩm khi bạn kết nối API mặc định sẽ được ẩn khỏi website.</i>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-question-circle mr-1"></i>
                                LƯU Ý
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
                                Một số lưu ý khi dùng chức năng kết nối API của SHOPCLONE6<br>
                                - Thông tin đăng nhập API phải là link web, tài khoản, mật khẩu.<br>
                                - Phải nạp sẵn số dư vào web API để hệ thống thực hiện mua tài khoản tự động.<br>
                                - Khi tạo sản phẩm sẽ có 1 số sản phẩm bị lỗi ảnh, bn chỉ cần vào chuyên mục up ảnh khác
                                hoặc edit sản phẩm đó về chuyên mục có sẵn của web luôn, khỏi phải dùng chuyên mục của
                                API.<br>
                                - Nếu bạn chỉ cần đấu 1 số sản phẩm của 1 API, bn có thể dùng chức năng ẩn sản phẩm để
                                ẩn đi các sản phẩm không cần đấu của API đó, không được dùng chức năng xoá sản phẩm vì
                                khi xoá hệ thống sẽ tự thêm lại.<br>
                                - Nếu bạn muốn xoá hết sản phẩm của 1 API, bn dùng chức năng Ẩn API sau đó vào xoá sản
                                phẩm của API đó.<br>
                                - Nếu muốn chỉnh giá cho từng sản phẩm bằng tay thì điều chỉnh 'Tự động cập nhật giá'
                                bằng 0.<br>
                                - Nếu bạn kết nối thành công nhưng hơn 5p mà hệ thống chưa hiện sản phẩm của API đó, vui
                                lòng kiểm tra lại CRON hoặc inbox cho Admin CMSNT để được hỗ trợ.<br>
                                - Chức năng chỉ hỗ trợ cho website sử dụng mã nguồn của CMSNT, SHOPCLONE5, SHOPCLONE6 và
                                1 số website Thiết Kế Riêng sử dụng bô API chung.<br>
                            </div>

                        </form>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-6 text-right">
                    <div class="mb-3">
                        <a class="btn btn-primary btn-icon-left m-b-10" href="<?= BASE_URL('admin/connect-api-add'); ?>"
                            type="button"><i class="fas fa-plus-circle mr-1"></i>THÊM WEBSITE API</a>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-network-wired mr-1"></i>
                                DANH SÁCH API
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
                                            <th>Domain</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th style="width: 20%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        foreach ($CMSNT->get_list("SELECT * FROM `connect_api` ") as $row) { ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td>
                                                <b><?= $row['domain']; ?></b>
                                            </td>
                                            <td>
                                                <b><?= $row['username']; ?></b>
                                            </td>
                                            <td>
                                                <b><?= substr($row['password'], 0, 4); ?>*****</b>
                                            </td>
                                            <td>
                                                <?= check_string($row['price']); ?>
                                            </td>
                                            <td>
                                                <b><?= display_status_product($row['status']); ?></b>
                                            </td>
                                            <td>
                                                <button class="edit-charging-btn btn-sm btn btn-info"
                                                    data-id="<?= $row['id']; ?>" type="button">
                                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </button>
                                                <button style="color:white;" onclick="RemoveRow('<?= $row['id']; ?>')"
                                                    class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
require_once(__DIR__ . '/footer.php');
?>

<div class="modal fade" id="ChargingModal" tabindex="-1" role="dialog" aria-labelledby="ChargingModal"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="CharigngAjaxContent"></div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $(".edit-charging-btn").click(function() {
        var id = $(this).attr('data-id');
        $("#CharigngAjaxContent").html('');
        $.get("<?= BASE_URL('ajaxs/admin/modal/connect-api-edit.php?id='); ?>" + id, function(data) {
            $("#CharigngAjaxContent").html(data);
        });
        $("#ChargingModal").modal();
    });
});
</script>


<script type="text/javascript">
function postRemove(id) {
    $.ajax({
        url: "<?= BASE_URL("ajaxs/admin/remove.php"); ?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'removeConnectAPI',
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

function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác nhận xoá item",
        message: "Hệ thống sẽ xoá chuyên mục và sản phẩm của API này nếu bạn xoá API này đi",
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