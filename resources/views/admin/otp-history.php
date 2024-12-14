<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Lịch sử thuê OTP',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
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
                    <h1 class="m-0">Lịch sử thuê OTP</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Lịch sử thuê OTP</li>
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
                            <span class="info-box-text">Lợi nhuận toàn thời gian</span>
                            <span
                                class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`price`) FROM `otp_history` WHERE `status` = 0   ")['SUM(`price`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `otp_history` WHERE `status` = 0  ")['SUM(`cost`)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lợi nhuận tháng <?=date('m', time());?></span>
                            <span
                                class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`price`) FROM `otp_history` WHERE `status` = 0 AND YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(`price`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `otp_history` WHERE `status` = 0  AND YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(`cost`)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lợi nhuận trong tuần</span>
                            <span
                                class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`price`) FROM `otp_history` WHERE `status` = 0  AND  WEEK(create_gettime, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `otp_history` WHERE `status` = 0  AND WEEK(create_gettime, 1) = WEEK(CURDATE(), 1) ")['SUM(`cost`)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lợi nhuận hôm nay</span>
                            <span
                                class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`price`) FROM `otp_history` WHERE `status` = 0  AND `create_gettime` >= DATE(NOW()) AND `create_gettime` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`price`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `otp_history` WHERE `status` = 0 AND `create_gettime` >= DATE(NOW()) AND `create_gettime` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`cost`)']);?></span>
                        </div>
                    </div>
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                LỊCH SỬ THUÊ OTP
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
                            <div class="table-responsive p-0">
                                <table id="order" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%"><?=__('STT');?></th>
                                            <th width="10%"><?=__('TRANSID');?> / ID API</th>
                                            <th><?=__('Khách hàng');?></th>
                                            <th><?=__('Tên ứng dụng');?></th>
                                            <th><?=__('Số điện thoại');?></th>
                                            <th><?=__('Code');?></th>
                                            <th><?=__('Tin nhắn');?></th>
                                            <th><?=__('Trạng thái');?></th>
                                            <th><?=__('Price');?></th>
                                            <th><?=__('Cost');?></th>
                                            <th><?=__('Thời gian');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `otp_history`  ORDER BY id DESC  ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$row['transid'];?> / <?=$row['id_order_api'];?></td>
                                            <td><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getRowRealtime("users", $row['user_id'], "username");?></a>
                                            </td>
                                            <td><b><?=$row['app'];?></b></td>
                                            <td><span id="copySDT<?=$row['id'];?>"><?=$row['number'];?></span> <button
                                                    onclick="copy()" data-clipboard-target="#copySDT<?=$row['id'];?>"
                                                    class="copy btn btn-primary btn-sm"><i
                                                        class="fas fa-copy"></i></button>
                                            </td>
                                            <td><span id="copyCODE<?=$row['id'];?>"><?=$row['code'];?></span>
                                                <?php if($row['code'] != ''):?><button onclick="copy()"
                                                    data-clipboard-target="#copyCODE<?=$row['id'];?>"
                                                    class="copy btn btn-primary btn-sm"><i
                                                        class="fas fa-copy"></i></button><?php endif?></td>
                                            <td><?=$row['sms'];?></td>
                                            <td><?=display_otp_service($row['status']);?></td>
                                            <td><b style="color: red;"><?=format_cash($row['price']);?>đ</b></td>
                                            <td><b style="color: blue;"><?=format_cash($row['cost']);?>đ</b></td>
                                            <td><?=$row['create_gettime'];?></td>

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
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}

$(function() {
    $('#order').DataTable({
        order: [
            [7, "desc"]
        ]
    });
});
</script>
<?php
require_once(__DIR__.'/footer.php');
?>