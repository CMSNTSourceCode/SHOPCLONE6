<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Trang cá nhân').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';
require_once(__DIR__.'/../../../models/is_user.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-block p-card">
                    <div class="profile-box">
                        <div class="profile-card rounded">
                            <img src="<?=BASE_URL('public/datum');?>/assets/images/user/1.jpg" alt="profile-bg"
                                class="avatar-100 rounded d-block mx-auto img-fluid mb-3">
                            <h3 class="font-600 text-white text-center mb-0"><?=$getUser['username'];?></h3>
                            <p class="text-white text-center mb-5"><?=format_currency($getUser['money']);?></p>
                        </div>
                        <div class="pro-content rounded">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-icon mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                    </svg>
                                </div>
                                <p class="mb-0 eml"><?=$getUser['email'];?></p>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-icon mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                                    </svg>
                                </div>
                                <p class="mb-0"><?=$getUser['phone'];?></p>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-icon mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        width="24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="mb-0">
                                    <?=$getUser['status_2fa'] == 1 ? __('Đang bật bảo mật') : __('Đang tắt bảo mật');?>
                                </p>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="social-ic d-inline-flex rounded">
                                    <a href="#">
                                        <svg width="24" viewBox="0 0 512 512" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0)">
                                                <path
                                                    d="M341.269 85.0133H388.011V3.60533C379.947 2.496 352.213 0 319.915 0C252.523 0 206.357 42.3893 206.357 120.299V192H131.989V283.008H206.357V512H297.536V283.029H368.896L380.224 192.021H297.515V129.323C297.536 103.019 304.619 85.0133 341.269 85.0133V85.0133Z"
                                                    fill="black" />
                                            </g>
                                            <defs>
                                                <clipPath>
                                                    <rect width="512" height="512" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg width="24" viewBox="0 0 512 512" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path
                                                    d="M459.392 151.744C480.213 136.96 497.728 118.507 512 97.2587V97.2373C492.949 105.579 472.683 111.125 451.52 113.813C473.28 100.821 489.899 80.4053 497.707 55.808C477.419 67.904 455.019 76.4373 431.147 81.216C411.883 60.6933 384.427 48 354.475 48C296.363 48 249.579 95.168 249.579 152.981C249.579 161.301 250.283 169.301 252.011 176.917C164.757 172.651 87.5307 130.837 35.648 67.1147C26.6027 82.8373 21.2693 100.821 21.2693 120.171C21.2693 156.523 39.9787 188.736 67.904 207.403C51.0293 207.083 34.496 202.176 20.48 194.475V195.627C20.48 246.635 56.8533 289.003 104.576 298.773C96.0213 301.12 86.72 302.229 77.056 302.229C70.336 302.229 63.552 301.845 57.1947 300.437C70.784 341.995 109.397 372.565 155.264 373.568C119.552 401.493 74.1973 418.325 25.1093 418.325C16.512 418.325 8.256 417.941 0 416.896C46.5067 446.869 101.589 464 161.024 464C346.261 464 466.987 309.461 459.392 151.744V151.744Z"
                                                    fill="black" />
                                            </g>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg width="24" viewBox="0 0 512 512" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0)">
                                                <path
                                                    d="M500.672 126.485L501.312 130.666C495.125 108.714 478.421 91.7756 457.195 85.6103L456.747 85.5036C416.832 74.6663 256.213 74.6663 256.213 74.6663C256.213 74.6663 95.9999 74.453 55.6799 85.5036C34.0479 91.7756 17.3226 108.714 11.2426 130.218L11.1359 130.666C-3.77607 208.554 -3.88274 302.144 11.7973 385.536L11.1359 381.312C17.3226 403.264 34.0266 420.202 55.2533 426.368L55.7013 426.474C95.5733 437.333 256.235 437.333 256.235 437.333C256.235 437.333 416.427 437.333 456.768 426.474C478.421 420.202 495.147 403.264 501.227 381.76L501.333 381.312C508.117 345.088 512 303.402 512 260.821C512 259.264 512 257.685 511.979 256.106C512 254.656 512 252.928 512 251.2C512 208.597 508.117 166.912 500.672 126.485V126.485ZM204.971 333.888V178.304L338.645 256.213L204.971 333.888Z"
                                                    fill="black" />
                                            </g>
                                            <defs>
                                                <clipPath>
                                                    <rect width="512" height="512" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg width="24" viewBox="0 0 512 512" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0)">
                                                <path
                                                    d="M262.955 0C122.603 0.0213333 48 89.9413 48 187.989C48 233.451 73.408 290.176 114.091 308.16C125.696 313.387 124.16 307.008 134.144 268.821C134.933 265.643 134.528 262.891 131.968 259.925C73.8133 192.661 120.619 54.3787 254.656 54.3787C448.64 54.3787 412.395 322.795 288.405 322.795C256.448 322.795 232.64 297.707 240.171 266.667C249.301 229.696 267.179 189.952 267.179 163.307C267.179 96.1493 167.125 106.112 167.125 195.093C167.125 222.592 176.853 241.152 176.853 241.152C176.853 241.152 144.661 371.2 138.688 395.499C128.576 436.629 140.053 503.211 141.056 508.949C141.675 512.107 145.216 513.109 147.2 510.507C150.379 506.347 189.291 450.837 200.192 410.709C204.16 396.096 220.437 336.789 220.437 336.789C231.168 356.16 262.101 372.373 295.061 372.373C393.109 372.373 463.979 286.187 463.979 179.243C463.637 76.7147 375.893 0 262.955 0V0Z"
                                                    fill="black" />
                                            </g>
                                            <defs>
                                                <clipPath>
                                                    <rect width="512" height="512" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row">
                    <div class="col-sm-4 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body text-center">
                                <h2 class="mb-2 mt-3 text-primary"><?=format_currency($getUser['total_money']);?></h2>
                                <h4><?=__('Tổng tiền nạp');?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body text-center">
                                <h2 class="mb-2 mt-3 text-success">
                                    <?=format_currency($getUser['total_money']-$getUser['money']);?></h2>
                                <h4><?=__('Số Dư Sử Dụng');?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body text-center">
                                <h2 class="mb-2 mt-3 text-warning"><?=format_currency($getUser['money']);?></h2>
                                <h4><?=__('Số Dư Hiện Tại');?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                if ($CMSNT->site('is_update_phone') == 1 && isset($_SESSION['login']) && $getUser['phone'] == '') {?>
                <div class="alert text-white bg-warning" role="alert">
                    <div class="iq-alert-text"><i class="fa-solid fa-exclamation mr-1"></i><?=__('Vui lòng cập nhật số điện thoại để tiếp tục sử dụng website');?></div>
                </div>
                <?php }?>
                <div class="card card-block">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <div class="header-title">
                            <h4 class="card-title mb-0"><?=__('Thông Tin Cá Nhân');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Họ và Tên');?></label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" id="fullname" class="form-control"
                                    placeholder="<?=__('Nhập họ và tên');?>" value="<?=$getUser['fullname'];?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span class="required"><?=__('Tên đăng nhập');?></span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="hidden" id="token" value="<?=$getUser['token'];?>" />
                                <input type="text" class="form-control" value="<?=$getUser['username'];?>" readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Số điện thoại');?></label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" id="phone" class="form-control"
                                    placeholder="<?=__('Nhập số điện thoại');?>" value="<?=$getUser['phone'];?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Địa chỉ Email');?>
                                (*)</label>
                            <div class="col-lg-8 fv-row">
                                <input type="email" id="email" class="form-control"
                                    placeholder="<?=__('Nhập địa chỉ Email');?>" value="<?=$getUser['email'];?>"
                                    required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span class="required"><?=__('Thời gian đăng ký');?></span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" class="form-control" value="<?=$getUser['create_date'];?>"
                                    readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span class="required"><?=__('Đăng nhập gần đây');?></span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" class="form-control" value="<?=$getUser['update_date'];?>"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" id="btnSaveProfile"
                            class="btn btn-primary"><?=__('Lưu Thay Đổi');?></button>
                        <a type="button" href="<?=base_url('');?>" class="btn btn-danger"><?=__('Đóng');?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__.'/footer.php');?>
<script type="text/javascript">
$("#btnSaveProfile").on("click", function() {
    $('#btnSaveProfile').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop(
        'disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/profile.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'ChangeProfile',
            token: $("#token").val(),
            fullname: $("#fullname").val(),
            phone: $("#phone").val(),
            email: $("#email").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
            } else {
                cuteToast({
                    type: "error",
                    message: respone.msg,
                    timer: 5000
                });
            }
            $('#btnSaveProfile').html('<?=__('Lưu Thay Đổi');?>').prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
            $('#btnSaveProfile').html('<?=__('Lưu Thay Đổi');?>').prop('disabled', false);
        }
    });
});
</script>