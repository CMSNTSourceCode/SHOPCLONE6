<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Đơn hàng mua tương tác',
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
                    <h1 class="m-0">Đơn hàng mua tương tác</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Đơn hàng mua tương tác</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-check-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Doanh thu toàn thời gian</span>
                            <span
                                class="info-box-number"><?=format_currency($CMSNT->get_row("SELECT SUM(payment) FROM `order_autofb` WHERE `status` != 2  ")['SUM(payment)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Lợi nhuận toàn thời gian</span>
                            <span
                                class="info-box-number"><?=format_currency($CMSNT->get_row("SELECT SUM(payment_api) FROM `order_autofb` WHERE `status` != 2  ")['SUM(payment_api)'] - $CMSNT->get_row("SELECT SUM(payment) FROM `order_autofb` WHERE `status` != 2  ")['SUM(payment)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-spinner"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Đơn hàng đang chạy</span>
                            <span
                                class="info-box-number"><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `order_autofb` WHERE `status` = 0 ")['COUNT(id)']);?>
                                đơn</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-ban"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Đơn hàng bị huỷ</span>
                            <span
                                class="info-box-number"><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `order_autofb` WHERE `status` = 2 ")['COUNT(id)']);?>
                                đơn</span>
                        </div>
                    </div>
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                DANH SÁCH ĐƠN MUA TƯƠNG TÁC
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
                                    <button onclick="loadForm()" id="loadform" type="button"
                                        class="btn btn-primary btn-sm"><i class="fas fa-cloud-download-alt"></i> CẬP
                                        NHẬT ĐƠN HÀNG API</button>
                                </div>
                                <div class="col-sm-6">

                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th><?=__('Khách hàng');?></th>
                                            <th><?=__('Đơn hàng');?></th>
                                            <th><?=__('Tổng tiền');?></th>
                                            <th><?=__('Thời gian');?></th>
                                            <th><?=__('Trạng thái');?></th>
                                            <th><?=__('Ghi chú');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `order_autofb`  ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td>
                                                <ul>
                                                    <li>Username: <b><a
                                                                href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getRowRealtime("users", $row['user_id'], "username");?></a>
                                                            (<?=__($row['user_id']);?>)</b></li>
                                                    <li>Money: <b style="color: red;"><?=format_currency(getRowRealtime("users", $row['user_id'], "money"));?></b></li>        
                                                    <li>Total money: <b><?=format_currency(getRowRealtime("users", $row['user_id'], "total_money"));?></b></li>
                                                    <li>Email: <b><?=getRowRealtime("users", $row['user_id'], "email");?></b></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>TransID: <b>#<?=$row['trans_id'];?></b> - Số lượng: <b
                                                            style="color:blue;"><?=format_cash($row['quantity']);?></b>
                                                        - Đã chạy: <b
                                                            style="color:green;"><?=format_cash($row['count_success']);?></b>
                                                    </li>
                                                    <li>Dịch vụ:
                                                        <b><?=__(getRowRealtime("rate_autofb", $row['id_rate_autofb'], 'name_loaiseeding'));?></b>
                                                    </li>
                                                    <li>Server: <b style="color: green;"><?=$row['type'];?></b></li>
                                                    <li>ID Seeding: <b><?=$row['uid'];?></b></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Thanh toán của khách: <b
                                                            style="color:red;"><?=format_currency($row['payment']);?></b>
                                                    </li>
                                                    <li>Thanh toán bên API: <b
                                                            style="color:blue;"><?=format_currency($row['payment_api']);?></b>
                                                    </li>
                                                    <li>Lợi nhuận: <b
                                                            style="color:green;"><?=format_currency($row['payment_api'] - $row['payment']);?></b>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td><i><?=$row['create_gettime'];?></i></td>
                                            <td><?=display_autofb($row['status']);?></td>
                                            <td><textarea rows="1" class="form-control"
                                                    readonly><?=$row['note'];?></textarea></td>
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



<div id="autofb"></div>
<script>
function loadForm() {
    $('#loadform').html('<i class="fa fa-spinner fa-spin"></i> ĐANG CẬP NHẬT KẾT QUẢ TỪ API, VUI LÒNG CHỜ').prop('disabled', true);
    $('#autofb').load('<?=base_url('cron/autofb.php?type=buffsub-sale');?>');
    $('#autofb').load('<?=base_url('cron/autofb.php?type=buffsub-speed');?>');
    $('#autofb').load('<?=base_url('cron/autofb.php?type=buffsub-slow');?>');
    $('#autofb').load('<?=base_url('cron/autofb.php?type=bufflikefanpagesale');?>');
    $('#autofb').load('<?=base_url('cron/autofb.php?type=bufflikefanpage');?>');
    $('#autofb').load('<?=base_url('cron/autofb.php?type=buffsubfanpage');?>');
    $('#autofb').load('<?=base_url('cron/autofb.php?type=bufflikecommentsharelike');?>');
    $('#autofb').load('<?=base_url('cron/autofb.php?type=bufflikecommentshareshare');?>');
    $('#autofb').load('<?=base_url('cron/autofb.php?type=buffviewstory');?>');
    $.ajax({
        url: "<?=base_url('cron/autofb.php');?>",
        method: "GET",
        data: {
            type: 'buffviewstory'
        },
        success: function(respone) {
            $('#loadform').html('<i class="fas fa-cloud-download-alt"></i> CẬP NHẬT ĐƠN HÀNG API')
                .prop('disabled', false);
        }
    });
}
$(function() {
    $('#datatable').DataTable();
});
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "Đã sao chép vào bộ nhớ tạm",
        timer: 5000
    });
}
</script>