<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Dịch vụ | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
<link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.1/css/bulma.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bulma.min.css" rel="stylesheet" type="text/css"/>
';
$body['footer'] = '
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bulma.min.js"></script>
';
require_once(__DIR__.'/../../../models/is_user.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-7">
                <div class="col-lg-7">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label">Yêu cầu dịch vụ</span>
                            </h3>
                            <div class="row mb-10">
                                <label class="col-lg-4 col-form-label text-lg-end">Chọn dịch vụ:</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="service" onchange="totalPayment()">
                                        <option value="">Chọn dịch vụ</option>
                                        <?php foreach ($CMSNT->get_list("SELECT * FROM `services` WHERE `status` = 1 ") as $option) {?>
                                        <option data-price="<?=$option['price'];?>" value="<?=$option['id'];?>"><?=$option['name'];?> (giá <?=format_currency($option['price']);?>)</option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-10">
                                <label class="col-lg-4 col-form-label text-lg-end">Số lượng:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="number" id="amount"  onkeyup="totalPayment()"
                                        placeholder="Nhập số lượng cần tăng">
                                    <input class="form-control" type="hidden" id="token"
                                        value="<?=$getUser['token'];?>">
                                    <!--<div class="form-text text-muted">Số lượng tối thiểu 1</div>-->
                                </div>
                            </div>
                            <div class="row mb-10">
                                <label class="col-lg-4 col-form-label text-lg-end">Liên kết:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" id="url" placeholder="Nhập link cần tăng">
                                </div>
                            </div>
                            <div class="alert alert-danger mb-8" role="alert">
                                <h3 class="text-center text-white">Thanh toán: <b style="color: yellow;" id="ketqua">0</b>đ</h3>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" id="btnServiceOrder" class="btn btn-primary">TẠO ĐƠN HÀNG</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label">Chi tiết dịch vụ</span>
                            </h3>
                            <div id="load-content" style="display: none;" class="text-center px-5">
								<img src="<?=base_url($CMSNT->site('gif_loading'));?>" width="100px">
							</div>
                            <div id="content"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label">Lịch sử đơn hàng</span>
                            </h3>
                            <div class="table-responsive">
                                <table id="datatable2" class="table is-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Service</th>
                                            <th>Amount</th>
                                            <th>Pay</th>
                                            <th>Url</th>
                                            <th>Createdate</th>
                                            <th>Updatedate</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
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
function totalPayment(){
    var amount = $("#amount").val();
    var price = $('#service').children("option:selected").attr('data-price');
    var ketqua = amount * price;
    $('#ketqua').html(ketqua.toString().replace(/(.)(?=(\d{3})+$)/g, '$1.'));
    $("#load-content").show();
    $.ajax({
        url: "<?=base_url('ajaxs/client/getContentService.php');?>",
        method: "POST",
        data: {
            id: $("#service").val()
        },
        success: function(respone){
            $("#load-content").hide();
            $("#content").html(respone);
        }
    });
}
</script>
<script>
$(document).ready(function() {
    $('#datatable').DataTable();
});
</script>
<script type="text/javascript">
$("#btnServiceOrder").on("click", function() {
    $('#btnServiceOrder').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/service-order.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            id: $("#service").val(),
            amount: $("#amount").val(),
            url: $("#url").val(),
            token: $("#token").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                setTimeout("location.href = '';", 1000);
            } else {
                cuteToast({
                    type: "error",
                    message: respone.msg,
                    timer: 5000
                });
            }
            $('#btnServiceOrder').html('TẠO ĐƠN HÀNG').prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
            $('#btnServiceOrder').html('TẠO ĐƠN HÀNG').prop('disabled', false);
        }

    });
});
</script>
<script>
$(function() {
    $('#datatable2').DataTable( {
        ajax: '<?=base_url('ajaxs/client/services.php');?>',
        dataSrc: 'data',
        columns: [
            { data: 'stt' },
            { data: 'service_id' },
            { data: 'amount' },
            { data: 'pay' },
            { data: 'url' },
            { data: 'create_date' },
            { data: 'update_date' },
            { data: 'status' }
        ]
    } );
});
</script>