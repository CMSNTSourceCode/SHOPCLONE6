<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


$body = [
    'title'     => __('Xác minh OTP').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';
if (!empty($_GET['token'])) {
    if (!$row = $CMSNT->get_row("SELECT * FROM `users` WHERE `otp_token` = '".check_string($_GET['token'])."' ")) {
        redirect(base_url('client/login'));
    }
    if($row['otp_token'] == '' || empty($row['otp_token'])){
        redirect(base_url('client/login'));
    }
} else {
    redirect(base_url('client/login'));
}
require_once(__DIR__.'/header.php');
?>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <div class="wrapper">
    <section class="login-content">
         <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
               <div class="col-md-5">
                  <div class="card p-5">
                     <div class="card-body">
                        <div class="auth-logo">
                           <img src="<?=BASE_URL($CMSNT->site('logo_dark'));?>" class="img-fluid  rounded-normal  darkmode-logo" alt="logo">
                           <img src="<?=BASE_URL($CMSNT->site('logo_light'));?>" class="img-fluid rounded-normal light-logo" alt="logo">
                        </div>
                        <h4 class="mb-3 text-center"><?=__('Xác minh OTP đăng nhập');?></h4>
                        <p class="text-center small text-secondary mb-3"><?=__('Vui lòng vào Email để lấy OTP đăng nhập');?></p>
                        <form>
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <label class="text-secondary"><?=__('OTP Mail');?></label>
                                    <input class="form-control" id="code" type="text" placeholder="<?=__('Nhập OTP');?>">
                                    <input class="form-control" id="token" type="hidden" value="<?=$row['otp_token'];?>">
                                 </div>
                              </div>
                           </div>
                           <button type="button" id="btnVerify" class="btn btn-primary btn-block"><?=__('Xác Nhận');?></button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      </div>
    
    <!-- Backend Bundle JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/backend-bundle.min.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/customizer.js"></script>
    <script src="<?=BASE_URL('public/datum');?>/assets/js/sidebar.js"></script>
    <!-- Flextree Javascript-->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/flex-tree.min.js"></script>
    <script src="<?=BASE_URL('public/datum');?>/assets/js/tree.js"></script>
    <!-- Table Treeview JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/table-treeview.js"></script>
    <!-- SweetAlert JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/sweetalert.js"></script>
    <!-- Vectoe Map JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/vector-map-custom.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/chart-custom.js"></script>
    <script src="<?=BASE_URL('public/datum');?>/assets/js/charts/01.js"></script>
    <script src="<?=BASE_URL('public/datum');?>/assets/js/charts/02.js"></script>
    <!-- slider JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/slider.js"></script>
    <!-- Emoji picker -->
    <script src="<?=BASE_URL('public/datum');?>/assets/vendor/emoji-picker-element/index.js" type="module"></script>
    <!-- app JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/app.js"></script>
</body>

</html>


<script type="text/javascript">
$("#btnVerify").on("click", function() {
    $('#btnVerify').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/profile.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: "VerifyOTPMail",
            code: $("#code").val(),
            token: $("#token").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                setTimeout("location.href = '<?=BASE_URL('');?>';", 100);
            } 
            else {
                cuteToast({
                    type: "error",
                    message: respone.msg,
                    timer: 5000
                });
            }
            $('#btnVerify').html('<?=__('Xác Nhận');?>').prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
            $('#btnVerify').html('<?=__('Xác Nhận');?>').prop('disabled', false);
        }

    });
});
</script>