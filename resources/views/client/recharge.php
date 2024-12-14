<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Nạp Tiền').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
';
$body['footer'] = '

';
if($CMSNT->site('status_bank') != 1){
    redirect(base_url());
}

require_once(__DIR__.'/../../../models/is_user.php');
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
                    <div class="iq-alert-text"><?=$CMSNT->site('recharge_notice');?></div>
                </div>
            </div>
            <?php if($CMSNT->num_rows(" SELECT * FROM `promotions` WHERE `status` = 1 ") != 0):?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%" scope="col">#</th>
                                    <th scope="col"><?=__('Số tiền nạp lớn hơn hoặc bằng');?></th>
                                    <th scope="col"><?=__('Khuyến mãi thêm');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;foreach($CMSNT->get_list(" SELECT * FROM `promotions` WHERE `status` = 1  ORDER BY `amount` DESC ") as $promotion):?>
                                <tr>
                                    <td><?=$i++;?></td>
                                    <td><b style="color: blue;"><?=format_currency($promotion['amount']);?></b></td>
                                    <td><b style="color: red;"><?=$promotion['discount'];?>%</b></td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif?>
            <?php if($CMSNT->site('sv1_autobank') == 1):?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Nạp tiền theo hoá đơn');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($CMSNT->get_list("SELECT * FROM `banks` ") as $bank) {?>
                            <div class="col-sm-6 col-md-6 col-lg-3 mt-3 mt-lg-0 mb-3">
                                <div type="button" onclick="openModalAmount(<?=$bank['id'];?>)"
                                    class="blur-shadow p-4 shadow-showcase text-center">
                                    <img src="<?=base_url($bank['image']);?>" width="200px" height="100px">
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif?>
            <?php if($CMSNT->site('sv2_autobank') == 1 && checkAddon(24) == true):?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Nạp tiền theo cú pháp');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($CMSNT->get_list("SELECT * FROM `banks` ") as $bank) {?>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 mt-4 mt-lg-0 mb-3">
                                <div class="blur-shadow p-4 shadow-showcase">
                                    <center>
                                        <?php if($bank['short_name'] == 'Kasikorn Bank' || 
                                        $bank['short_name'] == 'Siam Commercial Bank' || 
                                        $bank['short_name'] == 'THESIEURE' || 
                                        $bank['short_name'] == 'Zalo Pay' || 
                                        $bank['short_name'] == 'Bank of Ayudthya' || 
                                        $bank['short_name'] == 'Krungthai Bank' || 
                                        $bank['short_name'] == 'Bangkok Bank' ||
                                        $bank['short_name'] == 'Wing Bank' ||
                                        $bank['short_name'] == 'ABA Bank' ||
                                        $bank['short_name'] == 'State Bank of India' ||
                                        $bank['short_name'] == 'HDFC Bank' ||
                                        $bank['short_name'] == 'ICICI Bank' ||
                                        $bank['short_name'] == 'Thanachart Bank' ||
                                        $bank['short_name'] == 'Maybank' ||
                                        $bank['short_name'] == 'CIMB Clicks Malaysia' ||
                                        $bank['short_name'] == 'United Bank for Africa (UBA)' ||
                                        $bank['short_name'] == 'Wise.com' ||
                                        $bank['short_name'] == 'Binance' ||
                                        $bank['short_name'] == 'Bitcoin' ||
                                        $bank['short_name'] == 'USDT' ||
                                        $bank['short_name'] == 'Payoneer' ||
                                        $bank['short_name'] == 'Algérie Poste' ||
                                        $bank['short_name'] == 'Paysera' 
                                         
                                        ):?>
                                        <img class="mb-3" src="<?=base_url($bank['image']);?>" width="200px"
                                            height="100px">
                                        <?php elseif($bank['short_name'] == 'MOMO'): ?>
                                        <?=file_get_contents("https://api.web2m.com/api/qrmomo.php?amount=100000&phone=".$bank['accountNumber']."&noidung=".urlencode($CMSNT->site('prefix_autobank')).$getUser['id']."&size=300");?>
                                        <?php else:?>
                                        <img src="https://api.vietqr.io/<?=$bank['short_name'];?>/<?=$bank['accountNumber'];?>/0/<?=$CMSNT->site('prefix_autobank').$getUser['id'];?>/vietqr_net_2.jpg?accountName=<?=$bank['accountName'];?>"
                                            width="300px" />
                                        <?php endif?>
                                    </center>
                                    <ul class="list-group mb-2">
                                        <li class="list-group-item"><?=__('Số tài khoản:');?> <b
                                                id="copySTK<?=$bank['id'];?>"
                                                style="color: green;"><?=$bank['accountNumber'];?></b> <button
                                                onclick="copy()" data-clipboard-target="#copySTK<?=$bank['id'];?>"
                                                class="copy btn btn-primary btn-sm"><i class="fas fa-copy"></i></button>
                                        </li>
                                        <li class="list-group-item"><?=__('Chủ tài khoản:');?>
                                            <b><?=$bank['accountName'];?></b>
                                        </li>
                                        <li class="list-group-item"><?=__('Ngân hàng:');?>
                                            <b><?=$bank['short_name'];?></b></li>
                                        <li class="list-group-item"><?=__('Nội dung nạp:');?> <b
                                                id="copyNoiDung<?=$bank['id'];?>"
                                                style="color: red;"><?=$CMSNT->site('prefix_autobank').$getUser['id'];?></b>
                                            <button onclick="copy()"
                                                data-clipboard-target="#copyNoiDung<?=$bank['id'];?>"
                                                class="copy btn btn-primary btn-sm"><i class="fas fa-copy"></i></button>
                                        </li>
                                    </ul>
                                    <center><i><i class="fa fa-spinner fa-spin"></i>
                                            <?=__('Xử lý giao dịch tự động trong vài giây...');?></i></center>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=__('Nhập số tiền cần nạp');?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="hidden" id="token" value="<?=$getUser['token'];?>" required>
                    <input type="hidden" id="modal-id" required>
                    <input type="number" id="amount" onchange="totalRecharge()" onkeyup="totalRecharge()"
                        placeholder="<?=__('Nhập số tiền bạn cần nạp vào hệ thống');?>" class="form-control" required>
                </div>
                <p>
                    <span class="float-left"><?=__('Số tiền cần thanh toán');?><br><br><b id="payment"
                            style="color: blue;">0</b></span>
                    <span class="float-right"><?=__('Số tiền nhận được');?><br><br><b id="received"
                            style="color: red;">0</b></span>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=__('Đóng');?></button>
                <button type="button" id="btnDepositOrder" class="btn btn-primary"><?=__('Tạo hoá đơn');?></button>
            </div>
        </div>
    </div>
</div>
<?php require_once(__DIR__.'/footer.php');?>
<script type="text/javascript">
function openModalAmount(id) {
    $("#modal-id").val(id);
    $("#exampleModal").modal();
}
</script>

<script type="text/javascript">
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}

function totalRecharge() {
    $('#total').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>');
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/totalRecharge.php");?>",
        method: "POST",
        data: {
            amount: $("#amount").val(),
            token: $("#token").val(),
        },
        success: function(data) {
            $("#received").html(data);
            $("#payment").html($("#amount").val().toString().replace(/(.)(?=(\d{3})+$)/g, '$1.'));
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


$("#btnDepositOrder").on("click", function() {
    $('#btnDepositOrder').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop(
        'disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/deposit-order.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            type: $("#modal-id").val(),
            amount: $("#amount").val(),
            token: $("#token").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                //window.open("<?=BASE_URL('client/payment/');?>" + respone.trans_id + " ", '_blank');
                setTimeout("location.href = '<?=BASE_URL('client/payment/');?>" + respone.trans_id +
                    " ' ;", 500);

            } else {
                Swal.fire(
                    '<?=__('Thất bại');?>',
                    respone.msg,
                    'error'
                );
            }
            $('#btnDepositOrder').html('<?=__('Tạo hoá đơn');?>').prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
            $('#btnDepositOrder').html('<?=__('Tạo hoá đơn');?>').prop('disabled', false);
        }

    });
});
</script>