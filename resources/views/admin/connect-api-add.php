<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thêm website API',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
 
';
$body['footer'] = '
 
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['btnAdd'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $data1 = 'ERROR';
    if($_POST['type'] == 'CMSNT'){
        $data1 = curl_get(check_string($_POST['domain'])."/api/GetBalance.php?username=".check_string($_POST['username'])."&password=".check_string($_POST['password']));
        $data = json_decode($data1, true);
        if(isset($data['status']) && $data['status'] == 'error'){
            die('<script type="text/javascript">if(!alert("'.$data['msg'].'")){window.history.back().location.reload();}</script>');
        }
    }else if($_POST['type'] == 'API_1'){
        $response = balance_API_1($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if($getPrice['status'] != true){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['balance']);
    }
    $isInsert = $CMSNT->insert("connect_api", [
        'user_id'       => $getUser['id'],
        'domain'        => check_string($_POST['domain']),
        'type'          => check_string($_POST['type']),
        'username'      => check_string($_POST['username']),
        'password'      => check_string($_POST['password']),
        'price'         => $data1,
        'status'        => 1
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm website API vào hệ thống (".check_string($_POST['domain']).")"
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('admin/connect-api').'";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm website API</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thêm website API</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                    <div class="mb-3">
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/connect-api');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sign-in mr-1"></i>
                                ĐĂNG NHẬP WEBSITE API
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
                                    <label for="exampleInputEmail1">Domain</label>
                                    <input class="form-control" type="url" placeholder="https://shopclone6.cmsnt.site/" name="domain" required>
                                </div>
                                <div class="form-group">
                                    <label>Loại API</label>
                                    <select class="form-control select2bs4" name="type">
                                        <option value="CMSNT">
                                            CMSNT
                                        </option>
                                        <?php if(checkAddon(11412) == true):?>
                                        <option value="API_1">
                                            API 1
                                        </option>
                                        <?php endif?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên đăng nhập</label>
                                    <input class="form-control" type="text" placeholder="Nhập tên đăng nhập" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu</label>
                                    <input class="form-control" type="password" placeholder="Nhập mật khẩu đăng nhập" name="password" required>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="btnAdd" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>ĐĂNG NHẬP</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>



<?php
require_once(__DIR__.'/footer.php');
?>