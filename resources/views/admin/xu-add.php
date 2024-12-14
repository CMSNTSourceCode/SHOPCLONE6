<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Thêm xu',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '

';
$body['footer'] = '

';

if(checkAddon(11522) != true){
    die('Vui lòng kích hoạt <a href="'.base_url_admin('addons').'">Addon</a> trước khi truy cập.');
}

require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if(isset($_POST['AddFormSLL'])){
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $value_add = 0;
    $value_update = 0;
    $list = $_POST['list'];
    $list = explode(PHP_EOL, $list);
    foreach ($list as $clone){
        if(empty($clone)){
            continue;
        }
        $nick = explode('|', $clone);
        $isAdd = $CMSNT->insert("list_tds_ttc", [
            'server'            => check_string($_POST['server']),
            'username'          => $nick[0],
            'password'          => $nick[1],
            'proxy_host'        => $nick[2],
            'proxy_user'        => $nick[3],
            'cookie'            => null,
            'token'             => null,
            'coin'              => 0,
            'create_gettime'    => gettime(),
            'update_gettime'    => gettime(),
            'status'            => 1,
            'day_limit'         => 0
        ]);
        if ($isAdd) {
            $value_add++;
        }
    }
    $Mobile_Detect = new Mobile_Detect();
    $CMSNT->insert("logs", [
        'user_id'       => $getUser['id'],
        'ip'            => myip(),
        'device'        => $Mobile_Detect->getUserAgent(),
        'createdate'    => gettime(),
        'action'        => "Thêm xu SLL TDS - TTC vào hệ thống."
    ]);
    die('<script type="text/javascript">if(!alert("Thêm thành công '.$value_add.' tài khoản '.check_string($_POST['server']).'")){window.history.back().location.reload();}</script>');

}
if (isset($_POST['AddForm'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->insert("list_tds_ttc", [
        'username'          => !empty($_POST['username']) ? $_POST['username'] : null,
        'password'          => !empty($_POST['password']) ? $_POST['password'] : null,
        'cookie'            => !empty($_POST['cookie']) ? $_POST['cookie'] : null,
        'token'             => !empty($_POST['token']) ? $_POST['token'] : null,
        'coin'              => !empty($_POST['coin']) ? $_POST['coin'] : 0,
        'create_gettime'    => gettime(),
        'update_gettime'    => gettime(),
        'server'            => !empty($_POST['server']) ? $_POST['server'] : NULL,
        'status'            => 1,
        'day_limit'         => 0
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm xu TDS - TTC (".check_string($_POST['username']).") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('admin/xu-list').'";}</script>');
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
                    <h1 class="m-0">Thêm xu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thêm xu</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/xu-list');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-add mr-1"></i>
                                THÊM XU TDS - TTC
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
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Server</label>
                                        <select class="form-control" name="server" required>
                                            <option value="TDS">TDS</option>
                                            <option value="TTC">TTC</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Username</label>
                                        <input type="text" class="form-control" placeholder="Nếu có" name="username">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Password</label>
                                        <input type="text" class="form-control" placeholder="Nếu có" name="password">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Token</label>
                                        <input type="text" class="form-control" placeholder="Áp dụng cho TTC"
                                            name="token">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Cookie</label>
                                        <input type="text" class="form-control" placeholder="Áp dụng cho TDS"
                                            name="cookie">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Xu hiện tại</label>
                                        <input type="text" class="form-control" value="0" name="coin">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="AddForm" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Thêm Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-add mr-1"></i>
                                THÊM XU TDS - TTC SLL
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
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="exampleInputEmail1">Server</label>
                                        <select class="form-control" name="server" required>
                                            <option value="TDS">TDS</option>
                                            <option value="TTC">TTC</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="exampleInputEmail1">Tài khoản|Mật khẩu|Proxy Host|Proxy User</label>
                                        <textarea class="form-control" rows="6" placeholder="Mỗi dòng 1 nick"
                                            name="list"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="AddFormSLL" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Thêm Ngay</button>
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