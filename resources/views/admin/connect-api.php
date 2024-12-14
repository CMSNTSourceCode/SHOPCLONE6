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
                <section class="col-lg-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-info"></i> Thật tuyệt vời!</h5>
                        Từ giờ bạn có thể tuỳ chỉnh chiết khấu tự động và tự động đổi tên sản phẩm từng API
                    </div>
                </section>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Lợi nhuận API toàn thời gian</span>
                                    <span
                                        class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 ")['SUM(`pay`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 ")['SUM(`cost`)']);?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Lợi nhuận API tháng <?=date('m', time());?></span>
                                    <span
                                        class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`pay`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`cost`)']);?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Lợi nhuận API trong tuần</span>
                                    <span
                                        class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`pay`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`cost`)']);?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Lợi nhuận API hôm nay</span>
                                    <span
                                        class="info-box-number"><?=format_currency($CMSNT->get_row(" SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`pay`)']-$CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`cost`)']);?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Lợi nhuận API trong tháng <?=date('m', time());?></h3>
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
                                        label: '<?=__('LỢI NHUẬN KẾT NỐI API');?>',
                                        data: [
                                            <?php
                  $data = [];
                  for ($day = 1; $day <= $numOfDays; $day++) {
                      $date = "$year-$month-$day";
                      $loi_nhuan_ngay_chart = $CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND DATE(create_date) = '$date'  ")['SUM(`pay`)'] - $CMSNT->get_row(" SELECT SUM(`cost`) FROM `orders` WHERE `id_connect_api` != 0  AND `fake` = 0 AND DATE(create_date) = '$date' ")['SUM(`cost`)'];
                      $data[$day - 1] = $loi_nhuan_ngay_chart;
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
                                    <label>Trạng thái Chuyên Mục và Sản Phẩm mặc định khi kết nối API</label>
                                    <select class="form-control select2bs4" name="default_api_product_status">
                                        <option
                                            <?= $CMSNT->site('default_api_product_status') == 1 ? 'selected' : ''; ?>
                                            value="1">
                                            Hiển thị
                                        </option>
                                        <option
                                            <?= $CMSNT->site('default_api_product_status') == 0 ? 'selected' : ''; ?>
                                            value="0">
                                            Ẩn
                                        </option>
                                    </select>
                                    <i>Nếu bạn chọn Ẩn, các sản phẩm khi bạn kết nối API mặc định sẽ được ẩn khỏi
                                        website.</i>
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
                                <p>Hướng dẫn sử dụng: <a target="_blank"
                                        href="https://www.cmsnt.co/2022/12/shopclone6-huong-dan-su-dung-tinh-nang.html">https://www.cmsnt.co/2022/12/shopclone6-huong-dan-su-dung-tinh-nang.html</a>
                                </p>
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
                                                <a class="btn-sm btn btn-info"
                                                    href="<?=base_url('index.php?module=admin&action=connect-api-edit&id='.$row['id']);?>"
                                                    type="button">
                                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </a>
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
      
<style>
    .brand-carousel {
        width: 100%;
        overflow: hidden;
        animation: moveCards 25s linear infinite;
        white-space: nowrap;
    }
        .brand-carousel-container {
        width: 100%;
        overflow-x: auto;
    }

    .brand-carousel {
        white-space: nowrap;
        font-size: 0;
        width: max-content; /* Đảm bảo rằng .brand-carousel có đủ rộng để chứa tất cả các .brand-card trên cùng một hàng */
    }

    .brand-card {
        font-size: 16px;
        display: inline-block;
        vertical-align: top;
        margin-right: 20px;
    }

/* Các phần còn lại giữ nguyên */

    .brand-carousel:hover {
        animation-play-state: paused;
    }
    @keyframes moveCards {
        0% {
            transform: translateX(0%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .brand-card {
        position: relative;
        display: inline-block;
        margin: 10px;
        vertical-align: middle;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
    .brand-card img {
        width: 100px;
    }
    .connect-button,
    .website-button {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #007bff;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .brand-card:hover .connect-button,
    .brand-card:hover .website-button {
        opacity: 1;
    }
    .website-button {
        bottom: 40px;
    }
    </style>
    <div class="row justify-content-center py-3">
        <center>
        <h5><i class="fa-solid fa-rss"></i> Nhà cung cấp gợi ý</h5>
        </center>
        <div class="brand-carousel-container">
        <div class="brand-carousel animated-carousel">

        </div>
        </div>
        <p id="notitcation_suppliers"></p>
    </div>
    <script>
        $(document).ready(function () {
            $('.brand-carousel').html('');
            $.ajax({
                url: 'https://api.cmsnt.co/suppliers.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    // Xử lý dữ liệu trả về từ server
                    if (response && response.suppliers.length > 0) {
                        var html = '';
                        $.each(response.suppliers, function (index, brand) {
                            html += '<div class="brand-card">';
                            html += '<img src="' + brand.logo + '" alt="Logo">';
                            html += '<a href="<?=base_url_admin("connect-api-add");?>&domain='+ brand.domain +'&type='+ brand.type +'" class="connect-button btn btn-sm btn-danger">Kết nối</a>';
                            html += '<a href="' + brand.domain + '?utm_source=ads_cmsnt" target="_blank" class="website-button btn btn-sm btn-primary">Xem</a>';
                            html += '</div>';
                        });
                        $('.brand-carousel').html(html);
                        $('#notitcation_suppliers').html(response.notication);
                        calculateAndSetAnimationDuration();
                    } else {
                        $('.brand-carousel').html('');
                    }
                },
                error: function () {
                    $('.brand-carousel').html('');
                }
            });
        });
        // Function to calculate carousel width and set animation duration
        function calculateAndSetAnimationDuration() {
            var carousel = $('.animated-carousel');
            var carouselWidth = carousel[0].scrollWidth;
            var cardWidth = carousel.children().first().outerWidth(true); // Including margin
            var numberOfCards = carouselWidth / cardWidth;
            var animationDuration = numberOfCards * 2; // Adjust this multiplier as needed
            carousel.css('animation-duration', animationDuration + 's');
        }
    </script>
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