



<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Mua tài liệu - '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '';
$body['footer'] = '';

if($CMSNT->site('status_store_document') != 1){
    redirect(base_url('client/home'));
}
if ($CMSNT->site('sign_view_product') == 0) {
    if (isset($_COOKIE["token"])) {
        $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '" . check_string($_COOKIE['token']) . "' ");
        if (!$getUser) {
            header("location: " . BASE_URL('client/logout'));
            exit();
        }
        $_SESSION['login'] = $getUser['token'];
    }
    if (isset($_SESSION['login'])) {
        require_once(__DIR__ . '/../../../models/is_user.php');
    }
} else {
    require_once(__DIR__ . '/../../../models/is_user.php');
}

if($CMSNT->site('status_is_change_password') == 1){
    if(isset($getUser) && $getUser['change_password'] == 0){
        redirect(base_url('client/is-change-password'));
    }
}
if ($CMSNT->site('is_update_phone') == 1) {
    if (isset($_SESSION['login']) && $getUser['phone'] == '') {
        redirect(base_url('client/profile'));
    }
}

require_once(__DIR__ . '/header.php');
require_once(__DIR__ . '/sidebar.php');



?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <!-- <?php if (isset($getUser) && $getUser['status_2fa'] != 1) { ?>
                <div class="col-lg-12">
                    <div class="alert bg-white alert-danger" role="alert">
                        <div class="iq-alert-icon">
                            <i class="ri-alert-line"></i>
                        </div>
                        <a href="<?= BASE_URL('client/security'); ?>" class="iq-alert-text"><?= __('Vui lòng bật xác minh 2 bước Google 2FA để bảo vệ tài khoản của bạn.'); ?></a>
                    </div>
                </div>
            <?php } ?> -->
            <?php if($CMSNT->site('thongbao') != ''):?>
            <div class="col-lg-12">
                <div class="alert bg-white alert-primary" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text"><?= $CMSNT->site('thongbao'); ?></div>
                </div>
            </div>
            <?php endif?>

            <?=$CMSNT->site('html_top_product');?>

            <?php if ($CMSNT->site('status_giao_dich_gan_day') == 1 && $CMSNT->site('position_gd_gan_day') == 1) { ?>
            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between"
                        style="background: <?= $CMSNT->site('theme_color'); ?>;">
                        <div class="header-title">
                            <h5 class="card-title" style="color:white;"><?= __('ĐƠN HÀNG GẦN ĐÂY'); ?></h5>
                        </div>
                    </div>
                    <div class="card-body p-0" style="height:500px;overflow-x:hidden;overflow-y:auto;">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($CMSNT->get_list("SELECT * FROM `orders` ORDER BY id DESC limit 20 ") as $orderLog) { ?>
                                    <tr>

                                        <td style="height:20px;">
                                            <lord-icon src="https://cdn.lordicon.com/cllunfud.json" trigger="hover"
                                                style="width:30px;height:30px">
                                            </lord-icon> <b
                                                style="color: green;">...<?= substr(getRowRealtime("users", $orderLog['buyer'], 'username'), -3, 3); ?></b>
                                            <?= __('mua'); ?> <b
                                                style="color: red;"><?= format_cash($orderLog['amount']); ?></b>
                                            <b><?= $orderLog['product_id'] != 0 ? substr(getRowRealtime('products', $orderLog['product_id'], 'name'), 0, 45).'...' : getRowRealtime('documents', $orderLog['document_id'], 'name'); ?></b>
                                            - <b style="color:blue;"><?= format_currency($orderLog['pay']); ?></b>
                                        </td>
                                        <td><span
                                                class="badge badge-primary"><?= timeAgo($orderLog['create_time']); ?></span>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between"
                        style="background: <?= $CMSNT->site('theme_color'); ?>;">
                        <div class="header-title">
                            <h5 class="card-title" style="color:white;"><?= __('NẠP TIỀN GẦN ĐÂY'); ?></h5>
                        </div>
                    </div>
                    <div class="card-body p-0" style="height:500px;overflow-x:hidden;overflow-y:auto;">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($CMSNT->get_list("SELECT * FROM `invoices` WHERE `status` = 1 ORDER BY id DESC limit 20") as $invoicelog) { ?>
                                    <tr>
                                        <td style="height:20px;">

                                            <lord-icon src="https://cdn.lordicon.com/ujmqspux.json" trigger="hover"
                                                style="width:30px;height:30px">
                                            </lord-icon> <b
                                                style="color: green;">...<?= substr(getRowRealtime("users", $invoicelog['user_id'], 'username'), -3, 3); ?></b>
                                            <?= __('thực hiện nạp'); ?>
                                            <b style="color:blue;"><?= format_currency($invoicelog['amount']); ?></b> -
                                            <b style="color:red;"><?= $invoicelog['payment_method']; ?></b>
                                        </td>
                                        <td><span
                                                class="badge badge-primary"><?= timeAgo($invoicelog['create_time']); ?></span>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
           


            <?php if($CMSNT->site('display_box_shop') == 1){?>
<div class="col-sm-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <i><?=__('Gợi ý sản phẩm cho bạn');?>:</i>
            <ol class="row">
                <?php foreach($CMSNT->get_list("SELECT * FROM `documents` WHERE `status` = 1 ORDER BY RAND() LIMIT 5 ") as $product):?>
                <li class="col-lg-6"><a href="javascript:void(0);"
                        onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>, `<?=__($product['name']);?>`)"
                        type="button"><b><?=__($product['name']);?></b> -
                        <b style="color: red;"><?=format_currency($product['price']);?></b></a></li>
                <?php endforeach?>
            </ol>
        </div>
    </div>
</div>
<?php }?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between" style="background: <?=$CMSNT->site('theme_color');?>;">
            <div class="header-title">
                <h5 class="card-title" style="color:white;"><?=mb_strtoupper(__('MUA TÀI LIỆU'), 'UTF-8');?>
                </h5>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills mb-3 nav-fill" id="pills-tab-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab-fill" onclick="showProduct(0)" data-toggle="pill"
                        href="#pills-home-fill" role="tab" aria-controls="pills-home" aria-selected="true"><i
                            class="fas fa-shopping-cart mr-1"></i><?=__('Tất Cả Sản Phẩm');?></a>
                </li>
                <?php foreach ($CMSNT->get_list("SELECT * FROM `document_categories` WHERE `status` = 1 ORDER BY `stt` ASC ") as $category) {?>
                <li class="nav-item">
                    <a class="nav-link" id="pills-home-tab-fill" onclick="showProduct(<?=$category['id'];?>)"
                        data-toggle="pill" href="#pills-home-fill" role="tab" aria-controls="pills-home"
                        aria-selected="true"><img src="<?=base_url($category['image']);?>" width="25px" />
                        <?=$category['name'];?></a>
                </li>
                <?php }?>
            </ul>
            <div class="tab-content" id="pills-tabContent-1">
                <div class="tab-pane fade show active" id="pills-home-fill" role="tabpanel"
                    aria-labelledby="pills-home-tab-fill">
                    <div id="showProduct">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center border-top-table p-3">
            <a type="button" href="<?=base_url('client/orders');?>" class="btn btn-secondary btn-sm"><i
                    class="fas fa-cart-arrow-down mr-1"></i><?=__('Lịch Sử Mua Hàng');?></a>
        </div>
    </div>
</div>



<div class="modal fade" id="modalBuy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=__('Thanh toán đơn hàng');?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-window-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label><?=__('Tên sản phẩm');?>:</label>
                    <input class="form-control" type="hidden" id="token" value="<?=$getUser['token'];?>">
                    <input type="text" class="form-control" id="name" readonly />
                    <input type="hidden" value="" readonly class="form-control" id="modal-id">
                    <input type="hidden" value="" readonly class="form-control" id="price">
                </div>
                <div class="form-group mb-3" id="showDiscountCode">
                    <label><?=__('Mã giảm giá');?>:</label>
                    <input type="text" class="form-control" onchange="totalPayment()" onkeyup="totalPayment()"
                        placeholder="<?=__('Nhập mã giảm giá của bạn');?>" id="coupon" />
                </div>
                <div class="mb-3 text-right"><button id="btnshowDiscountCode" onclick="showDiscountCode()"
                        class="btn btn-danger btn-sm"><?=__('Nhập mã giảm giá');?></button></div>
                <div class="mb-3 text-center" style="font-size: 20px;"><?=__('Tổng tiền cần thanh toán');?>: <b
                        id="total" style="color:red;">0</b></div>
                <div class="text-center mb-3">
                    <button type="submit" id="btnBuy" onclick="buyDocument()" class="btn btn-primary btn-block"><i
                            class="fas fa-credit-card mr-1"></i><?=__('Thanh Toán');?></span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function buyDocument() {
    var id = $("#modal-id").val();
    var amount = $("#amount").val();
    var token = $("#token").val();
    $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/buyDocument.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            token: token,
            id: id,
            coupon: $("#coupon").val()
        },
        success: function(data) {
            $('#btnBuy').html('<i class="fas fa-credit-card mr-1"></i><?=__('Thanh Toán');?>').prop(
                'disabled', false);
            if (data.status == 'success') {
                cuteToast({
                    type: "success",
                    message: data.msg,
                    timer: 5000
                });
                setTimeout("location.href = '<?=BASE_URL('client/orders');?>';", 1000);
            } else {
                cuteToast({
                    type: "error",
                    message: data.msg,
                    timer: 5000
                });
            }
        },
        error: function() {
            $('#btnBuy').html('<i class="fas fa-credit-card mr-1"></i><?=__('Thanh Toán');?>').prop(
                'disabled', false);
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
        }
    });
}
</script>
<script type="text/javascript">
showProduct(0);

function showProduct(id) {
    $("#showProduct").html('<center><img src="<?=base_url($CMSNT->site('gif_loading'));?>" width="100px" /></center>');
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/showDocument.php");?>",
        method: "POST",
        data: {
            id: id
        },
        success: function(data) {
            $("#showProduct").html(data);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
        }
    });
}
document.getElementById('showDiscountCode').style.display = 'none';

function showDiscountCode() {
    if (document.getElementById('showDiscountCode').style.display == 'none') {
        document.getElementById('btnshowDiscountCode').className = "btn btn-sm btn-dark";
        $('#btnshowDiscountCode').html('<?=__('Huỷ mã giảm giá');?>');
        document.getElementById('showDiscountCode').style.display = 'block';
    } else {
        document.getElementById('btnshowDiscountCode').className = "btn btn-sm btn-danger";
        $('#btnshowDiscountCode').html('<?=__('Nhập mã giảm giá');?>');
        document.getElementById('showDiscountCode').style.display = 'none';
        document.getElementById('coupon').value = '';
        totalPayment();
    }
}

function totalPayment() {
    $('#total').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>');
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/totalPayment.php");?>",
        method: "POST",
        data: {
            id: $("#modal-id").val(),
            coupon: $("#coupon").val(),
            token: $("#token").val(),
            store: 'documents'
        },
        success: function(data) {
            $("#total").html(data);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể tính kết quả thanh toán',
                timer: 5000
            });
        }
    });
    //$("#total").html(total.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,'));
}

function modalBuy(id, price, name) {
    $("#modal-id").val(id);
    $("#price").val(price);
    $("#name").val(name);
    $("#modalBuy").modal();
    totalPayment();
}
</script>


            <?php if ($CMSNT->site('status_giao_dich_gan_day') == 1 && $CMSNT->site('position_gd_gan_day') == 2) { ?>
            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between"
                        style="background: <?= $CMSNT->site('theme_color'); ?>;">
                        <div class="header-title">
                            <h5 class="card-title" style="color:white;"><?= __('ĐƠN HÀNG GẦN ĐÂY'); ?></h5>
                        </div>
                    </div>
                    <div class="card-body p-0" style="height:500px;overflow-x:hidden;overflow-y:auto;">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($CMSNT->get_list("SELECT * FROM `orders` ORDER BY id DESC limit 20 ") as $orderLog) { ?>
                                    <tr>

                                        <td style="height:20px;">
                                            <lord-icon src="https://cdn.lordicon.com/cllunfud.json" trigger="hover"
                                                style="width:30px;height:30px">
                                            </lord-icon> <b
                                                style="color: green;">...<?= substr(getRowRealtime("users", $orderLog['buyer'], 'username'), -3, 3); ?></b>
                                            <?= __('mua'); ?> <b
                                                style="color: red;"><?= format_cash($orderLog['amount']); ?></b>
                                            <b><?= $orderLog['product_id'] != 0 ? substr(getRowRealtime('products', $orderLog['product_id'], 'name'), 0, 45).'...' : getRowRealtime('documents', $orderLog['document_id'], 'name'); ?></b>
                                            - <b style="color:blue;"><?= format_currency($orderLog['pay']); ?></b>
                                        </td>
                                        <td><span
                                                class="badge badge-primary"><?= timeAgo($orderLog['create_time']); ?></span>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between"
                        style="background: <?= $CMSNT->site('theme_color'); ?>;">
                        <div class="header-title">
                            <h5 class="card-title" style="color:white;"><?= __('NẠP TIỀN GẦN ĐÂY'); ?></h5>
                        </div>
                    </div>
                    <div class="card-body p-0" style="height:500px;overflow-x:hidden;overflow-y:auto;">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($CMSNT->get_list("SELECT * FROM `invoices` WHERE `status` = 1 ORDER BY id DESC limit 20") as $invoicelog) { ?>
                                    <tr>
                                        <td style="height:20px;">

                                            <lord-icon src="https://cdn.lordicon.com/ujmqspux.json" trigger="hover"
                                                style="width:30px;height:30px">
                                            </lord-icon> <b
                                                style="color: green;">...<?= substr(getRowRealtime("users", $invoicelog['user_id'], 'username'), -3, 3); ?></b>
                                            <?= __('thực hiện nạp'); ?>
                                            <b style="color:blue;"><?= format_currency($invoicelog['amount']); ?></b> -
                                            <b style="color:red;"><?= $invoicelog['payment_method']; ?></b>
                                        </td>
                                        <td><span
                                                class="badge badge-primary"><?= timeAgo($invoicelog['create_time']); ?></span>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>


<?php
if(isset($_POST['hide_notice_popup'])){
    $_SESSION['hide_notice_popup'] = 1;
    die('<script type="text/javascript">window.history.back().location.reload();</script>');
}
?>
<?php if($CMSNT->site('notice_popup') != ''): ?>
<?php if(!isset($_SESSION['hide_notice_popup'])):?>

<div class="onboarding-modal modal fade animated" id="notice_popup" role="dialog" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?=__('Thông báo');?></h5>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                     <?=$CMSNT->site('notice_popup');?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="hide_notice_popup"><?=__('Không hiển thị lại');?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?=__('Đóng');?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(e => {
        ShowModal_notice_popup()
    }, 0)
});

function ShowModal_notice_popup() {
    $('#notice_popup').modal({
        keyboard: true,
        show: true
    });
}
</script>
<?php endif?>
<?php endif?>
<?php require_once(__DIR__ . '/footer.php'); ?>

