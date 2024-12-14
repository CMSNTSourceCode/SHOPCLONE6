<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Dashboard',
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


function where_not_admin($type){
    global $CMSNT;
    $where_not_admin = "";
    foreach ($CMSNT->get_list("SELECT * FROM `users` WHERE `admin` = 1 ") as $qw) {
        $where_not_admin .= " `$type` != '".$qw['id']."' AND";
    }
    return $where_not_admin;
}

$yesterday = date('Y-m-d', strtotime("-1 day")); // hôm qua
$currentWeek = date("W");
$currentMonth = date('m');
$currentYear = date('Y');
$currentDate = date("Y-m-d");


?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?=base_url_admin('addons');?>" type="button"
                                class="btn btn-primary"><i class="fas fa-puzzle-piece mr-1"></i>CỬA HÀNG ADDONS</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h5>Gửi quý khách hàng của <b>CMSNT</b></h5>
                <ul>
                    <li>Quý khách vui lòng tham gia nhóm Zalo của CMSNT để nắm bắt thông tin cập nhật chi tiết của sản
                        phẩm, luôn luôn nhận được các thông báo mới nhất về CMSNT để tối ưu nhất trong quá trình hoạt
                        động.</li>
                        <li>Nhóm Zalo: <?=$CMSNT->site('status_demo') == 1 ? '<strong>chỉ áp dụng khi mua website chính hãng tại CMSNT</strong>' : '<a class="text-primary" href="https://zalo.me/g/idapcx933" target="_blank">[CMSNT]
                        Changelog - Notification</a>';?></li>
                <li>Nhóm Zalo: <?=$CMSNT->site('status_demo') == 1 ? '<strong>chỉ áp dụng khi mua website chính hãng tại CMSNT</strong>' : '<a class="text-primary" href="https://zalo.me/g/eululb377" target="_blank">[CMSNT] Trao
                        đổi API - Suppliers</a>';?></li>
                <li>Nhóm Telegram: <?=$CMSNT->site('status_demo') == 1 ? '<strong>chỉ áp dụng khi mua website chính hãng tại CMSNT</strong>' : '<a class="text-primary" href="https://t.me/+LVON7y2BKWU3ZDY9" target="_blank">[CMSNT]
                        Tìm kiếm API - Suppliers</a>';?></li>
                <li>Kênh Telegram: <?=$CMSNT->site('status_demo') == 1 ? '<strong>chỉ áp dụng khi mua website chính hãng tại CMSNT</strong>' : '<a class="text-primary" href="https://t.me/cmsntco" target="_blank">[CMSNT] Changelog - Notification</a>';?></li>
                    <li>Inbox ngay cho CMSNT để được duyệt tham gia nhóm Zalo, chỉ áp dụng cho quý khách hàng mua chính
                        chủ
                        tại <a target="_blank" href="https://cmsnt.vn/">CMSNT.CO - CMSNT.VN</a></li>
                    <li>Chúng tôi chấm dứt hỗ trợ nếu phát hiện bạn crack mã nguồn, addon của chúng tôi để dùng lậu nó.
                    </li>
                </ul>
            </div>
            <div class="alert alert-dark">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <b>Phiên bản hiện tại: <span style="color: yellow;font-size:25px;"><?=$config['version'];?></span></b>
                <ul>
                    <li>Chi tiết cập nhật vui lòng xem tại <a target="_blank" href="https://zalo.me/g/idapcx933">đây</a>
                        (chỉ áp dụng cho khách hàng mua chính hãng tại CMSNT.CO)</li>
                </ul>
                <i>Hệ thống tự động cập nhật phiên bản mới nhất khi vào trang Quản Trị.</i>
            </div>
            <?php if($CMSNT->site('reCAPTCHA_status') != 1):?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                Vui lòng cấu hình <b>reCAPTCHA</b> để chống spam và dò password website.<br>
                Cấu hình <b>reCAPTCHA</b> trong cài đặt -> <b>Google reCAPTCHA</b>.
            </div>
            <?php endif?>
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `fake` = 0 ")['COUNT(id)']);?>
                            </h3>
                            <p>Đơn hàng đã bán</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL ")['COUNT(id)']);?>
                            </h3>
                            <p>Tài khoản đã bán</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` ")['COUNT(id)']);?></h3>
                            <p>Tổng thành viên</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?=base_url_admin('users');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 ")['SUM(`pay`)']);?>
                            </h3>
                            <p>Doanh thu đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê tháng <?=date('m', time());?></h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê tuần</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND YEAR(create_date) = $currentYear AND WEEK(create_date, 1) = $currentWeek ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND YEAR(update_date) = $currentYear AND WEEK(update_date, 1) = $currentWeek ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê hôm nay</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND `create_date` LIKE '%".date("Y-m-d")."%' ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND `update_date` LIKE '%".date("Y-m-d")."%' ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE `create_date` LIKE '%".date("Y-m-d")."%' ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Tổng tiền nạp toàn thời gian</span>
                                            <span class="info-box-number"><?=format_currency(
    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` ")['SUM(`price`)']+
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` ")['SUM(amount)']+
                                    ($CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `status` = 'completed' ")['SUM(amount)'] * $CMSNT->site('rate_crypto'))
);?></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 col-sm-3 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i
                                                class="far fa-money-bill-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Tổng tiền nạp tháng
                                                <?=date('m', time());?></span>
                                            <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`pay`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE  YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`price`)']
                                +
                                $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(amount)'] 
                                +
                                ($CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `status` = 'completed' AND MONTH(create_gettime) = '$currentMonth' AND YEAR(create_gettime) = '$currentYear' ")['SUM(amount)'] * $CMSNT->site('rate_crypto')) 
                                
                                );?></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 col-sm-3 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i
                                                class="far fa-money-bill-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Tổng tiền nạp tuần</span>
                                            <span class="info-box-number"><?=format_currency(
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND YEAR(update_date) = $currentYear AND WEEK(update_date, 1) = $currentWeek ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND YEAR(update_date) = $currentYear AND WEEK(update_date, 1) = $currentWeek ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND YEAR(update_date) = $currentYear AND WEEK(update_date, 1) = $currentWeek ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE YEAR(create_date) = $currentYear AND WEEK(create_date, 1) = $currentWeek ")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE YEAR(create_gettime) = $currentYear AND WEEK(create_gettime, 1) = $currentWeek ")['SUM(amount)']
                                    +
                                    ($CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `status` = 'completed' AND YEAR(create_gettime) = $currentYear AND WEEK(create_gettime, 1) = $currentWeek ")['SUM(amount)'] * $CMSNT->site('rate_crypto')) 
                                );?></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 col-sm-3 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i
                                                class="far fa-money-bill-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Tổng tiền nạp hôm nay</span>
                                            <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND `update_date` LIKE '%".date("Y-m-d")."%' ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND `update_date` LIKE '%".date("Y-m-d")."%'")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND `update_date` LIKE '%".date("Y-m-d")."%'")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `create_date` LIKE '%".date("Y-m-d")."%'")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `create_gettime` LIKE '%".date("Y-m-d")."%' ")['SUM(amount)']
                                    +
                                    ($CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `status` = 'completed' AND `create_gettime` LIKE '%".date("Y-m-d")."%' ")['SUM(amount)'] * $CMSNT->site('rate_crypto'))
                                    );?></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Doanh thu trong tháng <?=date('m', time());?></h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart"></canvas>
                                    <script>
                                    function formatCurrency(value) {
                                        return value.toLocaleString('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND'
                                        });
                                    }
                                    var ctx = document.getElementById('myChart').getContext('2d');
                                    var myChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: [
                                                <?php
              $month = date('m');
              $year = date('Y');
              $numOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

              for ($day = 1; $day <= $numOfDays; $day++) {
                  echo "\"$day/$month/$year\",";
              }
              ?>
                                            ],
                                            datasets: [{
                                                label: '<?=__('DOANH THU ĐƠN HÀNG');?>',
                                                data: [
                                                    <?php
                  $data = [];
                  for ($day = 1; $day <= $numOfDays; $day++) {
                      $date = "$year-$month-$day";
                      $row = $CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND DATE(create_date) = '$date'  ");
                      $data[$day - 1] = $row['SUM(`pay`)'];
                  }
                  for ($i = 0; $i < $numOfDays; $i++) {
                      echo "$data[$i],";
                  }
                  ?>
                                                ],
                                                backgroundColor: [
                                                    'rgb(255 239 201)'
                                                ],
                                                borderColor: [
                                                    'rgb(255 193 5)'
                                                ],
                                                borderWidth: 1
                                            }, ]
                                        },
                                        options: {
                                            tooltips: {
                                                callbacks: {
                                                    label: function(tooltipItem, data) {
                                                        return formatCurrency(tooltipItem.yLabel);
                                                    }
                                                }
                                            },
                                            scales: {
                                                yAxes: [{
                                                    ticks: {
                                                        beginAtZero: true,
                                                        callback: function(value, index, values) {
                                                            return formatCurrency(value);
                                                        }
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                    </script>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Nạp tiền trong tháng <?=date('m', time());?></h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart1"></canvas>
                                    <script>
                                    function formatCurrency(value) {
                                        return value.toLocaleString('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND'
                                        });
                                    }
                                    var ctx = document.getElementById('myChart1').getContext('2d');
                                    var myChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: [
                                                <?php
              $month = date('m');
              $year = date('Y');
              $numOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

              for ($day = 1; $day <= $numOfDays; $day++) {
                  echo "\"$day/$month/$year\",";
              }
              ?>
                                            ],
                                            datasets: [{
                                                label: '<?=__('TIỀN NẠP TRONG THÁNG');?>',
                                                data: [
                                                    <?php
                  $data = [];
                  for ($day = 1; $day <= $numOfDays; $day++) {
                      $date = "$year-$month-$day";

                      $total_pm_chart1 = $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND DATE(update_date) = '$date' ")['SUM(`price`)'];
                      $total_invoice_chart1 = $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND DATE(update_date) = '$date' ")['SUM(`pay`)'];
                      $total_card_chart1 = $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND DATE(update_date) = '$date' ")['SUM(`price`)'];
                      $total_paypal_chart1 = $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE DATE(create_date) = '$date' ")['SUM(`price`)'];
                      $total_bank2_chart1 = $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE DATE(create_gettime) = '$date' ")['SUM(amount)'];
                      $total_crypto_chart1 = $CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `status` = 'completed' AND DATE(create_gettime) = '$date' ")['SUM(amount)'] * $CMSNT->site('rate_crypto');
                      $total_chart1 = $total_pm_chart1 + $total_invoice_chart1 + $total_card_chart1 + $total_paypal_chart1 + $total_bank2_chart1 + $total_crypto_chart1;
                      $data[$day - 1] = $total_chart1;
                  }
                  for ($i = 0; $i < $numOfDays; $i++) {
                      echo "$data[$i],";
                  }
                  ?>
                                                ],
                                                backgroundColor: [
                                                    'rgb(255 239 201)'
                                                ],
                                                borderColor: [
                                                    'rgb(255 193 5)'
                                                ],
                                                borderWidth: 1
                                            }, ]
                                        },
                                        options: {
                                            tooltips: {
                                                callbacks: {
                                                    label: function(tooltipItem, data) {
                                                        return formatCurrency(tooltipItem.yLabel);
                                                    }
                                                }
                                            },
                                            scales: {
                                                yAxes: [{
                                                    ticks: {
                                                        beginAtZero: true,
                                                        callback: function(value, index, values) {
                                                            return formatCurrency(value);
                                                        }
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                    </script>
                                </div>

                            </div>
                        </div>
                    </div>



                    <section class="col-lg-12 connectedSortable">
                        <div class="card card-primary card-outline">
                            <div class="card-header ">
                                <h3 class="card-title">
                                    <i class="fas fa-history mr-1"></i>
                                    200 GIAO DỊCH GẦN ĐÂY (<i>Ẩn dòng tiền của Admin</i>)
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
                                    <table id="datatable1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>Username</th>
                                                <th>Số tiền trước</th>
                                                <th>Số tiền thay đổi</th>
                                                <th>Số tiền hiện tại</th>
                                                <th>Thời gian</th>
                                                <th>Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE ".where_not_admin('user_id')." `id` > 0 ORDER BY id DESC LIMIT 200 ") as $row) {?>
                                            <tr>
                                                <td class="text-center"><?=$i++;?></td>
                                                <td class="text-center"><a
                                                        href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                                </td>
                                                <td class="text-center"><b
                                                        style="color: green;"><?=format_currency($row['sotientruoc']);?></b>
                                                </td>
                                                <td class="text-center"><b
                                                        style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b>
                                                </td>
                                                <td class="text-center"><b
                                                        style="color: blue;"><?=format_currency($row['sotiensau']);?></b>
                                                </td>
                                                <td class="text-center"><i><?=$row['thoigian'];?></i></td>
                                                <td><i><?=$row['noidung'];?></i></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end align-items-center border-top-table p-2">
                                    <a type="button" href="<?=base_url_admin('dong-tien');?>"
                                        class="btn btn-primary">Xem
                                        Thêm <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-12 connectedSortable">
                        <div class="card card-primary card-outline">
                            <div class="card-header ">
                                <h3 class="card-title">
                                    <i class="fas fa-history mr-1"></i>
                                    200 NHẬT KÝ HOẠT ĐỘNG GẦN ĐÂY (<i>Ẩn nhật ký của Admin</i>)
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
                                    <table id="datatable2" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>Username</th>
                                                <th width="40%">Action</th>
                                                <th>Time</th>
                                                <th>Ip</th>
                                                <th width="30%">Device</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE ".where_not_admin('user_id')." `id` > 0 ORDER BY id DESC LIMIT 200 ") as $row) {?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td class="text-center"><a
                                                        href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                                </td>
                                                <td><?=$row['action'];?></td>
                                                <td><?=$row['createdate'];?></td>
                                                <td><?=$row['ip'];?></td>
                                                <td><?=$row['device'];?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end align-items-center border-top-table p-2">
                                    <a type="button" href="<?=base_url_admin('logs');?>" class="btn btn-primary">Xem
                                        Thêm <i class="fas fa-arrow-circle-right"></i></a>
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