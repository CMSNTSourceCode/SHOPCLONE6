<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Đăng nhập quản trị',
    'desc'   => 'Trang đăng nhập quản trị CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '';
$body['footer'] = '';

redirect(base_url('client/login'));

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
            <input type="text" name="username" id="username"
                value="<?=$CMSNT->site('status_demo') == 1 ? 'admin' : '';?>" placeholder="Username">
        </p>
        <p>
            <input type="password" name="password" id="password"
                value="<?=$CMSNT->site('status_demo') == 1 ? 'admin' : '';?>" placeholder="Password">
        </p>
        <center class="mb-3" <?=$CMSNT->site('reCAPTCHA_status') == 1 ? '' : 'style="display:none;"';?>>
            <div class="g-recaptcha" id="g-recaptcha-response"
                data-sitekey="<?=$CMSNT->site('reCAPTCHA_site_key');?>"></div>
        </center>
        <div style="text-align: center;">
            <label>Vui lòng đăng nhập</label>
        </div>
    </div>
    <p class="p-container">
        <button class="btn-login" type="button" name="btnLogin" id="btnLogin">Login</button>
    </p>
</form>
<script type="text/javascript">
$("#btnLogin").on("click", function() {
    $('#btnLogin').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/admin/login.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            username: $("#username").val(),
            password: $("#password").val(),
            recaptcha: $("#g-recaptcha-response").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                setTimeout("location.href = '<?=BASE_URL('admin/');?>';", 100);
            } else if (respone.status == 'verify') {
                cuteToast({
                    type: "warning",
                    message: respone.msg,
                    timer: 5000
                });
                setTimeout("location.href = '" + respone.url + "';", 1000);
            } else {
                cuteToast({
                    type: "error",
                    message: respone.msg,
                    timer: 5000
                });
            }
            $('#btnLogin').html('Login').prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
        }

    });
});
</script>