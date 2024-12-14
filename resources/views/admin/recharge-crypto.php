<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Cấu hình Crypto',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
]; 
$body['header'] = '
    <!-- Bootstrap Switch -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- ckeditor -->
    <script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- Select2 -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
    <script>
    $(function () {
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch("state", $(this).prop("checked"));
          })
        $(".select2").select2()
        $(".select2bs4").select2({
            theme: "bootstrap4"
        });
    });
    </script>
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

    $sotin1trang = 10;
    if(isset($_GET['page'])){
        $page = check_string(intval($_GET['page']));
    }
    else{
        $page = 1;
    }
    $from = ($page - 1) * $sotin1trang;
    $where = " `id` > 0  ";
    $trans_id = '';
    $amount = '';
    $status = '';
    $user_id = '';
    $username = '';
    
    if (!empty($_GET['username'])) {
        $username = check_string($_GET['username']);
        if($idUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `username` = '$username' ")){
            $where .= ' AND `user_id` =  "'.$idUser['id'].'" ';
        }else{
            $where .= ' AND `user_id` =  "" ';
        }
    }
    if(!empty($_GET['user_id'])){
        $user_id = check_string($_GET['user_id']);
        $where .= ' AND `user_id` = '.$user_id.' ';
    }
    if(!empty($_GET['status'])){
        $status = check_string($_GET['status']);
        $where .= ' AND `status` = "'.$status.'" ';
    }
    if(!empty($_GET['trans_id'])){
        $trans_id = check_string($_GET['trans_id']);
        $where .= ' AND `trans_id` LIKE "%'.$trans_id.'%" ';
    }
    if(!empty($_GET['amount'])){
        $amount = check_string($_GET['amount']);
        $where .= ' AND `amount` = '.$amount.' ';
    }
    

    $listDatatable = $CMSNT->get_list(" SELECT * FROM `crypto_invoice` WHERE $where ORDER BY `id` DESC LIMIT $from,$sotin1trang ");
    ?>




<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cấu hình Crypto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url_admin('home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Cấu hình Crypto</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẤU HÌNH CRYPTO
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
                                    <select class="form-control select2bs4" name="status_crypto">
                                        <option <?=$CMSNT->site('status_crypto') == 0 ? 'selected' : '';?> value="0">OFF
                                        </option>
                                        <option <?=$CMSNT->site('status_crypto') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                    </select>
                                    <i>Chọn OFF hệ thống sẽ ẩn nạp crypto.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address (<a type="button" data-toggle="modal"
                                            data-target="#modal-hd-crypto" href="#">Xem
                                            hướng dẫn</a>)</label>
                                    <input type="text" class="form-control" name="crypto_address"
                                        value="<?=$CMSNT->site('crypto_address');?>" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Token (<a type="button" data-toggle="modal"
                                            data-target="#modal-hd-crypto" href="#">Xem
                                            hướng dẫn</a>)</label>
                                    <input type="text" class="form-control" name="crypto_token"
                                        value="<?=$CMSNT->site('crypto_token');?>" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số tiền nạp tối thiểu</label>
                                    <input type="number" class="form-control" name="crypto_min"
                                        value="<?=$CMSNT->site('crypto_min');?>"
                                        placeholder="Số tiền nạp tối thiểu (nhập USD)">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số tiền nạp tối đa</label>
                                    <input type="number" class="form-control" name="crypto_max"
                                        value="<?=$CMSNT->site('crypto_max');?>"
                                        placeholder="Số tiền nạp tối đa (nhập USD)">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Rate quy đổi USD sang VNĐ</label>
                                    <input type="number" class="form-control" name="rate_crypto"
                                        value="<?=$CMSNT->site('rate_crypto');?>"
                                        placeholder="Nhập mệnh giá VND quy đổi sang 1 USD">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ghi chú thông tin crypto</label>
                                    <textarea id="notice_crypto"
                                        name="notice_crypto"><?=$CMSNT->site('notice_crypto');?></textarea>
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
                                <i class="fas fa-cogs mr-1"></i>
                                DOANH THU THÁNG <?=date('m', time());?>
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
                    <canvas id="myChart"></canvas>

<script>
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
              label: '<?=__('Paid:');?>',
              data: [
                  <?php
                  $data = [];
                  for ($day = 1; $day <= $numOfDays; $day++) {
                      $date = "$year-$month-$day";
                      $row = $CMSNT->get_row("SELECT SUM(amount) FROM crypto_invoice WHERE DATE(create_gettime) = '$date' AND  `status` = 'completed' ");
                      $data[$day - 1] = $row['SUM(amount)'];
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
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                    beginAtZero: true,
                    callback: function(value, index, values) {
                        return '$' + value;
                    }
                  }
              }]
          }
      }
  });
</script>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                            <i class="fa-brands fa-bitcoin"></i>
                                LỊCH SỬ NẠP CRYPTO
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
                            <form action="<?=base_url('index.php');?>"
                                class="row row-cols-lg-auto g-3 align-items-center mb-3" name="formSearch" method="GET">
                                <input type="hidden" name="module" value="admin">
                                <input type="hidden" name="action" value="recharge-crypto">
                                <div class="col-lg col-md-4 col-6">
                                    <input class="form-control mb-2" value="<?=$user_id;?>" name="user_id"
                                        placeholder="<?=__('Search User ID');?>">
                                </div>
                                <div class="col-lg col-md-4 col-6">
                                    <input class="form-control mb-2" value="<?=$username;?>" name="username"
                                        placeholder="<?=__('Search Username');?>">
                                </div>
                                <div class="col-lg col-md-4 col-6">
                                    <input class="form-control mb-2" value="<?=$trans_id;?>" name="trans_id"
                                        placeholder="<?=__('Search trans id');?>">
                                </div>
                                <div class="col-lg col-md-4 col-6">
                                    <input class="form-control mb-2" value="<?=$amount;?>" name="amount"
                                        placeholder="<?=__('Search amount sent');?>">
                                </div>
                                <div class="col-lg col-md-4 col-6">
                                    <select class="form-control mb-2" name="status">
                                        <option value=""><?=__('Search by status');?></option>
                                        <option <?=$status == 'waiting' ? 'selected' : '';?> value="waiting">
                                            <?=__('Waiting');?></option>
                                        <option <?=$status == 'expired' ? 'selected' : '';?> value="expired">
                                            <?=__('Expired');?></option>
                                        <option <?=$status == 'completed' ? 'selected' : '';?> value="completed">
                                            <?=__('Completed');?></option>
                                    </select>
                                </div>
                                <div class="col-lg col-md-6 col-12 mb-2">
                                    <button type="submit" name="submit" value="filter"
                                        class="btn btn-primary"><i class="fa fa-search"></i>
                                        <?=__('Search');?>
                                    </button>
                                    <a class="btn btn-danger"
                                        href="<?=base_url_admin('recharge-crypto');?>"><i class="fa fa-trash"></i>
                                        <?=__('Clear filter');?>
                                    </a>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><?=__('Username');?></th>
                                            <th class="text-center"><?=__('Trans ID');?></th>
                                            <th><?=__('Amount Sent');?></th>
                                            <th class="text-center"><?=__('Status');?></th>
                                            <th><?=__('Create date');?></th>
                                            <th><?=__('Update date');?></th>
                                            <th class="text-center"><?=__('Action');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listDatatable as $row2) {?>
                                        <tr>
                                            <td class="text-center"><a
                                                    href="<?=base_url('admin/user-edit/'.$row2['user_id']);?>"><?=getRowRealtime("users", $row2['user_id'], "username");?>
                                                    [ID <?=$row2['user_id'];?>]</a>
                                            </td>
                                            <td class="text-center"><a target="_blank"
                                                    href="<?=$row2['url_payment'];?>"><?=$row2['trans_id'];?></a>
                                            </td>
                                            <td><b style="color: red;"><?=$row2['amount'];?></b> <b
                                                    style="color:green;">USDT</b>
                                            </td>
                                            <td class="text-center"><?=display_invoice($row2['status']);?></td>
                                            <td><?=$row2['create_gettime'];?></td>
                                            <td><?=$row2['update_gettime'];?></td>
                                            <td class="text-center fs-base">
                                                <a type="button" target="_blank" href="<?=$row2['url_payment'];?>"
                                                    class="btn btn-hero btn-success btn-sm  3">
                                                    <i class="fa-sharp fa-solid fa-money-bill"></i> <?=__('Pay now');?>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7">
                                                <div class="float-right">
                                                    <?=__('Paid:');?>
                                                    <strong
                                                        style="color:red;"><?=format_currency($CMSNT->get_row(" SELECT SUM(`amount`) FROM `crypto_invoice` WHERE $where AND `status` = 'completed' ")['SUM(`amount`)']);?></strong>
                                                    | <?=__('Unpaid:');?>
                                                    <strong
                                                        style="color:blue;"><?=format_currency($CMSNT->get_row(" SELECT SUM(`amount`) FROM `crypto_invoice` WHERE $where AND `status` = 'waiting' ")['SUM(`amount`)']);?></strong>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">

                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <?php
                                $total = $CMSNT->num_rows(" SELECT * FROM `crypto_invoice` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(base_url_admin("recharge-crypto&trans_id=$trans_id&amount=$amount&status=$status&user_id=$user_id&username=$username&"), $from, $total, $sotin1trang) . '</center>';}?>
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




<div class="modal fade" id="modal-hd-crypto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HƯỚNG DẪN TÍCH HỢP NẠP TIỀN TỰ ĐỘNG QUA CRYPTO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Bước 1: Truy cập vào <a target="_blank" href="https://fpayment.co/client/register">đây</a> để
                        <b>đăng ký</b> tài khoản và
                        <b>đăng nhập</b>.
                    </li>
                    <li>Bước 2: Truy cập vào <a target="_blank" href="https://fpayment.co/client/wallets">đây</a> để
                        thêm ví Tron vào hệ thống.
                    </li>
                    <li>Bước 3: Sau khi thêm ví Tron thành công, quý khách Copy <b>Token</b> và <b>Address</b> vào
                        Admin.</li>
                    <li>Bước 4: Vui lòng nạp số dư duy trì vào FPAYMENT.CO trước để giao dịch được tự động.</li>
                </ul>
                </ul>
                <p>Hướng dẫn chi tiết tại <a target="_blank"
                        href="https://www.cmsnt.co/2023/02/huong-dan-tich-hop-nap-tien-tu-ong-bang.html">đây</a>.</p>
                <h4 class="text-center">Chúc quý khách thành công <img
                        src="https://i.pinimg.com/736x/c4/2c/98/c42c983e8908fdbd6574c2135212f7e4.jpg" width="45px;">
                </h4>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
CKEDITOR.replace("notice_crypto");
</script>