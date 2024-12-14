<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


$body = [
    'title' => __('Đăng ký').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
    <link href="'.BASE_URL('public/client/').'assets/css/pages/login/classic/login-2.css" rel="stylesheet" type="text/css" />
';
$body['footer'] = '

';
require_once(__DIR__.'/header.php');
?>



<style>
.bg-image {
    background-position: 0 50%;
    background-size: cover;
}
</style>

<body class="bg-image" style="background-image: url(<?=BASE_URL($CMSNT->site('bg_register'));?>);">
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
                                <h3 class="mb-3 font-weight-bold text-center"><?=__('Đăng Ký');?></h3>
                                <!-- <p class="text-center text-secondary mb-4">
                                    <?=__('Chọn phương tiện truyền thông xã hội của bạn để tạo tài khoản');?></p>
                                <div class="social-btn d-flex justify-content-around align-items-center mb-4">
                                    <button class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="88.428 12.828 107.543 207.085">
                                            <path
                                                d="M158.232 219.912v-94.461h31.707l4.747-36.813h-36.454V65.134c0-10.658 2.96-17.922 18.245-17.922l19.494-.009V14.278c-3.373-.447-14.944-1.449-28.406-1.449-28.106 0-47.348 17.155-47.348 48.661v27.149H88.428v36.813h31.788v94.461l38.016-.001z"
                                                fill="#3c5a9a" />
                                        </svg>
                                    </button>
                                    <button class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 256 262" preserveAspectRatio="xMidYMid">
                                            <path
                                                d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"
                                                fill="#4285F4" />
                                            <path
                                                d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"
                                                fill="#34A853" />
                                            <path
                                                d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"
                                                fill="#FBBC05" />
                                            <path
                                                d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"
                                                fill="#EB4335" />
                                        </svg>
                                    </button>
                                    <button class="btn btn-outline-light">
                                        <svg width="20" height="20" viewBox="328 355 335 276"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M 630, 425 A 195, 195 0 0 1 331, 600 A 142, 142 0 0 0 428, 570A  70,  70 0 0 1 370, 523A  70,  70 0 0 0 401, 521A  70,  70 0 0 1 344, 455A  70,  70 0 0 0 372, 460A  70,  70 0 0 1 354, 370A 195, 195 0 0 0 495, 442A  67,  67 0 0 1 611, 380A 117, 117 0 0 0 654, 363A  65,  65 0 0 1 623, 401A 117, 117 0 0 0 662, 390A  65,  65 0 0 1 630, 425Z"
                                                style="fill:#3BA9EE;" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mb-5">
                                    <p class="line-around text-secondary mb-0"><span
                                            class="line-around-1"><?=__('hoặc');?></span></p>
                                </div> -->
                                <form>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="text-secondary"><?=__('Tên đăng nhập');?></label>
                                                <input class="form-control" type="text" id="username"
                                                    placeholder="<?=__('Vui lòng nhập Username');?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="text-secondary"><?=__('Địa chỉ Email');?></label>
                                                <input class="form-control" type="email" id="email"
                                                    placeholder="<?=__('Vui lòng nhập địa chỉ Email');?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="text-secondary"><?=__('Mật khẩu');?></label>
                                                </div>
                                                <input class="form-control" type="password" id="password"
                                                    placeholder="<?=__('Vui lòng nhập mật khẩu');?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="text-secondary"><?=__('Nhập lại mật khẩu');?></label>
                                                </div>
                                                <input class="form-control" type="password" id="repassword"
                                                    placeholder="<?=__('Vui lòng nhập lại mật khẩu');?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <div class="form-check form-check-inline">
                                                <div class="custom-control custom-checkbox custom-control-inline mb-3">
                                                    <input type="checkbox" class="custom-control-input m-0"
                                                        id="isCheckbox">
                                                    <label class="custom-control-label pl-2" for="isCheckbox"><?=__('Đồng ý với');?> <a href="<?=base_url('client/privacy-policy');?>"><?=__('Chính sách');?>
                                                        </a> <?=__('và');?> <a href="<?=base_url('client/terms');?>"><?=__('Điều khoản dịch vụ');?></a></label>
                                                </div>
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
                                    <button type="button" id="btnRegister"
                                        class="btn btn-primary btn-block mt-2"><?=__('Đăng Ký');?></button>
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
$("#btnRegister").on("click", function() {
    var checkbox = document.getElementById("isCheckbox");
    if (!checkbox.checked) {
        Swal.fire(
            '<?=__('Thất bại');?>',
            "<?=__('Vui lòng đồng ý điều khoản và chính sách sẽ tiếp tục');?>",
            'error'
        );
        return 0;
    }
    $('#btnRegister').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/register.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            username: $("#username").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            repassword: $("#repassword").val(),
            recaptcha: $("#g-recaptcha-response").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                setTimeout("location.href = '<?=BASE_URL('client/home');?>';", 100);
            } else {
                Swal.fire(
                    '<?=__('Thất bại');?>',
                    respone.msg,
                    'error'
                );
            }
            $('#btnRegister').html('<?=__('Đăng Ký');?>').prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
            $('#btnRegister').html('<?=__('Đăng Ký');?>').prop('disabled', false);
        }

    });
});
</script>