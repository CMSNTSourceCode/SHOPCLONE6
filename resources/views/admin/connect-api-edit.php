<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa kết nối',
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
require_once(__DIR__.'/../../../models/is_admin.php');

if (!$row = $CMSNT->get_row(" SELECT * FROM `connect_api` WHERE `id` = '" . check_string($_GET['id']) . "' ")) {
    redirect(base_url_admin('connect-api'));
}

require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
 
if (isset($_POST['btnSave'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if (empty($_POST['domain'])) {
        die('<script type="text/javascript">if(!alert("Vui lòng nhập địa chỉ trang web cần kết nối.")){window.history.back().location.reload();}</script>');
    }
    $parsed_url = parse_url(check_string($_POST['domain']));
    $domain = $parsed_url['host'];
    if (in_array($domain, $domain_black)) {
        die('<script type="text/javascript">if(!alert("Website '.$domain.' không an toàn từ lời khuyên của CMSNT.")){window.history.back().location.reload();}</script>');
    }
    $data1 = 'ERROR';
    if($_POST['type'] == 'CMSNT'){
        $checkdomain = curl_get('https://api.cmsnt.co/checkdomain.php?domain='.check_string($_POST['domain']));
        $checkdomain = json_decode($checkdomain, true);
        if($checkdomain['status'] == false){
            die('<script type="text/javascript">if(!alert("'.$checkdomain['msg'].'")){window.history.back().location.reload();}</script>');
        }
        
        $data1 = curl_get(check_string($_POST['domain'])."/api/GetBalance.php?username=".check_string($_POST['username'])."&password=".check_string($_POST['password']));
        $data = json_decode($data1, true);
        if(isset($data['status']) && $data['status'] == 'error'){
            die('<script type="text/javascript">if(!alert("'.$data['msg'].'")){window.history.back().location.reload();}</script>');
        }
    }
    if($_POST['type'] == 'SHOPCLONE7'){
        $checkdomain = curl_get('https://api.cmsnt.co/checkdomain.php?domain='.check_string($_POST['domain']));
        $checkdomain = json_decode($checkdomain, true);
        if($checkdomain['status'] == false){
            die('<script type="text/javascript">if(!alert("'.$checkdomain['msg'].'")){window.history.back().location.reload();}</script>');
        }

        $result = curl_get(check_string($_POST['domain'])."api/profile.php?api_key=".check_string($_POST['password']));
        $result = json_decode($result, true);
        if(isset($result['status']) && $result['status'] == 'error'){
            die('<script type="text/javascript">if(!alert("'.$result['msg'].'")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($result['data']['money']);
    }
    if($_POST['type'] == 'API_1'){
        $response = balance_API_1($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if($getPrice['status'] != true){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['balance']);
    }
    if($_POST['type'] == 'API_4'){
        $response = balance_API_4($_POST['domain'], $_POST['username'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if(!isset($getPrice['data']['userDetail']['coin'])){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['data']['userDetail']['coin']);
    }
    if($_POST['type'] == 'DONGVANFB'){
        $response = balance_API_DONGVANFB($_POST['domain'], $_POST['username'], $_POST['password']);
        $response = json_decode($response, true);
        if(isset($response['status']) && $response['status'] == true){
            $data1 = format_currency($response['balance']);
        }else{
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
    }
    if($_POST['type'] == 'API_6'){
        $response = balance_API_6($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if(!isset($getPrice['balance'])){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['balance']);
    }
    if($_POST['type'] == 'API_8'){
        $response = balance_API_8($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if(!isset($getPrice['data'])){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['data']);
    }
    if($_POST['type'] == 'API_9'){
        $response = balance_API_9($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if($getPrice['error'] != 0){
            die('<script type="text/javascript">if(!alert("'.$getPrice['message'].'")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['data']['balance']);
    }
    if($_POST['type'] == 'API_10'){
        $response = balance_API_10($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if($getPrice['Code'] != 0){
            die('<script type="text/javascript">if(!alert("'.$getPrice['Message'].'")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['Balance']);
    }
    if($_POST['type'] == 'API_11'){
        $response = curl_get($_POST['domain'].'user/balance?apikey='.$_POST['password']);
        $response = json_decode($response, true);
        if(isset($response['status']) && $response['status'] == true){
            $data1 = format_currency($response['balance_facebook']);
        }else{
            die('<script type="text/javascript">if(!alert("Không thể kết nối đến API")){window.history.back().location.reload();}</script>');
        }
    }
    if($_POST['type'] == 'API_12'){
        $response = balance_API_12($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if(isset($getPrice['user']) && $getPrice['error_code'] == 0){
            die('<script type="text/javascript">if(!alert("'.$getPrice['message'].'")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['user']['balance']);
    }
    if($_POST['type'] == 'API_14'){
        $response = balance_API_14($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if(!isset($getPrice['user'])){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['user']['balance']);
    }
    if($_POST['type'] == 'API_15'){
        $response = balance_API_15($_POST['domain'], $_POST['username'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if($getPrice['status'] != true){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['price']);
    }
    if($_POST['type'] == 'API_17'){
        $data1 = curl_get(check_string($_POST['domain'])."/api/GetBalance.php?username=".check_string($_POST['username'])."&password=".check_string($_POST['password']));
        $data = json_decode($data1, true);
        if(isset($data['status']) && $data['status'] == 'error'){
            die('<script type="text/javascript">if(!alert("'.$data['msg'].'")){window.history.back().location.reload();}</script>');
        }
    }
    if($_POST['type'] == 'API_23'){
        $data1 = 'Không có API lấy số dư';
    }
    $isUpdate = $CMSNT->update("connect_api", [
        'domain'        => check_string($_POST['domain']),
        'type'          => check_string($_POST['type']),
        'username'      => check_string($_POST['username']),
        'password'      => check_string($_POST['password']),
        'status_update_ck'      => check_string($_POST['status_update_ck']),
        'auto_rename_api'      => check_string($_POST['auto_rename_api']),
        'ck_connect_api'      => check_string($_POST['ck_connect_api']),
        'status'        => check_string($_POST['status']),
        'price'         => $data1
    ], " `id` = '" . $row['id'] . "' ");
    if ($isUpdate) {
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){window.history.back().location.reload();}</script>');
    }
    die('<script type="text/javascript">if(!alert("Lưu thất bại!")){window.history.back().location.reload();}</script>');
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh sửa kết nối</h1>
                    <p>Edit API product connection</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa kết nối</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/connect-api');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-12">
                    <?php if($row['type'] == 'CMSNT' && time() - $CMSNT->site('check_time_cron2') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron2.php');?>"
                            target="_blank"><?=base_url('cron/cron2.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_1' && time() - $CMSNT->site('check_time_cron3') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron3.php');?>"
                            target="_blank"><?=base_url('cron/cron3.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_4' && time() - $CMSNT->site('check_time_cron4') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron4.php');?>"
                            target="_blank"><?=base_url('cron/cron4.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_6' && time() - $CMSNT->site('check_time_cron6') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron6.php');?>"
                            target="_blank"><?=base_url('cron/cron6.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_7' && time() - $CMSNT->site('check_time_cron7') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron7.php');?>"
                            target="_blank"><?=base_url('cron/cron7.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_8' && time() - $CMSNT->site('check_time_cron8') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron8.php');?>"
                            target="_blank"><?=base_url('cron/cron8.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_9' && time() - $CMSNT->site('check_time_cron9') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron9.php');?>"
                            target="_blank"><?=base_url('cron/cron9.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_10' && time() - $CMSNT->site('check_time_cron10') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron10.php');?>"
                            target="_blank"><?=base_url('cron/cron10.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_11' && time() - $CMSNT->site('check_time_cron11') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron11.php');?>"
                            target="_blank"><?=base_url('cron/cron11.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_12' && time() - $CMSNT->site('check_time_cron12') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron12.php');?>"
                            target="_blank"><?=base_url('cron/cron12.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_13' && time() - $CMSNT->site('check_time_cron13') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron13.php');?>"
                            target="_blank"><?=base_url('cron/cron13.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_14' && time() - $CMSNT->site('check_time_cron14') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron14.php');?>"
                            target="_blank"><?=base_url('cron/cron14.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_15' && time() - $CMSNT->site('check_time_cron15') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron15.php');?>"
                            target="_blank"><?=base_url('cron/cron15.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_16' && time() - $CMSNT->site('check_time_cron16') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron16.php');?>"
                            target="_blank"><?=base_url('cron/cron16.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_17' && time() - $CMSNT->site('check_time_cron17') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron17.php');?>"
                            target="_blank"><?=base_url('cron/cron17.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'SHOPCLONE7' && time() - $CMSNT->site('check_time_shopclone7') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/shopclone7.php');?>"
                            target="_blank"><?=base_url('cron/shopclone7.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if($row['type'] == 'API_23' && time() - $CMSNT->site('check_time_cron23') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/cron23.php');?>"
                            target="_blank"><?=base_url('cron/cron23.php');?></a>
                    </div>
                    <?php endif?>
                </section>
                <section class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-pen-to-square mr-1"></i>
                                Chỉnh sửa kết nối <a href="<?= $row['domain']; ?>"
                                    target="_blank"><?= $row['domain']; ?></a>
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
                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-chinh-sua-item-tab" data-toggle="pill"
                                        href="#tab-chinh-sua-item" role="tab" aria-controls="tab-chinh-sua-item"
                                        aria-selected="true">CHỈNH SỬA API</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-quan-ly-chuyen-muc-tab" data-toggle="pill"
                                        href="#tab-quan-ly-chuyen-muc" role="tab" aria-controls="tab-quan-ly-chuyen-muc"
                                        aria-selected="false">QUẢN LÝ CHUYÊN MỤC</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-quan-ly-san-pham-tab" data-toggle="pill"
                                        href="#tab-quan-ly-san-pham" role="tab" aria-controls="tab-quan-ly-san-pham"
                                        aria-selected="false">QUẢN LÝ SẢN PHẨM</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" target="_blank"
                                        href="<?=base_url('index.php?module=admin&action=product-order&id_connect_api='.$row['id']);?>">QUẢN
                                        LÝ ĐƠN HÀNG</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="custom-content-below-tabContent" style="padding-top: 25px">
                                <div class="tab-pane fade active show" id="tab-chinh-sua-item" role="tabpanel"
                                    aria-labelledby="tab-chinh-sua-item-tab">
                                    <form method="POST" action="" accept-charset="UTF-8">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Domain</label>
                                            <input class="form-control" type="url"
                                                placeholder="https://shopclone6.cmsnt.site/" name="domain"
                                                value="<?= $row['domain']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Loại API</label>
                                            <select class="form-control select2bs4" name="type">
                                                <option <?= $row['type'] == 'CMSNT' ? 'selected' : ''; ?> value="CMSNT">
                                                    SHOPCLONE5 & SHOPCLONE6 CMSNT
                                                </option>
                                                <option <?= $row['type'] == 'SHOPCLONE7' ? 'selected' : ''; ?> value="SHOPCLONE7">
                                                    SHOPCLONE7 CMSNT
                                                </option>
                                                <?php if(checkAddon(11412) == true):?>
                                                <option <?= $row['type'] == 'API_1' ? 'selected' : ''; ?> value="API_1">
                                                    API 1
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11413) == true):?>
                                                <option <?= $row['type'] == 'API_4' ? 'selected' : ''; ?> value="API_4">
                                                    API 4
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11422) == true):?>
                                                <option <?= $row['type'] == 'DONGVANFB' ? 'selected' : ''; ?>
                                                    value="DONGVANFB">DONGVANFB</option>
                                                <?php endif?>
                                                <?php if(checkAddon(11427) == true):?>
                                                <option <?= $row['type'] == 'API_6' ? 'selected' : ''; ?> value="API_6">
                                                    API 6
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11487) == true):?>
                                                <option <?= $row['type'] == 'API_7' ? 'selected' : ''; ?> value="API_7">
                                                    API 7
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11535) == true):?>
                                                <option <?= $row['type'] == 'API_8' ? 'selected' : ''; ?> value="API_8">
                                                    API 8
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11542) == true):?>
                                                <option <?= $row['type'] == 'API_9' ? 'selected' : ''; ?> value="API_9">
                                                    API 9
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11635) == true):?>
                                                <option <?= $row['type'] == 'API_10' ? 'selected' : ''; ?>
                                                    value="API_10">
                                                    API 10
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11645) == true):?>
                                                <option <?= $row['type'] == 'API_11' ? 'selected' : ''; ?>
                                                    value="API_11">
                                                    API 11
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11657) == true):?>
                                                <option <?= $row['type'] == 'API_12' ? 'selected' : ''; ?>
                                                    value="API_12">
                                                    API 12
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11724) == true):?>
                                                <option <?= $row['type'] == 'API_13' ? 'selected' : ''; ?>
                                                    value="API_13">
                                                    API 13
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11735) == true):?>
                                                <option <?= $row['type'] == 'API_14' ? 'selected' : ''; ?>
                                                    value="API_14">
                                                    API 14
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11872) == true):?>
                                                <option <?= $row['type'] == 'API_15' ? 'selected' : ''; ?>
                                                    value="API_15">
                                                    API 15
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11898) == true):?>
                                                <option <?= $row['type'] == 'API_16' ? 'selected' : ''; ?> value="API_16">
                                                    API 16
                                                </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11901) == true):?>
                                                    <option <?= $row['type'] == 'API_17' ? 'selected' : ''; ?> value="API_17">
                                                        API 17
                                                    </option>
                                                <?php endif?>
                                                <?php if(checkAddon(11925) == true):?>
                                                    <option <?= $row['type'] == 'API_23' ? 'selected' : ''; ?> value="API_23">
                                                        API 23
                                                    </option>
                                                <?php endif?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên đăng nhập</label>
                                            <input class="form-control" type="text" placeholder="Nhập tên đăng nhập"
                                                name="username" value="<?= $row['username']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mật khẩu & API & Token</label>
                                            <input class="form-control" type="text"
                                                placeholder="Nhập mật khẩu đăng nhập" name="password"
                                                value="<?= $row['password']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tự động cập nhật giá</label>
                                            <select class="form-control select2bs4" name="status_update_ck">
                                                <option <?= $row['status_update_ck'] == 1 ? 'selected' : ''; ?>
                                                    value="1">
                                                    CÓ
                                                </option>
                                                <option <?= $row['status_update_ck'] == 0 ? 'selected' : ''; ?>
                                                    value="0">
                                                    KHÔNG
                                                </option>
                                            </select>
                                            <i>Chọn OFF hệ thống sẽ ngưng update giá theo API</i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Chiết khấu cập nhật giá</label>
                                            <input class="form-control" type="text"
                                                placeholder="Vui lòng nhập chiết khấu cập nhật giá tự động, để số 0 để tắt chức năng này"
                                                value="<?= $row['ck_connect_api']; ?>" name="ck_connect_api" />
                                            <i>Hệ thống sẽ tự động tăng giá sản phẩm API lên
                                                <?= $row['ck_connect_api']; ?>%, để 0 nếu muốn giá bán giống giá web
                                                gốc.</i>
                                        </div>
                                        <div class="form-group">
                                            <label>Tự động cập nhật tên sản phẩm</label>
                                            <select class="form-control select2bs4" name="auto_rename_api">
                                                <option <?= $row['auto_rename_api'] == 1 ? 'selected' : ''; ?>
                                                    value="1">
                                                    CÓ
                                                </option>
                                                <option <?= $row['auto_rename_api'] == 0 ? 'selected' : ''; ?>
                                                    value="0">
                                                    KHÔNG
                                                </option>
                                            </select>
                                            <i>Nếu bạn chọn có, hệ thống sẽ tự động cập nhật tên sản phẩm và mô tả
                                                sản phẩm theo API (vui lòng tắt nếu bạn muốn rename tên sản phẩm theo
                                                yêu
                                                cầu).</i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Số dư hiện tại</label>
                                            <input class="form-control" type="text" value="<?= $row['price']; ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Trạng thái</label>
                                            <select class="form-control" name="status" required>
                                                <option <?= $row['status'] == 1 ? 'selected' : ''; ?> value="1">Hiển thị
                                                </option>
                                                <option <?= $row['status'] == 0 ? 'selected' : ''; ?> value="0">Ẩn
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="btnSave" class="btn btn-primary btn-block">LƯU
                                                THAY ĐỔI</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-quan-ly-san-pham" role="tabpanel"
                                    aria-labelledby="tab-quan-ly-san-pham-tab">
                                    <div class="table-responsive">
                                        <table id="products" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>PRODUCT</th>
                                                    <th>PRICE/COST</th>
                                                    <th>ACCOUNT</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `id_connect_api` = '" . $row['id'] . "' ORDER BY `stt` ASC ") as $product) { ?>
                                                <tr onchange="updateForm(`<?= $product['id']; ?>`)">
                                                    <td>
                                                        <ul>
                                                            <li>Tên sản phẩm gốc: <i><?= $product['name_api']; ?></i>
                                                            </li>
                                                            <li>Tên sản phẩm: <b><?= $product['name']; ?></b></li>
                                                            <li>Chuyên mục:
                                                                <b></b><?= $product['category_id'] == 0 ? '' : getRowRealtime("categories", $product['category_id'], 'name'); ?>
                                                            </li>
                                                            <li>Trạng thái:
                                                                <?= display_status_product($product['status']); ?></li>
                                                        </ul>
                                                    </td>
                                                    <td width="20%">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Giá bán</span>
                                                            </div>
                                                            <input type="text" id="price<?= $product['id']; ?>"
                                                                value="<?= $product['price']; ?>"
                                                                placeholder="Nhập giá bán gói dịch vụ"
                                                                class="form-control">
                                                        </div>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Giá vốn</span>
                                                            </div>
                                                            <input type="text" id="cost<?= $product['id']; ?>"
                                                                value="<?= $product['cost']; ?>"
                                                                placeholder="Nhập giá vốn gói dịch vụ"
                                                                class="form-control">
                                                        </div>
                                                    </td>
                                                    <td width="15%">
                                                        <ul>
                                                            <li>Đang bán: <b
                                                                    style="color: green;"><?= format_cash($product['api_stock']); ?></b>
                                                            </li>
                                                            <li>Đã bán: <b
                                                                    style="color:blue;"><?= format_cash($CMSNT->get_row("SELECT COUNT(id)  FROM `accounts` WHERE `product_id` = '" . $product['id'] . "' AND `buyer` IS NOT NULL ")['COUNT(id)']); ?></b>
                                                                <a
                                                                    href="<?= base_url_admin('account-sold/' . $product['id']); ?>">Xem</a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td width="10%">
                                                        <a aria-label="" target="_blank"
                                                            href="<?= base_url('admin/product-edit/' . $product['id']); ?>"
                                                            style="color:white;"
                                                            class="btn btn-info btn-block btn-sm btn-icon-left m-b-10"
                                                            type="button">
                                                            <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-quan-ly-chuyen-muc" role="tabpanel"
                                    aria-labelledby="tab-quan-ly-chuyen-muc-tab">
                                    <div class="table-responsive">
                                        <table id="categories" class="table table-striped table-bordered text-center">
                                            <thead class="head">
                                                <tr>
                                                    <th>Tên chuyên mục</th>
                                                    <th>Ảnh</th>
                                                    <th>Trạng thái</th>
                                                    <th style="width: 20%">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `id_connect_api` = '" . $row['id'] . "' ORDER BY `stt` ASC ") as $category) { ?>
                                                <tr>
                                                    <td><?= $category['name']; ?></td>
                                                    <td><img src="<?= base_url($category['image']); ?>" width="40px">
                                                    </td>
                                                    <td><?= display_status_product($category['status']); ?></td>
                                                    <td>
                                                        <a aria-label="" target="_blank"
                                                            href="<?= base_url('admin/category-edit/' . $category['id']); ?>"
                                                            style="color:white;"
                                                            class="btn btn-info btn-sm btn-icon-left m-b-10"
                                                            type="button">
                                                            <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


<script>
$(function() {
    $('#categories').DataTable();
    $('#products').DataTable();
    $('#orders').DataTable();
});
</script>


<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?= BASE_URL("ajaxs/admin/update.php"); ?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'changeProductAPI',
            id: id,
            price: $("#price" + id).val(),
            cost: $("#cost" + id).val()
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
</script>

<div class="modal fade" id="modalAccounts" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tài khoản đơn hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="coypyBox" rows="20" readonly></textarea>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary copy" onclick="copy()"
                    data-clipboard-target="#coypyBox">Sao chép</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function showAccounts(trans_id) {
    $.ajax({
        url: "<?=base_url('ajaxs/admin/showAccounts.php');?>",
        method: "POST",
        data: {
            trans_id: trans_id
        },
        success: function(respone) {
            $('#modalAccounts').modal();
            $('#coypyBox').val(respone);
        }
    });
}
</script>
<script>
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "Đã sao chép vào bộ nhớ tạm",
        timer: 5000
    });
}
</script>
<?php
require_once(__DIR__.'/footer.php');
?>