<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Mua Fanpage/Group').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
 
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
            <div class="col-lg-12">
                <div class="alert bg-white alert-primary" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text"><?=$CMSNT->site('notice_store_fanpage');?></div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('MUA FANPAGE/GROUP FB');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped table-bordered mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%"><?=__('STT');?></th>
                                        <th width="30%"><?=__('Fanpage/Group');?></th>
                                        <th><?=__('Số lượng Like/Mem');?></th>
                                        <th><?=__('Thời gian tạo');?></th>
                                        <th><?=__('Loại');?></th>
                                        <th><?=__('Giá');?></th>
                                        <th><?=__('Mô tả');?></th>
                                        <th><?=__('Thao tác');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($CMSNT->get_list("SELECT * FROM `store_fanpage` WHERE `buyer` = 0  ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td>
                                            <a href="https://www.facebook.com/<?=$row['uid'];?>" target="_blank">
                                                <img src="<?=base_url($row['icon']);?>" width="50px" height="50px"
                                                    class="avatar-rounded" alt="<?=$row['name'];?>">
                                                <span class="mb-0 ml-2"><?=$row['name'];?></span>
                                            </a>
                                        </td>
                                        <td><b style="color:blue;"><?=format_cash($row['sl_like']);?></b></td>
                                        <td><b><?=$row['nam_tao_fanpage'];?></b></td>
                                        <td><b><?=$row['type'];?></b></td>
                                        <td><b style="color:red;"><?=format_currency($row['price']);?></b></td>
                                        <td><?=base64_decode($row['content']);?></td>
                                        <td>
                                            <button
                                                onclick="modalBuy(<?=$row['id'];?>, <?=$row['price'];?>, `<?=__($row['name']);?>`)"
                                                class="btn btn-primary btn-sm"><i
                                                    class="fa-solid fa-cart-shopping mr-1"></i><?=__('MUA NGAY');?></button>

                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center border-top-table p-3">
                        <a type="button" href="<?=base_url('client/store-fanpage-orders');?>"
                            class="btn btn-secondary btn-sm"><i
                                class="fas fa-cart-arrow-down mr-1"></i><?=__('Lịch Sử Mua Hàng');?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modalBuy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=__('Thanh toán đơn hàng');?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-window-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label><?=__('Tên Fanpage/Group');?>:</label>
                    <input type="text" class="form-control" id="name" readonly />
                    <input type="hidden" value="" readonly class="form-control" id="modal-id">
                    <input class="form-control" type="hidden" id="token" value="<?=$getUser['token'];?>">
                </div>
                <div class="form-group mb-3">
                    <label><?=__('Giá bán');?>:</label>
                    <input type="number" value="" readonly class="form-control" id="price">
                </div>
                <div class="form-group mb-3">
                    <label><?=__('Nhập UID FB hoặc Link FB:');?></label>
                    <input type="text" value=""
                        placeholder="<?=__('Vui lòng nhập Link Facebook hoặc UID để set làm admin');?>"
                        class="form-control" id="url">
                </div>
                <div class="form-group mb-3">
                    <label><?=__('Đổi tên Fanpage (nếu không cần đổi tên không cần điền):');?></label>
                    <input type="text" value=""
                        placeholder="<?=__('Tên page muốn đổi chỉ được chữ cái đầu viết hoa, tên không được in hoa hết hoặc viết hoa ở giữa hoặc kí tự đặc biệt.');?>"
                        class="form-control" id="new_name">
                    <br>
                    <i><?=__('Tên page muốn đổi chỉ được chữ cái đầu viết hoa, tên không được in hoa hết hoặc viết hoa ở giữa hoặc kí tự đặc biệt.');?></i>
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
function modalBuy(id, price, name) {
    $("#modal-id").val(id);
    $("#price").val(price);
    $("#name").val(name);
    $("#modalBuy").modal();
    totalPayment()
}

function buyDocument() {
    $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/buyStorefanpage.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            coupon: $("#coupon").val(),
            token: $("#token").val(),
            url: $("#url").val(),
            new_name: $("#new_name").val(),
            id: $("#modal-id").val()
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
                setTimeout("location.href = '<?=BASE_URL('client/store-fanpage-orders');?>';", 1000);
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
            store: 'store-fanpage'
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
</script>


<?php require_once(__DIR__.'/footer.php');?>