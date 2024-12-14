<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Danh sách ngân hàng',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
$body['footer'] = '
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
    $(".select2").select2()
    $(".select2bs4").select2({
        theme: "bootstrap4"
    });
});
</script>
<!-- bs-custom-file-input -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script> 
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['ThemNganHang'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $url_image = '';
    if (check_img('image') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = 'assets/storage/images/bank/'.$rand.'.png';
        $tmp_name = $_FILES['image']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $url_image = 'assets/storage/images/bank/'.$rand.'.png';
        }
    }
    $isInsert = $CMSNT->insert("banks", [
        'image'         => $url_image,
        'short_name'    => check_string($_POST['short_name']),
        'accountNumber' => check_string($_POST['accountNumber']),
        'accountName'   => check_string($_POST['accountName'])
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm ngân hàng (".$_POST['short_name']." - ".$_POST['account_number'].") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){window.history.back().location.reload();}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
 
if (isset($_POST['SaveSettings'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    foreach ($_POST as $key => $value) {
        $CMSNT->update("settings", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
} ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách ngân hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách ngân hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <?php if(time() - $CMSNT->site('check_time_cron_bank') >= 120):?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/bank.php');?>"
                    target="_blank"><?=base_url('cron/bank.php');?></a> theo hướng dẫn tại <a href="https://help.cmsnt.co/huong-dan/huong-dan-xu-ly-khi-website-bao-loi-cron/" target="_blank">đây</a>.
            </div>
            <?php endif?>
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-university mr-1"></i>
                                THÔNG TIN THANH TOÁN NGÂN HÀNG & VÍ ĐIỆN TỬ
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th>ShortName</th>
                                        <th>Account Number</th>
                                        <th>Account Name</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($CMSNT->get_list("SELECT * FROM `banks`  ") as $bank) {?>
                                    <tr>
                                        <td><?=$bank['id'];?></td>
                                        <td><?=$bank['short_name'];?></td>
                                        <td><?=$bank['accountNumber'];?></td>
                                        <td><?=$bank['accountName'];?></td>
                                        <td><a aria-label="" href="<?=base_url('admin/bank-edit/'.$bank['id']);?>"
                                                style="color:white;" class="btn btn-info btn-sm btn-icon-left m-b-10"
                                                type="button">
                                                <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                            </a>
                                            <button style="color:white;" onclick="RemoveRow('<?=$bank['id'];?>')"
                                                class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <section class="col-lg-5 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-university mr-1"></i>
                                THÊM NGÂN HÀNG
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngân hàng</label>
                                    <select class="form-control select2bs4" name="short_name" required>
                                        <option value="">Chọn ngân hàng</option>
                                        <?php foreach ($config_listbank as $key => $value) {?>
                                        <option value="<?=$key;?>"><?=$value;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image" required>
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số tài khoản</label>
                                    <input type="text" class="form-control" name="accountNumber"
                                        placeholder="Nhập số tài khoản" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên chủ tài khoản</label>
                                    <input type="text" class="form-control" name="accountName"
                                        placeholder="Nhập tên chủ tài khoản" required>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="ThemNganHang" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Thêm Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-gear mr-1"></i>
                                CẤU HÌNH NẠP TIỀN NGÂN HÀNG TỰ ĐỘNG
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status_bank">
                                        <option <?=$CMSNT->site('status_bank') == 0 ? 'selected' : '';?> value="0">OFF
                                        </option>
                                        <option <?=$CMSNT->site('status_bank') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                    </select>
                                    <i>Chọn OFF hệ thống sẽ tạm dừng auto bank.</i>
                                </div>
                                <div class="form-group">
                                    <label>Server 1</label>
                                    <select class="form-control select2bs4" name="sv1_autobank">
                                        <option <?=$CMSNT->site('sv1_autobank') == 0 ? 'selected' : '';?> value="0">OFF
                                        </option>
                                        <option <?=$CMSNT->site('sv1_autobank') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                    </select>
                                    <i>Nạp tiền bằng hoá đơn, quét QR code...</i><br>
                                </div>
                                <div class="form-group">
                                    <label>Server 2</label>
                                    <select class="form-control select2bs4" name="sv2_autobank">
                                        <option <?=$CMSNT->site('sv2_autobank') == 0 ? 'selected' : '';?> value="0">OFF
                                        </option>
                                        <option <?=$CMSNT->site('sv2_autobank') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                    </select>
                                    <i>Nạp tiền theo nội dung + id, quét QR code...</i><br>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung nạp server2</label>
                                    <input type="text" class="form-control" name="prefix_autobank"
                                        value="<?=$CMSNT->site('prefix_autobank');?>" placeholder="VD: naptien"
                                        required>
                                    <i>Chỉ áp dụng cho server 2</i>
                                </div>
                                <p>-------- CÓ THỂ DÙNG 1 LÚC 2 SERVER ĐỂ ĐA DẠNG CÁCH NẠP -----------</p>
                                <div class="form-group">
                                    <label>Ngân hàng</label>
                                    <select class="form-control select2bs4" name="type_bank">
                                        <?php foreach ($config_listbank_auto as $key => $value) {?>
                                        <option <?=$CMSNT->site('type_bank') == $key ? 'selected' : '';?>
                                            value="<?=$key;?>"><?=$value;?>
                                        </option>
                                        <?php }?>
                                    </select>
                                    <i>Chọn ngân hàng bạn cần sử dụng.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Token Bank (<a type="button" data-toggle="modal"
                                            data-target="#modal-hd-auto-bank" href="#">Xem
                                            hướng dẫn</a>)</label>
                                    <input type="text" class="form-control" name="token_bank"
                                        value="<?=$CMSNT->site('token_bank');?>" placeholder="Nhập token ngân hàng">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số tài khoản (<a type="button" data-toggle="modal"
                                            data-target="#modal-hd-auto-bank" href="#">Xem
                                            hướng dẫn</a>)</label>
                                    <input type="text" class="form-control" name="stk_bank"
                                        value="<?=$CMSNT->site('stk_bank');?>"
                                        placeholder="Nhập số tài khoản ngân hàng cần Auto">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu Internet Banking (<a type="button"
                                            data-toggle="modal" data-target="#modal-hd-auto-bank" href="#">Xem
                                            hướng dẫn</a>)</label>
                                    <input type="text" class="form-control" name="mk_bank"
                                        value="<?=$CMSNT->site('mk_bank');?>"
                                        placeholder="Nhập mật khẩu internet banking">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung nạp server1</label>
                                    <input type="text" class="form-control" name="prefix_invoice"
                                        value="<?=$CMSNT->site('prefix_invoice');?>"
                                        placeholder="Tiền tố nội dung nạp tiền">
                                    <i>Chỉ áp dụng cho server 1</i>
                                </div> -->
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left btn-block m-b-10"
                                    type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-gear mr-1"></i>
                                CẤU HÌNH NẠP TIỀN VÍ MOMO TỰ ĐỘNG
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status_momo">
                                        <option <?=$CMSNT->site('status_momo') == 0 ? 'selected' : '';?> value="0">OFF
                                        </option>
                                        <option <?=$CMSNT->site('status_momo') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                    </select>
                                    <i>Chọn OFF hệ thống sẽ tạm dừng auto momo.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Token MOMO (<a type="button" data-toggle="modal"
                                            data-target="#modal-hd-auto-momo" href="#">Xem
                                            hướng dẫn</a>)</label>
                                    <input type="text" class="form-control" name="token_momo"
                                        value="<?=$CMSNT->site('token_momo');?>" placeholder="Nhập token ví momo">
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left btn-block m-b-10"
                                    type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-gear mr-1"></i>
                                CẤU HÌNH NẠP TIỀN VÍ ZALO PAY TỰ ĐỘNG
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status_zalopay">
                                        <option <?=$CMSNT->site('status_zalopay') == 0 ? 'selected' : '';?> value="0">
                                            OFF
                                        </option>
                                        <option <?=$CMSNT->site('status_zalopay') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                    </select>
                                    <i>Chọn OFF hệ thống sẽ tạm dừng auto zalo pay.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Token Zalo Pay</label>
                                    <input type="text" class="form-control" name="token_zalopay"
                                        value="<?=$CMSNT->site('token_zalopay');?>" placeholder="Nhập token zalo pay">
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left btn-block m-b-10"
                                    type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-gear mr-1"></i>
                                CẤU HÌNH NẠP TIỀN VÍ THESIEURE TỰ ĐỘNG
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status_thesieure">
                                        <option <?=$CMSNT->site('status_thesieure') == 0 ? 'selected' : '';?> value="0">
                                            OFF
                                        </option>
                                        <option <?=$CMSNT->site('status_thesieure') == 1 ? 'selected' : '';?> value="1">
                                            ON
                                        </option>
                                    </select>
                                    <i>Chọn OFF hệ thống sẽ tạm dừng auto thesieure.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Token THESIEURE</label>
                                    <input type="text" class="form-control" name="token_thesieure"
                                        value="<?=$CMSNT->site('token_thesieure');?>"
                                        placeholder="Nhập token thesieure.com">
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left btn-block m-b-10"
                                    type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-hd-auto-bank">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HƯỚNG DẪN TÍCH HỢP NẠP TIỀN TỰ ĐỘNG QUA NGÂN HÀNG</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Bước 1: Truy cập vào <a target="_blank"
                            href="https://api.web2m.com/Register.html?ref=113">đây</a> để <b>đăng ký</b> tài khoản và
                        <b>đăng nhập</b>.
                    </li>
                    <li>Bước 2: Chọn ngân hàng bạn muốn kết nối Auto, sau đó nhấn vào nút <b>Thêm tài khoản {tên ngân
                            hàng}</b>.</li>
                    <li>Bước 3: Nhập đầy đủ thông tin đăng nhập Internet Banking của bạn vào form để tiến hành kết nối.
                    </li>
                    <li>Bước 4: Nhấn vào <b>Lấy Token</b> sau đó check email để copy <b>Token</b> vừa lấy.</li>
                    <li>Bước 5: Dán <b>Token</b> vào ô <b>Token Bank</b> trong website của bạn.</li>
                    <li>Bước 6: Nhập số tài khoản của bạn vừa kết nối vào ô <b>Số tài khoản</b>.</li>
                    <li>Bước 7: Nhập mật khẩu Internet Banking vào ô <b>Mật khẩu Internet Banking</b> và nhấn lưu.</li>
                    <li>Bước 8: Quay lại <a target="_blank" href="https://api.web2m.com/Home/nangcap">đây</a> và tiến
                        hành gia hạn gói Bank mà bạn cần dùng để bắt đầu sử dụng Auto.</li>
                </ul>
                <p>Hướng dẫn bằng Video xem tại <a target="_blank"
                        href="https://www.youtube.com/watch?v=N8CuOJTD6l8">đây</a>.</p>
                <h4 class="text-center">Chúc quý khách thành công <img
                        src="https://i.pinimg.com/736x/c4/2c/98/c42c983e8908fdbd6574c2135212f7e4.jpg" width="45px;">
                </h4>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-hd-auto-momo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HƯỚNG DẪN TÍCH HỢP NẠP TIỀN TỰ ĐỘNG QUA VÍ MOMO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Hướng dẫn lấy Token MOMO để cài Auto.</p>
                <ul>
                    <li>Bước 1: Truy cập vào <a target="_blank"
                            href="https://api.web2m.com/Register.html?ref=113">đây</a> để <b>đăng ký</b> tài khoản và
                        <b>đăng nhập</b>.
                    </li>
                    <li>Bước 2: Chọn ngân hàng bạn muốn kết nối Auto, sau đó nhấn vào nút <b>Thêm tài khoản MoMo</b>.
                    </li>
                    <li>Bước 3: Nhập đầy đủ thông tin đăng nhập MoMo của bạn vào form để tiến hành kết nối.</li>
                    <li>Bước 4: Nhấn vào <b>Lấy Token</b> sau đó check email để copy <b>Token</b> vừa lấy.</li>
                    <li>Bước 5: Dán <b>Token</b> vào ô <b>Token MOMO</b> trong website của bạn và nhấn Lưu.</li>
                    <li>Bước 6: Quay lại <a target="_blank" href="https://api.web2m.com/Home/nangcap">đây</a> và tiến
                        hành gia hạn gói MOMO và bắt đầu sử dụng Auto.</li>
                    <li>Hướng dẫn bằng Video xem tại <a target="_blank"
                            href="https://www.youtube.com/watch?v=5WRqOmxzBPc">đây</a>.</li>
                </ul>
                <!-- <p>Hướng dẫn lấy mã QR MOMO</p>
                <ul>
                    <li>Bước 1: Truy cập App <b>MOMO</b> -> <b>Ví của tôi</b> -> nhấn vào <b>Tên Chủ Ví</b> ở dòng đầu
                        tiên trong ví MOMO của bạn.</li>
                    <li>Bước 2: Kéo xuống dưới cùng chọn <b>Mã NHẬN TIỀN của tôi</b> -> nhấn <b>lưu hình</b>.</li>
                    <li>Bước 3: Sau khi lưu hình bạn vào <a target="_blank" href="https://imgur.com/upload?beta">đây</a>
                        để up hình vừa lưu lên cloud.</li>
                    <li>Bước 4: Sau khi up lên cloud imgur bạn rê chuột phải vào ảnh chọn <b>copy địa chỉ hình ảnh</b>
                        (hoặc tiếng anh có nghĩa tương tự) để tiến hành copy link ảnh .jpg hoặc .png.</li>
                    <li>Bước 5: Dán link ảnh vừa copy vào ô <b>QR CODE</b>.</li>
                </ul> -->
                <h4 class="text-center">Chúc quý khách thành công <img
                        src="https://i.pinimg.com/736x/c4/2c/98/c42c983e8908fdbd6574c2135212f7e4.jpg" width="45px;">
                </h4>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
<script type="text/javascript">
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Ngân Hàng",
        message: "Bạn có chắc chắn muốn xóa ngân hàng ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/removeBank.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
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
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
</script>