<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thêm website API',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
 
';
$body['footer'] = '
 
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['btnAdd'])) {
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
    $data1 = 'Không tìm thấy dữ liệu số dư';
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
    $isInsert = $CMSNT->insert("connect_api", [
        'user_id'       => $getUser['id'],
        'domain'        => check_string($_POST['domain']),
        'type'          => check_string($_POST['type']),
        'username'      => check_string($_POST['username']),
        'password'      => check_string($_POST['password']),
        'price'         => $data1,
        'status'        => 1
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm website API vào hệ thống (".check_string($_POST['domain']).")"
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('admin/connect-api').'";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}


$domain = '';
if(!empty($_GET['domain'])){
    $domain = check_string($_GET['domain']);
}
$type = '';
if(!empty($_GET['type'])){
    $type = check_string($_GET['type']);
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm website API</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thêm website API</li>
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
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sign-in mr-1"></i>
                                ĐĂNG NHẬP WEBSITE API
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
                                    <label for="exampleInputEmail1">Domain</label>
                                    <input class="form-control" type="url" placeholder="https://shopclone6.cmsnt.site/" name="domain" value="<?=$domain;?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Loại API</label> 
                                    <select class="form-control select2bs4" name="type">
                                        <option value="CMSNT" <?=$type == 'SHOPCLONE6' ? 'selected' : '';?>>
                                            SHOPCLONE5 & SHOPCLONE6 CMSNT
                                        </option>
                                        <option value="SHOPCLONE7" <?=$type == 'SHOPCLONE7' ? 'selected' : '';?>>
                                            SHOPCLONE7 CMSNT
                                        </option>
                                        <?php if(checkAddon(11412) == true):?>
                                        <option value="API_1">
                                            API 1
                                        </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11413) == true):?>
                                        <option value="API_4">
                                            API 4
                                        </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11422) == true):?>
                                        <option value="DONGVANFB">
                                            DONGVANFB
                                        </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11427) == true):?>
                                        <option value="API_6">
                                            API 6
                                        </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11487) == true):?>
                                        <option value="API_7">
                                            API 7
                                        </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11535) == true):?>
                                        <option value="API_8">
                                            API 8
                                        </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11542) == true):?>
                                        <option value="API_9">
                                            API 9
                                        </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11635) == true):?>
                                        <option value="API_10">
                                            API 10
                                        </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11645) == true):?>
                                            <option value="API_11">
                                                API 11
                                            </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11657) == true):?>
                                            <option value="API_12">
                                                API 12
                                            </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11724) == true):?>
                                            <option value="API_13">
                                                API 13
                                            </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11735) == true):?>
                                            <option value="API_14">
                                                API 14
                                            </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11872) == true):?>
                                            <option value="API_15">
                                                API 15
                                            </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11898) == true):?>
                                            <option value="API_16">
                                                API 16
                                            </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11901) == true):?>
                                            <option value="API_17">
                                                API 17
                                            </option>
                                        <?php endif?>
                                        <?php if(checkAddon(11925) == true):?>
                                            <option value="API_23">
                                                API 23
                                            </option>
                                        <?php endif?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên đăng nhập</label>
                                    <input class="form-control" type="text" placeholder="Nhập tên đăng nhập" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu & API & Token</label>
                                    <input class="form-control" type="password" placeholder="Nhập mật khẩu đăng nhập" name="password" required>
                                </div>
                                <p>Hướng dẫn sử dụng chức năng tích hợp API tại đây: <a target="_blank" href="https://help.cmsnt.co/danh-muc/huong-dan-tich-hop-nguon-hang-vao-shopclone6/">https://help.cmsnt.co/danh-muc/huong-dan-tich-hop-nguon-hang-vao-shopclone6/</a></p>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="btnAdd" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>ĐĂNG NHẬP</button>
                            </div>
                        </form>
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
require_once(__DIR__.'/footer.php');
?>