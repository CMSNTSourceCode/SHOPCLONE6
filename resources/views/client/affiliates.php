<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Chương trình giới thiệu').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
';
$body['footer'] = '

';
if($CMSNT->site('status_ref') != 1){
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
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <ul class="nav nav-pills mb-3 nav-fill" id="pills-tab-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab-fill" data-toggle="pill"
                                    href="#pills-home-fill" role="tab" aria-controls="pills-home"
                                    aria-selected="true"><?=mb_strtoupper(__('TỔNG QUAN'), 'UTF-8');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab-fill" data-toggle="pill"
                                    href="#pills-profile-fill" role="tab" aria-controls="pills-profile"
                                    aria-selected="false"><?=mb_strtoupper(__('THÀNH VIÊN'), 'UTF-8');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab-fill" data-toggle="pill"
                                    href="#pills-contact-fill" role="tab" aria-controls="pills-contact"
                                    aria-selected="false"><?=mb_strtoupper(__('RÚT TIỀN'), 'UTF-8');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="lich-su-tab-fill" data-toggle="pill"
                                    href="#lich-su-fill" role="tab" aria-controls="lich-su"
                                    aria-selected="false"><?=mb_strtoupper(__('LỊCH SỬ'), 'UTF-8');?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="tab-content" id="pills-tabContent-1">
                    <div class="tab-pane fade show active" id="pills-home-fill" role="tabpanel"
                        aria-labelledby="pills-home-tab-fill">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <p class="mb-2 text-secondary"><?=__('TỔNG SỐ CLICK');?></p>
                                                <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                    <h5 class="mb-0 font-weight-bold">
                                                        <?=format_cash($getUser['ref_click']);?> <?=__('View');?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <p class="mb-2 text-secondary"><?=__('ĐĂNG KÝ MỚI');?></p>
                                                <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                    <h5 class="mb-0 font-weight-bold">
                                                        <?=format_cash($CMSNT->get_row(" SELECT COUNT(id) FROM `users` WHERE `ref_id` = '".$getUser['id']."' ")['COUNT(id)']);?> <?=__('User');?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <p class="mb-2 text-secondary"><?=__('HOA HỒNG ĐÃ NHẬN');?></p>
                                                <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                    <h5 class="mb-0 font-weight-bold">
                                                        <?=format_currency($getUser['ref_total_money']);?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-5">
                                           <b><?=__('THÔNG TIN CHI TIẾT');?></b>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4 align-self-center"
                                                for="email"><?=__('Email:');?></label>
                                            <div class="col-sm-8">
                                                <b> <?=$getUser['email'];?></b>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4 align-self-center"
                                                for="email"><?=__('Mức hoa hồng:');?></label>
                                            <div class="col-sm-8">
                                                <?php
                                                    $ck = $CMSNT->site('ck_ref');
                                                    if($getUser['ref_ck'] != 0){
                                                        $ck = $getUser['ref_ck'];
                                                    }
                                                ?>
                                                <b style="color: red;"><?=$ck;?>%</b>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4 align-self-center"
                                                for="email"><?=__('Số dư hoa hồng khả dụng:');?></label>
                                            <div class="col-sm-8">
                                                <b style="color: blue;"><?=format_currency($getUser['ref_money']);?></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-5">
                                            <b><?=__('LINK GIỚI THIỆU CỦA BẠN');?></b>
                                        </div>
                                        <div class="input-group mb-4">
                                            <input type="text" class="form-control" id="urlRef" readonly
                                                value="<?=BASE_URL('join/'.$getUser['id']);?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary copy" data-clipboard-target="#urlRef"
                                                    onclick="copy()" type="button"><?=__('COPY');?></button>
                                            </div>
                                        </div>
                                        <i><?=__('Sao chép địa chỉ này và chia sẻ đến bạn bè của bạn.');?>
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-5">
                                            <b><?=mb_strtoupper(__('LƯU Ý'), 'UTF-8');?></b>
                                        </div>
                                        <?=$CMSNT->site('notice_ref');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile-fill" role="tabpanel"
                        aria-labelledby="pills-profile-tab-fill">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <b><?=mb_strtoupper(__('DANH SÁCH BẠN BÈ ĐƯỢC BẠN GIỚI THIỆU'), 'UTF-8');?></b>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table data-table table-striped mb-0">
                                        <thead class="table-color-heading">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th><?=__('TÊN ĐĂNG NHẬP');?></th>
                                                <th><?=__('THỜI GIAN THAM GIA');?></th>
                                                <th><?=__('HOA HỒNG NHẬN ĐƯỢC');?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `users` WHERE `ref_id` = '".$getUser['id']."'  ") as $row) {?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$row['username'];?></td>
                                                <td><?=$row['create_date'];?></td>
                                                <td><b style="color: green;"><?=format_cash($row['ref_amount']);?></b>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact-fill" role="tabpanel"
                        aria-labelledby="pills-contact-tab-fill">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <b><?=mb_strtoupper(__('TẠO YÊU CẦU RÚT TIỀN'), 'UTF-8');?></b>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Ngân hàng:');?></label>
                                            <div class="col-lg-8 fv-row">
                                                <select class="form-control" id="bank">
                                                    <option value="">-- <?=__('Chọn ngân hàng cần rút');?> --</option>
                                                    <?php $listbank = explode(PHP_EOL, $CMSNT->site('listbank_ref')); ?>
                                                    <?php foreach($listbank as $value):?>
                                                    <option value="<?=$value;?>"><?=$value;?></option>
                                                    <?php endforeach?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Số tài khoản:');?></label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="stk" class="form-control"
                                                    placeholder="<?=__('Nhập số tài khoản cần rút');?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Chủ tài khoản:');?></label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="name" class="form-control"
                                                    placeholder="<?=__('Nhập tên chủ tài khoản');?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Số tiền cần rút:');?></label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="number" id="amount" class="form-control"
                                                    placeholder="<?=__('Nhập số dư hoa hồng cần rút');?>" />
                                                    
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 fv-row text-center">
                                                <input type="hidden" id="token" class="form-control"
                                                    value="<?=$getUser['token'];?>" />
                                                <button type="button" id="btnRutTien" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-money-check-alt"></i>
                                                    <?=__('RÚT NGAY');?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-5">
                                            <b><?=__('THÔNG TIN CHI TIẾT');?></b>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4 align-self-center"
                                                for="email"><?=__('Email:');?></label>
                                            <div class="col-sm-8">
                                                <b> <?=$getUser['email'];?></b>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4 align-self-center"
                                                for="email"><?=__('Mức hoa hồng:');?></label>
                                            <div class="col-sm-8">
                                                <b style="color: red;"><?=$CMSNT->site('ck_ref');?>%</b>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4 align-self-center"
                                                for="email"><?=__('Số dư hoa hồng khả dụng:');?></label>
                                            <div class="col-sm-8">
                                                <b style="color: blue;"><?=format_currency($getUser['ref_money']);?></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <b><?=mb_strtoupper(__('DANH SÁCH ĐƠN RÚT TIỀN'), 'UTF-8');?></b>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table data-table table-striped mb-0">
                                                <thead class="table-color-heading">
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th><?=__('SỐ TIỀN RÚT');?></th>
                                                        <th><?=__('NGÂN HÀNG');?></th>
                                                        <th><?=__('THỜI GIAN');?></th>
                                                        <th><?=__('TRẠNG THÁI');?></th>
                                                        <th><?=__('LÝ DO');?></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `withdraw_ref` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC ") as $row) {?>
                                                    <tr>
                                                        <td><?=$i++;?></td>
                                                        <td><?=format_currency($row['amount']);?></td>
                                                        <td><?=$row['bank'];?> - <?=$row['stk'];?></td>
                                                        <td><?=$row['create_gettime'];?></td>
                                                        <td><?=display_card($row['status']);?></td>
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
                    <div class="tab-pane fade" id="lich-su-fill" role="tabpanel"
                        aria-labelledby="lich-su-tab-fill">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <b><?=mb_strtoupper(__('LỊCH SỬ HOA HỒNG'), 'UTF-8');?></b>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table data-table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th><?=__('Số tiền trước');?></th>
                                            <th><?=__('Số tiền thay đổi');?></th>
                                            <th><?=__('Số tiền hiện tại');?></th>
                                            <th><?=__('Thời gian');?></th>
                                            <th><?=__('Nội dung');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `log_ref` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC  ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><b
                                                    style="color: green;"><?=format_currency($row['sotientruoc']);?></b>
                                            </td>
                                            <td><b
                                                    style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b>
                                            </td>
                                            <td><b
                                                    style="color: blue;"><?=format_currency($row['sotienhientai']);?></b>
                                            </td>
                                            <td><i><?=$row['create_gettime'];?></i></td>
                                            <td><i><?=$row['reason'];?></i></td>
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
    </div>
</div>


<?php require_once(__DIR__.'/footer.php');?>

<script type="text/javascript">
$("#btnRutTien").on("click", function() {
    $('#btnRutTien').html('<i class="fa fa-spinner fa-spin"></i> <?=__("Đang xử lý...");?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL('ajaxs/client/rut-tien-ref.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            token: $('#token').val(),
            bank: $('#bank').val(),
            stk: $('#stk').val(),
            name: $('#name').val(),
            amount: $('#amount').val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                Swal.fire({
                    title: '<?=__('Thành công');?>',
                    icon: 'success',
                    text: respone.msg,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire(
                    '<?=__('Thất bại');?>',
                    respone.msg,
                    'error'
                );
            }
            $('#btnRutTien').html('<i class="fas fa-money-check-alt"></i> <?=__('RÚT NGAY');?>')
                .prop('disabled', false);
        }
    })
});
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
</script>