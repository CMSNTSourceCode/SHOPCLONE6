<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Buff Sub Fanpage').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
<style>
.form-control{
    border: 1px solid '.$CMSNT->site('theme_color').';
}
</style>
';
$body['footer'] = '';

if($CMSNT->site('sign_view_product') == 0){
    if (isset($_COOKIE["token"])) {
        $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_COOKIE['token'])."' ");
        if (!$getUser) {
            header("location: ".BASE_URL('client/logout'));
            exit();
        }
        $_SESSION['login'] = $getUser['token'];
    }
    if (isset($_SESSION['login'])) {
        require_once(__DIR__.'/../../../models/is_user.php');
    }
}else{
    require_once(__DIR__.'/../../../models/is_user.php');
}

require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <button type="button" class="btn btn-primary btn-block mt-2"><i
                                            class="fas fa-cart-plus mr-1"></i><?=__('Tạo Tiến Trình');?></button>
                                </div>
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <a type="button" href="<?=base_url('client/buffsubfanpage-history');?>" class="btn btn-outline-primary btn-block mt-2"><i
                                            class="fas fa-history mr-1"></i><?=__('Danh Sách Order');?></a>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div id="msg_dang_chuyen_doi_sang_uid" style="display:none;">
                                        <div class="alert bg-white alert-primary" role="alert">
                                            <i class="fa fa-spinner fa-spin mr-1"></i><?=__('Vui lòng chờ...');?>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-12 col-lg-4">
                                            <label
                                                class="col-form-label"><b><?=__('Link hoặc ID Fanpage:');?></b></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <input name="profile_user" id="profile_user" onchange="getUID()"
                                                placeholder="<?=__('Nhập Link hoặc UID Fanpage cần tăng');?>" type="text"
                                                class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center" id="form_loaiseeding">
                                        <div class="col-md-4">
                                            <label
                                                class="col-form-label"><b><?=__('Loại Seeding cần tăng:');?></b></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php foreach($CMSNT->get_list("SELECT * FROM `rate_autofb` WHERE `type_api` = 'buffsubfanpage' AND `price` > 0 ") as $row):?>
                                            <div class="custom-control custom-radio mb-1" style="opacity: 1;">
                                                <input onchange="totalPayment()" type="radio"
                                                    class="custom-control-input"
                                                    id="loaiseeding_<?=$row['id'];?>" name="loaiseeding"
                                                    value="<?=$row['id'];?>"><label
                                                    class="custom-control-label"
                                                    for="loaiseeding_<?=$row['id'];?>">
                                                    <?=__($row['name_loaiseeding']);?> <span
                                                        class="badge badge-primary badge-sm"><?=format_currency($row['price']);?></span></label>
                                            </div>
                                            <?php endforeach?>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-12 col-lg-4">
                                            <label class="col-form-label"><b><?=__('Số lượng cần tăng:');?></b></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <input onkeyup="totalPayment()" name="amount" id="amount" type="number"
                                                value="100" class="form-control" placeholder="<?=__('Nhập số lượng cần tăng');?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-12 col-lg-4">
                                            <label class="col-form-label"><b><?=__('Ghi chú:');?></b></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <textarea class="form-control" id="note"
                                                placeholder="<?=__('Nhập ghi chú đơn hàng nếu có');?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-sm-12 col-lg-4">
                                            <label class="col-form-label"><b><?=__('Lưu ý:');?></b></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-8">
                                            <div class="alert alert-primary" role="alert">
                                                <div class="iq-alert-text">
                                                    <span id="load_note"><br><br></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert bg-white alert-info" role="alert">
                                       <div class="card-body">
                                       <input type="hidden" id="token" value="<?=isset($getUser['token']) ? $getUser['token'] : '';?>" readonly>
                                       <input type="hidden" id="total_money_input" readonly>
                                       <center>
                                           <h5 class="mb-2"><?=__('Thanh Toán:');?> <b id="total" style="color: red;"><?=format_currency(0);?></b> </h5>
                                           <h6><?=__('Số lượng cần tăng:');?> <b style="color:blue;" id="total_amount">0</b> follow</h6>
                                        </center>
                                       </div>
                                    </div>
                                   
                                    <button type="button" onclick="orderService()" id="btnOrderService" class="btn btn-primary btn-block rounded-pill mt-2"><i
                                            class="fas fa-credit-card mr-1"></i><?=__('TẠO TIẾN TRÌNH');?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require_once(__DIR__.'/footer.php');?>

<script>


function orderService(){
    if ($('#profile_user').val().length == 0){
        cuteAlert({
            type: "error",
            title: "Error",
            message: "<?=__('Vui lòng nhập URL hoặc ID cần tăng');?>",
            buttonText: "Okay"
        });
        return false;
    }
    if ($('#amount').val() <= 0) {
        cuteAlert({
            type: "error",
            title: "Error",
            message: "<?=__('Số lượng không hợp lệ');?>",
            buttonText: "Okay"
        });
        return false;
    }
    if (!$('input[name=loaiseeding]:checked', '#form_loaiseeding').val()) {
        cuteAlert({
            type: "error",
            title: "Error",
            message: "<?=__('Vui lòng chọn loại Seeding cần tăng');?>",
            buttonText: "Okay"
        });
        return false;
    }
    if (confirm('<?=__('Bạn có chắc chắn muốn mua');?> '+$("#amount").val()+' Follow <?=__('cho ID');?> '+$("#profile_user").val()+' <?=__('với giá');?> '+$("#total_money_input").val()+' <?=__('không?');?>') == true) {
        $('#btnOrderService').html('<i class="fa fa-spinner fa-spin"></i> <?=__("ĐANG XỬ LÝ");?>').prop('disabled', true);
        $.ajax({
            url: "<?=BASE_URL("ajaxs/client/orderService.php");?>",
            method: "POST",
            dataType: "JSON",
            data: {
                profile_user: $("#profile_user").val(),
                loaiseeding: $('input[name=loaiseeding]:checked', '#form_loaiseeding').val(),
                amount: $("#amount").val(),
                note: $("#note").val(),
                token: $("#token").val(),
                type: 'buffsubfanpage'
            },
            success: function(respone) {
                $('#btnOrderService').html('<i class="fas fa-credit-card"></i> <?=__('TẠO TIẾN TRÌNH');?>').prop('disabled', false);
                if (respone.status == 'success') {
                    cuteAlert({
                        type: "success",
                        title: "Success",
                        message: respone.msg,
                        buttonText: "Okay"
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
                $('#btnOrderService').html('<i class="fas fa-credit-card"></i> <?=__('TẠO TIẾN TRÌNH');?>').prop('disabled', false);
                cuteToast({
                    type: "error",
                    message: '<?=__('Không thể nhận dữ liệu');?>',
                    timer: 5000
                });
            }
        });
    }
    else {
        alert("<?=__('Chúng tôi rất buồn vì điều này :(((');?>");
    }
}


function getUID() {
    $('#msg_dang_chuyen_doi_sang_uid').show();
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/loadForm.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            profile_user: $("#profile_user").val(),
            token: $("#token").val(),
            type: 'getUIDFB'
        },
        success: function(respone) {
            $('#msg_dang_chuyen_doi_sang_uid').hide();
            if (respone.status == 'success') {
                $("#profile_user").val(respone.uid.toString());
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
            $('#msg_dang_chuyen_doi_sang_uid').hide();
            cuteToast({
                type: "error",
                message: '<?=__('Vui lòng nhập url hợp lệ');?>',
                timer: 5000
            });
        }
    });
}


function totalPayment() {
    $('#total').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>');
    var amount = $("#amount").val();
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/totalPayment.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            loaiseeding: $('input[name=loaiseeding]:checked', '#form_loaiseeding').val(),
            amount: $("#amount").val(),
            token: $("#token").val(),
            store: 'buffsubfanpage'
        },
        success: function(respone) {
            $("#total").html(respone.total);
            $("#total_amount").html(amount.toString().replace(/(.)(?=(\d{3})+$)/g, '$1.'));
            $("#total_money_input").val(amount.toString().replace(/(.)(?=(\d{3})+$)/g, '$1.'));
            $("#load_note").html(respone.msg.toString());
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể tính kết quả thanh toán',
                timer: 5000
            });
        }
    });
}
</script>