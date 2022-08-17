<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Bảo mật').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>


<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <div class="header-title">
                            <h4 class="card-title mb-0"><img width="30px" class="mr-1"
                                    src="<?=base_url('assets/img/2faicon.png');?>"><?=__('Two-Factor Authentication');?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <label
                                    class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Bật/Tắt Google 2FA');?></label>
                                <div class="col-lg-8 fv-row">
                                    <select id="status_2fa" class="form-control">
                                        <option <?=$getUser['status_2fa'] == 1 ? 'selected' : '';?> value="1">
                                            <?=__('Bật');?></option>
                                        <option <?=$getUser['status_2fa'] == 0 ? 'selected' : '';?> value="0">
                                            <?=__('Tắt');?></option>
                                    </select>
                                    <input type="hidden" id="token" value="<?=$getUser['token'];?>" />
                                    <i><?=__('Vui lòng lưu thông tin phía dưới trước khi Bật chức năng này');?></i>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Secret Key');?></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" class="form-control" value="<?=$getUser['SecretKey_2fa'];?>"
                                        readonly />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('QR CODE');?></label>
                                <div class="col-lg-8 fv-row">
                                    <?php
                                    use PragmaRX\Google2FAQRCode\Google2FA;

$google2fa = new Google2FA();
                                    $qrCodeUrl = $google2fa->getQRCodeInline($CMSNT->site('title'), $getUser['email'], $getUser['SecretKey_2fa']);
                                   ?>
                                    <?=$qrCodeUrl;?><br>
                                    <i><?=__('Xác minh OTP: Thực hiện xác minh bằng Ứng dụng Google Authenticator');?></i>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Mã Xác Minh');?></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" class="form-control" id="secret"
                                        placeholder="<?=__('Nhập mã xác minh để lưu thay đổi');?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" id="btnSaveProfile"
                            class="btn btn-primary"><?=__('Lưu Thay Đổi');?></button>
                        <a type="button" href="<?=BASE_URL('');?>" class="btn btn-danger"><?=__('Đóng');?></a>
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
            action: 'ChangeGoogle2FA',
            token: $("#token").val(),
            status_2fa: $("#status_2fa").val(),
            secret: $("#secret").val()
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