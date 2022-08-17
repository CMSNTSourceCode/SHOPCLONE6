<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Xác minh 2FA',
    'desc'   => 'Trang xác minh đăng nhập CTV Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '';
$body['footer'] = '';
if (isset($_GET['token'])) {
    if (!$row = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string(base64_decode($_GET['token']))."' AND `admin` = 1 ")) {
        redirect(base_url('ctv/login'));
    }
} else {
    redirect(base_url('ctv/login'));
}
require_once(__DIR__.'/header.php');
?>
<link rel="stylesheet" href="<?=base_url('public/css/LoginAdmin.css');?>">
<div class="background-wrap">
    <div class="background"></div>
</div>
<form id="accesspanel" action="" method="post">
    <h1 id="litheader">CMSNT.CO</h1>
    <div class="inset">
        <p>
            <input id="code" type="text" placeholder="<?=__('Nhập mã xác minh');?>">
            <input id="token" type="hidden" value="<?=$row['token'];?>">
        </p>
        <div style="text-align: center;">
            <label>Vui lòng xác minh 2FA để thực hiện đăng nhập</label>
        </div>
    </div>
    <p class="p-container">
        <button class="btn-login" type="button" id="btnVerify">Submit</button>
    </p>
</form>
<script type="text/javascript">
$("#btnVerify").on("click", function() {
    $('#btnVerify').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/ctv/verify.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: "VerifyGoogle2FA",
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