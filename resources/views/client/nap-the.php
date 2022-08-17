<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Nạp Thẻ').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
if ($CMSNT->site('status_napthe') != 1) {
    redirect(base_url(''));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <div class="header-title">
                            <h4 class="card-title mb-0"><?=__('Nạp Thẻ');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Loại thẻ');?></label>
                            <div class="col-lg-8 fv-row">
                                <select class="form-control" id="telco">
                                    <option value="">-- <?=__('Chọn loại thẻ');?> --</option>
                                    <option value="VIETTEL">Viettel</option>
                                    <option value="VINAPHONE">Vinaphone</option>
                                    <option value="MOBIFONE">Mobifone</option>
                                    <option value="VNMOBI">Vietnamobile</option>
                                    <option value="ZING">Zing</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Mệnh giá');?></label>
                            <div class="col-lg-8 fv-row">
                                <select class="form-control" onchange="totalPrice()" id="amount">
                                    <option value="">-- <?=__('Chọn mệnh giá');?> --</option>
                                    <option value="10000">10.000đ</option>
                                    <option value="20000">20.000đ</option>
                                    <option value="30000">30.000đ</option>
                                    <option value="50000">50.000đ</option>
                                    <option value="100000">100.000đ</option>
                                    <option value="200000">200.000đ</option>
                                    <option value="300000">300.000đ</option>
                                    <option value="500000">500.000đ</option>
                                    <option value="1000000">1.000.000đ</option>
                                    <option value="2000000">2.000.000đ</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Serial');?></label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" id="serial" class="form-control"
                                    placeholder="<?=__('Nhập serial thẻ');?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Pin');?></label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" id="pin" class="form-control"
                                    placeholder="<?=__('Nhập mã thẻ');?>" />
                                <input type="hidden" id="token" class="form-control" value="<?=$getUser['token'];?>" />
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="alert bg-white alert-info" role="alert">
                                <div class="iq-alert-icon">
                                    <i class="ri-alert-line"></i>
                                </div>
                                <div class="iq-alert-text"><?=__('Số tiền thực nhận');?>: <b id="ketqua" style="color: red;">0</b></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 fv-row text-center">
                                <button type="button" id="btnSubmit"
                                    class="btn btn-danger"><?=__('Nạp Thẻ');?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function totalPrice(){
                    var total = 0;
                    var amount =  $("#amount").val();
                    total = amount - amount * <?=$CMSNT->site('ck_napthe');?> / 100;
                    $('#ketqua').html(total.toString().replace(/(.)(?=(\d{3})+$)/g, '$1.'));
                }
            </script>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <div class="header-title">
                            <h4 class="card-title mb-0"><?=__('Lưu Ý');?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?=$CMSNT->site('notice_napthe');?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Lịch sử nạp thẻ');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><?=__('Nhà mạng');?></th>
                                        <th><?=__('Serial');?></th>
                                        <th><?=__('Pin');?></th>
                                        <th><?=__('Mệnh giá');?></th>
                                        <th><?=__('Thực nhận');?></th>
                                        <th><?=__('Trạng thái');?></th>
                                        <th><?=__('Thời gian');?></th>
                                        <th><?=__('Lý do');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `cards` WHERE `user_id` = '".$getUser['id']."' ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><img width="100px" src="<?=BASE_URL('assets/img/'.$row['telco'].'.png');?>">
                                        </td>
                                        <td><?=$row['serial'];?></td>
                                        <td><?=$row['pin'];?></td>
                                        <td><b style="color: red;"><?=format_currency($row['amount']);?></b></td>
                                        <td><b style="color: green;"><?=format_currency($row['price']);?></b></td>
                                        <td><?=display_card($row['status']);?></td>
                                        <td><?=$row['create_date'];?></td>
                                        <td><?=$row['reason'];?></td>
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
</div>


 
<script type="text/javascript">
$("#btnSubmit").on("click", function() {
    $('#btnSubmit').html('<i class="fa fa-spinner fa-spin"></i> <?=__("Đang xử lý...");?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL('ajaxs/client/napthe.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            token: $('#token').val(),
            serial: $('#serial').val(),
            pin: $('#pin').val(),
            telco: $('#telco').val(),
            amount: $('#amount').val()
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
            $('#btnSubmit').html('<?=__('Nạp Thẻ');?>').prop('disabled', false);
        }
    })
});
</script>

<?php require_once(__DIR__.'/footer.php');?>