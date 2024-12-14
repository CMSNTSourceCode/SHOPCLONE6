<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thống kê',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
 
';
$body['footer'] = '
    
';
require_once(__DIR__.'/../../../models/is_admin.php'); // check quyền admin
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_GET['user_id'])) {
    $CMSNT = new DB();
    $id = check_string($_GET['user_id']);
    $user = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '$id' ");
    if(!isset($user)) {
        redirect(base_url_admin());
    }
}else{
    redirect(base_url_admin());
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
                    <h1 class="m-0">Thông kê tài khoản: <?=$user['username'];?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/users');?>">Users</a></li>
                        <li class="breadcrumb-item active">Statistic</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
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
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `user_id` = '$id' AND `status` = 1 AND `fake` = 0 ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `user_id` = '$id' AND `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `user_id` = '$id' ")['SUM(`price`)']+
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `user_id` = '$id' ")['SUM(amount)']+
                                    ($CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `user_id` = '$id' AND `status` = 'completed' ")['SUM(amount)'] * $CMSNT->site('rate_crypto'))
);?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-3 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tổng tiền nạp tháng
                                        <?=date('m', time());?></span>
                                    <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `user_id` = '$id' AND `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `user_id` = '$id' AND `status` = 1 AND `fake` = 0 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`pay`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `user_id` = '$id' AND `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `user_id` = '$id' AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`price`)']
                                +
                                $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `user_id` = '$id' AND YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(amount)'] 
                                +
                                ($CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `user_id` = '$id' AND `status` = 'completed' AND MONTH(create_gettime) = '$currentMonth' AND YEAR(create_gettime) = '$currentYear' ")['SUM(amount)'] * $CMSNT->site('rate_crypto')) 
                                
                                );?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-3 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tổng tiền nạp tuần</span>
                                    <span class="info-box-number"><?=format_currency(
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `user_id` = '$id' AND `status` = 1 AND YEAR(update_date) = $currentYear AND WEEK(update_date, 1) = $currentWeek ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `user_id` = '$id' AND `status` = 1 AND `fake` = 0 AND YEAR(update_date) = $currentYear AND WEEK(update_date, 1) = $currentWeek ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `user_id` = '$id' AND `status` = 1 AND YEAR(update_date) = $currentYear AND WEEK(update_date, 1) = $currentWeek ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `user_id` = '$id' AND YEAR(create_date) = $currentYear AND WEEK(create_date, 1) = $currentWeek ")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `user_id` = '$id' AND YEAR(create_gettime) = $currentYear AND WEEK(create_gettime, 1) = $currentWeek ")['SUM(amount)']
                                    +
                                    ($CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `user_id` = '$id' AND `status` = 'completed' AND YEAR(create_gettime) = $currentYear AND WEEK(create_gettime, 1) = $currentWeek ")['SUM(amount)'] * $CMSNT->site('rate_crypto')) 
                                );?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-3 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tổng tiền nạp hôm nay</span>
                                    <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `user_id` = '$id' AND `status` = 1 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `user_id` = '$id' AND `status` = 1 AND `fake` = 0 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `user_id` = '$id' AND `status` = 1 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `user_id` = '$id' AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `user_id` = '$id' AND `create_gettime` >= DATE(NOW()) AND `create_gettime` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(amount)']
                                    +
                                    ($CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `user_id` = '$id' AND `status` = 'completed' AND `create_gettime` >= DATE(NOW()) AND `create_gettime` LIKE '%".$currentDate."%' ")['SUM(amount)'] * $CMSNT->site('rate_crypto'))
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
                            <h3 class="card-title">Mua hàng trong tháng <?=date('m', time());?></h3>
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
                                        label: '<?=__('MUA HÀNG TRONG THÁNG');?>',
                                        data: [
                                            <?php
                  $data = [];
                  for ($day = 1; $day <= $numOfDays; $day++) {
                      $date = "$year-$month-$day";
                      $row = $CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `buyer` = '".$user['id']."' AND `fake` = 0 AND DATE(create_date) = '$date'  ");
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
                            <h3 class="card-title">Tiền nạp trong tháng <?=date('m', time());?></h3>
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

                      $total_pm_chart1 = $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `user_id` = '".$user['id']."' AND `status` = 1 AND DATE(update_date) = '$date' ")['SUM(`price`)'];
                      $total_invoice_chart1 = $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `user_id` = '".$user['id']."' AND `status` = 1 AND `fake` = 0 AND DATE(update_date) = '$date' ")['SUM(`pay`)'];
                      $total_card_chart1 = $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `user_id` = '".$user['id']."' AND `status` = 1 AND DATE(update_date) = '$date' ")['SUM(`price`)'];
                      $total_paypal_chart1 = $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `user_id` = '".$user['id']."' AND DATE(create_date) = '$date' ")['SUM(`price`)'];
                      $total_bank2_chart1 = $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `user_id` = '".$user['id']."' AND DATE(create_gettime) = '$date' ")['SUM(amount)'];
                      $total_crypto_chart1 = $CMSNT->get_row("SELECT SUM(amount) FROM `crypto_invoice` WHERE `user_id` = '".$user['id']."' AND `status` = 'completed' AND DATE(create_gettime) = '$date' ")['SUM(amount)'] * $CMSNT->site('rate_crypto');
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


        </div>
    </div>
</div>
</div>



<?php
require_once(__DIR__.'/footer.php');
?>