<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __($CMSNT->site('title_thuesim')),
    'desc'   => $CMSNT->site('description_thuesim'),
    'keyword' => $CMSNT->site('keyword_thuesim')
];
$body['header'] = '
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
.form-control{
    border: 1px solid '.$CMSNT->site('theme_color').';
}
</style>
';
$body['footer'] = '
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch("state", $(this).prop("checked"));
      })
    $(".select2").select2()
    $(".select2bs4").select2({
        theme: "bootstrap4"
    });
});
</script>
';

require_once(__DIR__.'/../../../models/is_user.php');

require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<style>
.dataTables_length {
    display: none;
}
</style>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <button type="button" class="btn btn-primary btn-block mt-2"><i
                        class="fas fa-cart-plus mr-1"></i><?=__('Thuê số tùy chọn');?></button>
            </div>
            <div class="col-sm-12 col-lg-6 mb-5">
                <a type="button" href="<?=base_url('client/otp-history');?>"
                    class="btn btn-outline-primary btn-block mt-2"><i
                        class="fas fa-history mr-1"></i><?=__('Lịch sử thuê số');?></a>
            </div>


            <div class="col-sm-12 col-lg-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Thuê số tùy chọn');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-4" style="display:<?=$CMSNT->site('server_thuesim') == 'API_5' ? 'none' : 'block';?>;">
                                <div class="form-group">
                                    <label for="email"><?=__('Nhà mạng:');?></label>
                                    <select class="select2 form-control telco" id="telco[]" multiple="multiple"
                                        data-placeholder="<?=__('Tất cả');?>">
                                        <option value="Viettel">Viettel</option>
                                        <option value="Mobifone">Mobifone</option>
                                        <option value="Vietnamobile">Vietnamobile</option>
                                        <option value="Vinaphone">Vinaphone</option>
                                        <option value="ITelecom">ITelecom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4" style="display:<?=$CMSNT->site('server_thuesim') == 'API_5' ? 'none' : 'block';?>;" >
                                <div class="form-group">
                                    <label for="email"><?=__('Đầu số muốn lấy:');?></label>
                                    <select class="select2 form-control phone" id="phone[]" multiple="multiple"
                                        data-placeholder="<?=__('Tất cả');?>">
                                        <option value="032">032</option>
                                        <option value="033">033</option>
                                        <option value="034">034</option>
                                        <option value="035">035</option>
                                        <option value="036">036</option>
                                        <option value="037">037</option>
                                        <option value="038">038</option>
                                        <option value="039">039</option>
                                        <option value="070">070</option>
                                        <option value="079">079</option>
                                        <option value="077">077</option>
                                        <option value="076">076</option>
                                        <option value="078">078</option>
                                        <option value="083">083</option>
                                        <option value="084">084</option>
                                        <option value="085">085</option>
                                        <option value="081">081</option>
                                        <option value="082">082</option>
                                        <option value="056">056</option>
                                        <option value="058">058</option>
                                        <option value="059">059</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <div class="table-responsive">
                                    <table class="table data-table table-hover">
                                        <thead class="table-color-heading">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th><?=__('Dịch vụ');?></th>
                                                <th><?=__('Giá');?></th>
                                                <th><?=__('Thao tác');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `service_otp` WHERE `status` = 1  ") as $row) {?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$row['name'];?></td>
                                                <td><b style="color:red;"><?=format_currency($row['price']);?></b></td>
                                                <td>
                                                    <button
                                                        onclick="modalBuy(`<?=$row['id'];?>`, `<?=$row['name'];?>`, `<?=format_currency($row['price']);?>`)"
                                                        class="btn btn-primary btn-sm"><?=__('Thuê ngay');?></button>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-lg-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Lưu ý');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?=$CMSNT->site('notice_thuesim');?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modalBuy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content" style="background-image:url('<?=base_url($CMSNT->site('bg_card'));?>');">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=__('Thanh toán đơn hàng');?></h5>
                <button type="button" class="close" style="color: red;" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-window-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label><?=__('Dịch vụ');?>:</label>
                    <input type="text" class="form-control" id="name" readonly />
                </div>
                <div class="form-group mb-3">
                    <label><?=__('Số lượng');?>:</label>
                    <input type="number" nchange="totalPayment()" onkeyup="totalPayment()"
                        class="form-control form-control-solid" placeholder="<?=__('Nhập số lượng cần mua');?>"
                        id="amount" />
                    <input type="hidden" value="" readonly class="form-control" id="modal-id">
                    <input class="form-control" type="hidden" id="token"
                        value="<?=isset($getUser) ? $getUser['token'] : '';?>">
                </div>
                <div class="mb-3 text-center" style="font-size: 20px;"><?=__('Tổng tiền cần thanh toán');?>: <b
                        id="total" style="color:red;">0</b></div>
                <div class="text-center mb-3">
                    <button type="submit" id="btnBuy" onclick="buyOTP()" class="btn btn-primary btn-block"><i
                            class="fas fa-credit-card mr-1"></i><?=__('Thanh Toán');?></span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__.'/footer.php');?>

<script>
function buyOTP() {
    var id = $("#modal-id").val();
    var amount = $("#amount").val();
    var token = $("#token").val();
    $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/buyOTP.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            token: token,
            id: id,
            'telco[]': $('select.telco').val(),
            'phone[]': $('select.phone').val(),
            amount: amount
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
                $urlReturn = '<?=BASE_URL('client/otp-history');?>';
                setTimeout("location.href = '" + $urlReturn + "';", 1000);
            } else {
                Swal.fire(
                    '<?=__('Thất bại');?>',
                    data.msg,
                    'error'
                );
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


function totalPayment() {
    $('#total').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>');
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/totalPayment.php");?>",
        method: "POST",
        data: {
            id: $("#modal-id").val(),
            amount: $("#amount").val(),
            token: $("#token").val(),
            store: 'otp-order'
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
}

function modalBuy(id, name, price) {
    $("#modal-id").val(id);
    $("#name").val(name);
    $("#total").html(price);
    $("#amount").val(1);
    $("#modalBuy").modal();
}
</script>