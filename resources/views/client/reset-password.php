<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


$body = [
    'title'     => __('Thay đổi mật khẩu').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';
if(empty($_GET['token'])){
    redirect(base_url());
}
if (!$getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token_forgot_password` = '".check_string($_GET['token'])."' ")) {
    if($getUser['token_forgot_password'] == NULL){
        redirect(base_url());
    }
    redirect(base_url());
}
require_once(__DIR__.'/header.php');
?>
<style>
    .bg-image {
    background-position: 0 50%;
    background-size: cover;
}
</style>
<body class="bg-image" style="background-image: url(<?=BASE_URL($CMSNT->site('bg_login'));?>);">
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
                        <div class="card p-3">
                            <div class="card-body">
                                <div class="auth-logo">
                                    <img src="<?=base_url($CMSNT->site('logo_dark'));?>"
                                        class="img-fluid  rounded-normal  darkmode-logo" alt="logo">
                                    <img src="<?=base_url($CMSNT->site('logo_light'));?>"
                                        class="img-fluid rounded-normal light-logo" alt="logo">
                                </div>
                                <h3 class="mb-3 font-weight-bold text-center"><?=__('Thay đổi mật khẩu');?></h3>

                                    <center><?=__('Vui lòng nhập mật khẩu mới cần thay');?></p></center>
  
                                <form>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="text-secondary"><?=__('Mật khẩu mới');?></label>
                                                <input class="form-control" type="password" id="ChangePassword_password">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="hidden" id="ChangePassword_token" value="<?=$getUser['token'];?>">
                                                <label class="text-secondary"><?=__('Nhập lại mật khẩu mới');?></label>
                                                <input class="form-control" type="password" id="ChangePassword_repassword">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <div class="form-group">
                                                <center class="mb-3"
                                                    <?=$CMSNT->site('reCAPTCHA_status') == 1 ? '' : 'style="display:none;"';?>>
                                                    <div class="g-recaptcha" id="g-recaptcha-response"
                                                        data-sitekey="<?=$CMSNT->site('reCAPTCHA_site_key');?>"></div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="btnChangePassword"
                                        class="btn btn-primary btn-block mt-2"><?=__('Thay đổi mật khẩu');?></button>
                                    <div class="col-lg-12 mt-3">
                                        <p class="mb-0 text-center"><?=__('Bạn đã có tài khoản?');?> <a
                                                href="<?=base_url('client/login');?>"><?=__('Đăng nhập');?></a></p>
                                    </div>
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
$("#btnChangePassword").on("click", function() {
    $('#btnChangePassword').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Processing...');?>').prop(
        'disabled',
        true);
    
    $.ajax({
        url: "<?=base_url('ajaxs/client/auth.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'ChangePassword',
            token: $("#ChangePassword_token").val(),
            newpassword: $("#ChangePassword_password").val(),
            renewpassword: $("#ChangePassword_repassword").val(),
            recaptcha: $("#g-recaptcha-response").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                Swal.fire({
                    title: '<?=__('Successful !');?>',
                    text: respone.msg,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: '<?=__('Sign In');?>'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?=BASE_URL();?>';
                    }
                });
            } else {
                Swal.fire('<?=__('Failure!');?>', respone.msg, 'error');
            }
            $('#btnChangePassword').html(
                '<?=__('Thay đổi mật khẩu');?>'
                ).prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
            $('#btnChangePassword').html(
                '<?=__('Thay đổi mật khẩu');?>'
                ).prop('disabled', false);
        }

    });
});
</script>

