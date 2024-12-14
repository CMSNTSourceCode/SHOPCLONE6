<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Tài khoản đã bán',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
$body['footer'] = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>

';
require_once(__DIR__.'/../../../models/is_admin.php');
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `products` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/product-list'));
    }
} else {
    redirect(base_url('admin/product-list'));
}
$sotin1trang = 10;
if(isset($_GET['page'])){
    $page = check_string(intval($_GET['page']));
}
else{
    $page = 1;
}
$from = ($page - 1) * $sotin1trang;
$where = ' `product_id` = "'.$row['id'].'" AND `buyer` IS NOT NULL ';
$account = '';
$buyer = '';
$status = '';
$trans_id = '';

if(!empty($_GET['account'])){
    $account = check_string($_GET['account']);
    $where .= ' AND `account` LIKE "%'.$account.'%" ';
}
if(!empty($_GET['buyer'])){
    $buyer = check_string($_GET['buyer']);
    $where .= ' AND `buyer` = "'.$buyer.'" ';
}
if(!empty($_GET['status'])){
    $status = check_string($_GET['status']);
    $where .= ' AND `status` = "'.$status.'" ';
}
if(!empty($_GET['trans_id'])){
    $trans_id = check_string($_GET['trans_id']);
    $where .= ' AND `trans_id` LIKE "%'.$trans_id.'%" ';
}
$listAccount = $CMSNT->get_list("SELECT * FROM `accounts` WHERE $where ORDER BY update_date DESC LIMIT $from,$sotin1trang  ");

require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách tài khoản đã bán '<?=$row['name'];?>'</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách tài khoản đã bán</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <a type="button" href="<?=base_url('admin/accounts/'.check_string($_GET['id']));?>"
                    class="btn btn-danger btn-block mb-5">QUAY LẠI</a>

                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-dolly-flatbed mr-1"></i>
                                DANH SÁCH TÀI KHOẢN ĐÃ BÁN
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
                            <div class="row mb-2">
                                <div class="col-sm-12 mb-3">
                                    <form action="" name="formSearch" method="GET">
                                        <input type="hidden" name="module" value="admin">
                                        <input type="hidden" name="action" value="account-sold">
                                        <input type="hidden" name="id" value="<?=$id;?>">
                                        <div class="row">
                                            <select class="form-control select2bs4 col-sm-2 mb-2" name="buyer">
                                                <option value="">Tìm người mua</option>
                                                <?php foreach($CMSNT->get_list("SELECT * FROM `users` ") as $row):?>
                                                <option <?=$buyer == $row['id'] ? 'selected' : '';?>
                                                    value="<?=$row['id'];?>">
                                                    <?=$row['username'];?> (<?=$row['id'];?>)
                                                </option>
                                                <?php endforeach?>
                                            </select>
                                            <input class="form-control col-sm-2 mb-2" value="<?=$account;?>"
                                                name="account" placeholder="Tìm tài khoản">
                                            <input class="form-control col-sm-2 mb-2" value="<?=$trans_id;?>"
                                                name="trans_id" placeholder="Tìm mã đơn hàng">
                                            <div class="col-sm-4 mb-2">
                                                <button type="submit" name="submit" value="filter"
                                                    class="btn btn-warning"><i class="fa fa-search"></i>
                                                    Tìm kiếm
                                                </button>
                                                <a class="btn btn-danger"
                                                    href="<?=BASE_URL('index.php?module=admin&action=account-sold&id='.$id);?>"><i
                                                        class="fa fa-trash"></i>
                                                    Bỏ lọc
                                                </a>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>

                                            <th>Bên bán</th>
                                            <th>Bên mua</th>
                                            <th width="30%">Thông tin </th>
                                            <th>Thời gian mua</th>
                                            <th>Trạng thái</th>
                                            <th>Check live gần đây</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listAccount as $row) {?>
                                        <tr>

                                            <td>
                                                <ul>
                                                    <li>ID: <b><?=$row['seller'];?></b></li>
                                                    <li>Username: <b><a
                                                                href="<?=base_url('admin/user-edit/'.$row['seller']);?>"><?=getRowRealtime("users", $row['seller'], "username");?></a></b>
                                                    </li>
                                                    <li>Email:
                                                        <b><?=getRowRealtime("users", $row['seller'], "email");?></b>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>ID: <b><?=$row['buyer'];?></b></li>
                                                    <li>Username: <b><a
                                                                href="<?=base_url('admin/user-edit/'.$row['buyer']);?>"><?=getRowRealtime("users", $row['buyer'], "username");?></a></b>
                                                    </li>
                                                    <li>Email:
                                                        <b><?=getRowRealtime("users", $row['buyer'], "email");?></b>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                Đơn hàng: <b><a target="_blank"
                                                        href="<?=base_url_admin('product-order');?>"><?=$row['trans_id'];?></a></b>
                                                <textarea class="form-control" readonly><?=$row['account'];?></textarea>
                                            </td>
                                            <td><?=$row['update_date'];?></td>
                                            <td><?=display_live($row['status']);?></td>
                                            <td><?=timeAgo($row['time_live']);?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">

                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <?php
                                $total = $CMSNT->num_rows(" SELECT * FROM `accounts` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(base_url("index.php?module=admin&action=account-sold&id=$id&saccount=$account&buyer=$buyer&trans_id=$trans_id&"), $from, $total, $sotin1trang) . '</center>';}?>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-danger btn-sm" type="button" onclick="deleteConfirm()"
                                        name="btn_delete"><i class="fas fa-trash mr-1"></i>Xoá đã chọn</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                DANH SÁCH TÀI KHOẢN ĐÃ BÁN <span
                                    class="badge bg-danger"><?=$CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '$id' AND `buyer` IS NOT NULL ")['COUNT(id)'];?></span>
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
                            <textarea class="form-control" id="listdie" rows="10" readonly>
<?php foreach ($CMSNT->get_list(" SELECT * FROM `accounts` WHERE `product_id` = '$id' AND `buyer` IS NOT NULL ") as $die) { ?>
<?=$die['account'];?>

<?php }?></textarea>
                        </div>
                        <div class="card-footer clearfix">
                            <button type="button" onclick="copy()" class="btn btn-info copy"
                                data-clipboard-target="#listdie">
                                <span>COPY</span></button>
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
<script>
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}
</script>