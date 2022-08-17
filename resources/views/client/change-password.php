<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Thay đổi mật khẩu').' | '.$CMSNT->site('title'),
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
                            <h4 class="card-title mb-0"><?=__('Thay đổi mật khẩu');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Mật khẩu hiện tại');?></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="password" id="password"
                                        class="form-control"
                                        placeholder="<?=__('Vui lòng nhập mật khẩu hiện tại');?>" required />
                                    <input type="hidden" id="token" value="<?=$getUser['token'];?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Mật khẩu mới');?></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="password" id="newpassword"
                                        class="form-control"
                                        placeholder="<?=__('Vui lòng nhập mật khẩu mới');?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Nhập lại mật khẩu mới');?></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="password" id="renewpassword"
                                        class="form-control"
                                        placeholder="<?=__('Vui lòng nhập lại mật khẩu mới');?>" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" id="btnSaveProfile" class="btn btn-primary"><?=__('Lưu Thay Đổi');?></button>
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
    $('#btnSaveProfile').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/profile.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'ChangePassword',
            token: $("#token").val(),
            password: $("#password").val(),
            newpassword: $("#newpassword").val(),
            renewpassword: $("#renewpassword").val()
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