<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Edit user',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- DataTables  & Plugins -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/jszip/jszip.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/vfs_fonts.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';
require_once(__DIR__.'/../../../models/is_admin.php'); // check quyền admin
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_GET['id'])) {
    $CMSNT = new DB();
    $id = check_string($_GET['id']);
    $user = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '$id' ");
    if (!$user) {
        die('ID user không tồn tại trong hệ thống');
    }
    // submit form edit
    if (isset($_POST['email'])) {
        $Mobile_Detect = new Mobile_Detect();
        
        if ($CMSNT->site('status_demo') != 0) {
            die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
        }
        if(check_string($_POST['chietkhau']) > 100){
            die('<script type="text/javascript">if(!alert("Chiết khấu giảm giá không được lớn hơn 100")){window.history.back().location.reload();}</script>');
        }
        if(check_string($_POST['username']) != $user['username']){
            if($CMSNT->get_row(" SELECT * FROM `users` WHERE `username` = '".check_string($_POST['username'])."' AND `id` != '".$user['id']."' ")){
                die('<script type="text/javascript">if(!alert("Tên đăng nhập này đã có người sử dụng")){window.history.back().location.reload();}</script>');
            }
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'createdate'    => gettime(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'ip'            => myip(),
                'action'        => '[Admin] Thay đổi username cho thành viên '.$user['username'].'['.$user['id'].'] từ '.$user['username'].' -> '.check_string($_POST['username']).'.'
            ]);
            $CMSNT->insert("logs", [
                'user_id'       => $user['id'],
                'createdate'    => gettime(),
                'action'        => 'Bạn được Admin thay đổi username.'
            ]);
        }
        if(check_string($_POST['admin']) != $user['admin']){
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'createdate'    => gettime(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'ip'            => myip(),
                'action'        => '[Admin] Thay đổi quyền Admin cho thành viên '.$user['username'].'['.$user['id'].'] từ '.$user['admin'].' -> '.check_string($_POST['admin']).'.'
            ]);
            $CMSNT->insert("logs", [
                'user_id'       => $user['id'],
                'createdate'    => gettime(),
                'action'        => 'Bạn được Admin thay đổi quyền Admin.'
            ]);
        }
        if(check_string($_POST['ctv']) != $user['ctv']){
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'createdate'    => gettime(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'ip'            => myip(),
                'action'        => '[Admin] Thay đổi quyền CTV cho thành viên '.$user['username'].'['.$user['id'].'] từ '.$user['ctv'].' -> '.check_string($_POST['ctv']).'.'
            ]);
            $CMSNT->insert("logs", [
                'user_id'       => $user['id'],
                'createdate'    => gettime(),
                'action'        => 'Bạn được Admin thay đổi quyền CTV.'
            ]);
        }
        if($_POST['chietkhau'] != $user['chietkhau']){
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'createdate'    => gettime(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'ip'            => myip(),
                'action'        => '[Admin] Thay đổi chiết khấu thành viên '.$user['username'].' từ '.$user['chietkhau'].'% -> '.check_string($_POST['chietkhau']).'%.'
            ]);
            $CMSNT->insert("logs", [
                'user_id'       => $user['id'],
                'createdate'    => gettime(),
                'action'        => 'Bạn được Admin thay đổi chiết khấu.'
            ]);
        }
        if($_POST['ref_ck'] != $user['ref_ck']){
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'createdate'    => gettime(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'ip'            => myip(),
                'action'        => '[Admin] Thay đổi chiết khấu giới thiệu của user '.$user['username'].' từ '.$user['ref_ck'].'% -> '.check_string($_POST['ref_ck']).'%.'
            ]);
            $CMSNT->insert("logs", [
                'user_id'       => $user['id'],
                'createdate'    => gettime(),
                'action'        => 'Bạn được Admin thay đổi chiết khấu giới thiệu.'
            ]);
        }
        $DBUser = new users();
        $isUpdate = $DBUser->update_by_id([
            'login_attempts'    => 0,
            'username'     => check_string($_POST['username']),
            'email'     => check_string($_POST['email']),
            'spin'      => check_string($_POST['spin']),
            'token'     => check_string($_POST['token']),
            'active'    => check_string($_POST['active']),
            'phone'     => check_string($_POST['phone']),
            'ref_money' => check_string($_POST['ref_money']),
            'ref_total_money' => check_string($_POST['ref_total_money']),
            'ref_click' => check_string($_POST['ref_click']),
            'status_2fa'    => check_string($_POST['status_2fa']),
            'gender'    => check_string($_POST['gender']),
            'admin'     => check_string($_POST['admin']),
            'ctv'       => check_string($_POST['ctv']),
            'chietkhau' => check_string($_POST['chietkhau']),
            'ref_ck' => check_string($_POST['ref_ck']),
            'banned'    => check_string($_POST['banned'])
        ], $user['id']);
        if ($isUpdate) {
            if (!empty($_POST['password'])) {
                $DBUser->update_by_id([
                    'password' => TypePassword(check_string($_POST['password']))
                ], $user['id']);
            }
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'createdate'    => gettime(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'ip'            => myip(),
                'action'        => '[Admin] Cập nhật thông tin thành viên '.$user['username'].'['.$user['id'].'].'
            ]);
            $CMSNT->insert("logs", [
                'user_id'       => $user['id'],
                'createdate'    => gettime(),
                'action'        => __('Bạn được Admin thay đổi thông tin.')
            ]);
            die('<script type="text/javascript">if(!alert("Cập nhật thông tin thành công")){window.history.back().location.reload();}</script>');
        }
    }
    if (isset($_POST['cong_tien'])) {
        if ($CMSNT->site('status_demo') != 0) {
            die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
        }
        if ($_POST['amount'] <= 0) {
            die('<script type="text/javascript">if(!alert("Amount không hợp lệ !")){window.history.back().location.reload();}</script>');
        }
        $Mobile_Detect = new Mobile_Detect();
        $amount = check_string($_POST['amount']);
        $reason = check_string($_POST['reason']);
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'createdate'    => gettime(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'ip'            => myip(),
            'action'        => '[Admin] Cộng '.$amount.' cho User '.$user['username'].'['.$user['id'].'].'
        ]);
        /* Xử lý cộng tiền */
        $DBUser = new users();
        $DBUser->AddCredits($id, $amount, '[Admin]'.$reason, 'ADMIN_ADD_CREDITS_'.uniqid());
        die('<script type="text/javascript">if(!alert("Cộng tiền thành công !")){window.history.back().location.reload();}</script>');
    }
    if (isset($_POST['tru_tien'])) {
        if ($CMSNT->site('status_demo') != 0) {
            die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
        }
        if ($_POST['amount'] <= 0) {
            die('<script type="text/javascript">if(!alert("Amount không hợp lệ !")){window.history.back().location.reload();}</script>');
        }
        $Mobile_Detect = new Mobile_Detect();
        $amount = check_string($_POST['amount']);
        $reason = check_string($_POST['reason']);
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'createdate'    => gettime(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'ip'            => myip(),
            'action'        => '[Admin] Trừ '.$amount.' cho User '.$user['username'].'['.$user['id'].'].'
        ]);
        /* Xử lý trừ tiền */
        $DBUser = new users();
        $DBUser->RemoveCredits($id, $amount, '[Admin]'.$reason, 'ADMIN_REMOVE_CREDITS_'.uniqid());
        die('<script type="text/javascript">if(!alert("Trừ tiền thành công !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit User: <?=$user['username'];?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/users');?>">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a type="button" href="<?=base_url_admin('logs&user_id='.$user['id']);?>" target="_blank"
                class="btn btn-hero btn-primary me-1 mb-3 push">
                <i class="fa fa-fw fa-history me-1"></i> <?=__('Nhật ký hoạt động');?>
            </a>
            <a type="button" href="<?=base_url_admin('dong-tien&user_id='.$user['id']);?>" target="_blank"
                class="btn btn-hero btn-info me-1 mb-3 push">
                <i class="fa fa-fw fa-history me-1"></i> <?=__('Biến động số dư');?>
            </a>
            <a type="button" href="<?=base_url_admin('product-order&buyer='.$user['id']);?>" target="_blank"
                class="btn btn-hero btn-danger me-1 mb-3 push">
                <i class="fa-solid fa-cart-shopping"></i> <?=__('Đơn hàng');?>
            </a>
            <a type="button" href="<?=base_url_admin('statistic&user_id='.$user['id']);?>" target="_blank"
                class="btn btn-hero btn-warning me-1 mb-3 push">
                <i class="fa-solid fa-chart-column"></i> <?=__('Thống kê');?>
            </a>
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-edit mr-1"></i>
                                CHỈNH SỬA THÀNH VIÊN
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
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Username (*)</label>
                                    <input type="text" class="form-control" value="<?=$user['username'];?>"
                                        name="username" required>
                                </div>
                                <div class="form-group">
                                    <label>Email (*)</label>
                                    <input type="email" class="form-control" value="<?=$user['email'];?>" name="email"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Token (*)</label>
                                    <input type="text" class="form-control" value="<?=$user['token'];?>" name="token"
                                        required>
                                    <i>Không được để lộ Token của thành viên tránh hacker chiếm quyền đăng nhập bằng
                                        token.</i>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Mật khẩu (*)</label>
                                            <input type="text" class="form-control" placeholder="**********"
                                                name="password">
                                            <i>Nhập mật khẩu cần thay đổi, hệ thống sẽ tự động mã hoá (để trống nếu
                                                không muốn
                                                thay đổi)</i>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Secret Key Google 2FA</label>
                                            <input type="text" class="form-control" value="<?=$user['SecretKey_2fa'];?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ON/OFF Google 2FA (*)</label>
                                            <select class="form-control select2bs4" name="status_2fa">
                                                <option <?=$user['status_2fa'] == 1 ? 'selected' : '';?> value="1">
                                                    ON
                                                </option>
                                                <option <?=$user['status_2fa'] == 0 ? 'selected' : '';?> value="0">
                                                    OFF</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Lượt quay (*)</label>
                                            <input type="number" class="form-control" value="<?=$user['spin'];?>"
                                                name="spin">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Số điện thoại (*)</label>
                                            <input type="text" class="form-control" value="<?=$user['phone'];?>"
                                                name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Gender (*)</label>
                                            <select class="form-control select2bs4" name="gender">
                                                <option <?=$user['gender'] == 'Male' ? 'selected' : '';?> value="Male">
                                                    Male
                                                </option>
                                                <option <?=$user['gender'] == 'Female' ? 'selected' : '';?>
                                                    value="Female">
                                                    Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Chiết khấu giảm giá (*)</label>
                                            <input type="text" class="form-control" value="<?=$user['chietkhau'];?>"
                                                name="chietkhau">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Chiết khấu giới thiệu (*)</label>
                                            <input type="text" class="form-control" value="<?=$user['ref_ck'];?>"
                                                name="ref_ck">
                                        </div>
                                        <i>Nếu đặt thành 0, hệ thống sẽ lấy chiết khấu mặc định.</i>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tổng số dư hoa hồng đã nhận (*)</label>
                                            <input type="number" class="form-control"
                                                value="<?=$user['ref_total_money'];?>" name="ref_total_money">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Số dư hoa hồng khả dụng (*)</label>
                                            <input type="number" class="form-control" value="<?=$user['ref_money'];?>"
                                                name="ref_money">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tổng lượt click link ref (*)</label>
                                            <input type="number" class="form-control" value="<?=$user['ref_click'];?>"
                                                name="ref_click">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cộng tác viên (*)</label>
                                            <select class="form-control select2bs4" name="ctv">
                                                <option value="1" <?=$user['ctv'] == 1 ? 'selected' : '';?>>Có</option>
                                                <option value="0" <?=$user['ctv'] == 0 ? 'selected' : '';?>>Không
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Level (*)</label>
                                            <select class="form-control select2bs4" name="admin">
                                                <option value="1" <?=$user['admin'] == 1 ? 'selected' : '';?>>Admin
                                                </option>
                                                <option value="0" <?=$user['admin'] == 0 ? 'selected' : '';?>>Member
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Active (*)</label>
                                            <select class="form-control select2bs4" name="active">
                                                <option value="1" <?=$user['active'] == 1 ? 'selected' : '';?>>Hoạt động
                                                </option>
                                                <option value="0" <?=$user['active'] == 0 ? 'selected' : '';?>>Chờ duyệt
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Banned (*)</label>
                                                <select class="form-control select2bs4" name="banned">
                                                    <option <?=$user['banned'] == 1 ? 'selected' : '';?> value="1">
                                                        Banned</option>
                                                    <option <?=$user['banned'] == 0 ? 'selected' : '';?> value="0">Live
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Money</label>
                                            <input type="text" class="form-control"
                                                value="<?=format_currency($user['money']);?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total Money</label>
                                            <input type="text" class="form-control"
                                                value="<?=format_currency($user['total_money']);?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Used Money</label>
                                            <input type="text" class="form-control"
                                                value="<?=format_currency($user['total_money']-$user['money']);?>"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>IP Login</label>
                                            <input type="text" class="form-control" value="<?=$user['ip'];?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Device Login</label>
                                            <input type="text" class="form-control" value="<?=$user['device'];?>"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Login</label>
                                            <input type="text" class="form-control" value="<?=$user['create_date'];?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Login</label>
                                            <input type="text" class="form-control" value="<?=$user['update_date'];?>"
                                                readonly>
                                        </div>
                                    </div>
                                </div><br>
                            </div>
                            <div class="card-footer clearfix">
                                <button aria-label="" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-money-bill-alt mr-1"></i>
                                CỘNG TIỀN
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
                        <div class="card-body">
                            <form class="" action="" method="POST" role="form">
                                <div class="form-group">
                                    <label>Amount (*)</label>
                                    <input type="hidden" class="form-control" id="id" value="<?=$user['id'];?>">
                                    <input type="number" class="form-control" name="amount"
                                        placeholder="Nhập số tiền cần cộng" required>
                                </div>
                                <div class="form-group">
                                    <label>Reason (*)</label>
                                    <textarea class="form-control" name="reason"
                                        placeholder="Nhập nội dung nếu có"></textarea>
                                </div>
                                <br>
                                <button aria-label="" name="cong_tien" class="btn btn-info btn-icon-left m-b-10"
                                    type="submit"><i class="fas fa-paper-plane mr-1"></i>Submit</button>
                            </form>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-money-bill-alt mr-1"></i>
                                TRỪ TIỀN
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
                        <div class="card-body">
                            <form class="" action="" method="POST" role="form">
                                <div class="form-group">
                                    <label>Amount (*)</label>
                                    <input type="hidden" class="form-control" id="id" value="<?=$user['id'];?>">
                                    <input type="number" class="form-control" name="amount"
                                        placeholder="Nhập số tiền cần trừ" required>
                                </div>
                                <div class="form-group">
                                    <label>Reason (*)</label>
                                    <textarea class="form-control" name="reason"
                                        placeholder="Nhập nội dung nếu có"></textarea>
                                </div>
                                <br>
                                <button aria-label="" name="tru_tien" class="btn btn-info btn-icon-left m-b-10"
                                    type="submit"><i class="fas fa-paper-plane mr-1"></i>Submit</button>
                            </form>
                        </div>
                    </div>
                </section>


            </div>
        </div>
    </div>
</div>



<?php
require_once(__DIR__.'/footer.php');
?>