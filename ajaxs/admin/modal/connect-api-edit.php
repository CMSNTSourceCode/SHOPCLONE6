<!-- <?php

define("IN_SITE", true);

require_once(__DIR__ . "/../../../libs/db.php");
require_once(__DIR__ . "/../../../libs/helper.php");
require_once(__DIR__ . "/../../../libs/lang.php");
require_once(__DIR__ . '/../../../models/is_admin.php');
require_once(__DIR__ . "/../../../libs/database/users.php");

if (!$row = $CMSNT->get_row(" SELECT * FROM `connect_api` WHERE `id` = '" . check_string($_GET['id']) . "' ")) {
    die('<script type="text/javascript">if(!alert("Item không tồn tại trong hệ thống")){location.reload();}</script>');
}
if (isset($_POST['btnSave'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){location.href=`' . base_url_admin('connect-api') . '`;}</script>');
    }
    $data1 = 'ERROR';
    if($_POST['type'] == 'CMSNT'){
        $data1 = curl_get(check_string($_POST['domain'])."/api/GetBalance.php?username=".check_string($_POST['username'])."&password=".check_string($_POST['password']));
        $data = json_decode($data1, true);
        if(isset($data['status']) && $data['status'] == 'error'){
            die('<script type="text/javascript">if(!alert("'.$data['msg'].'")){window.history.back().location.reload();}</script>');
        }
    }
    if($_POST['type'] == 'API_1'){
        $response = balance_API_1($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if($getPrice['status'] != true){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['balance']);
    }
    if($_POST['type'] == 'API_4'){
        $response = balance_API_4($_POST['domain'], $_POST['username'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if(!isset($getPrice['data']['userDetail']['coin'])){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['data']['userDetail']['coin']);
    }
    if($_POST['type'] == 'DONGVANFB'){
        $response = balance_API_DONGVANFB($_POST['domain'], $_POST['username'], $_POST['password']);
        $response = json_decode($response, true);
        if(isset($response['status']) && $response['status'] == true){
            $data1 = format_currency($response['balance']);
        }else{
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
    }
    if($_POST['type'] == 'API_6'){
        $response = balance_API_6($_POST['domain'], $_POST['password']);
        $getPrice = json_decode($response, true);
        if(!isset($getPrice['balance'])){
            die('<script type="text/javascript">if(!alert("Thông tin kết nối không chính xác")){window.history.back().location.reload();}</script>');
        }
        $data1 = format_currency($getPrice['balance']);
    }

    
    $isUpdate = $CMSNT->update("connect_api", [
        'domain'        => check_string($_POST['domain']),
        'type'          => check_string($_POST['type']),
        'username'      => check_string($_POST['username']),
        'password'      => check_string($_POST['password']),
        'status'        => check_string($_POST['status']),
        'price'         => $data1
    ], " `id` = '" . $row['id'] . "' ");
    if ($isUpdate) {
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){location.href=`' . base_url_admin('connect-api') . '`;}</script>');
    }
    die('<script type="text/javascript">if(!alert("Lưu thất bại!")){location.href=`' . base_url_admin('connect-api') . '`;}</script>');
}
?>


<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="modal-header">
    <h5 class="modal-title" id="CharginModalTitle">Chỉnh sửa kết nối <a href="<?= $row['domain']; ?>"
            target="_blank"><?= $row['domain']; ?></a></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="modalContent" class="modal-body">
    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab-chinh-sua-item-tab" data-toggle="pill" href="#tab-chinh-sua-item"
                role="tab" aria-controls="tab-chinh-sua-item" aria-selected="true">CHỈNH SỬA API</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-quan-ly-chuyen-muc-tab" data-toggle="pill" href="#tab-quan-ly-chuyen-muc"
                role="tab" aria-controls="tab-quan-ly-chuyen-muc" aria-selected="false">QUẢN LÝ CHUYÊN MỤC</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-quan-ly-san-pham-tab" data-toggle="pill" href="#tab-quan-ly-san-pham" role="tab"
                aria-controls="tab-quan-ly-san-pham" aria-selected="false">QUẢN LÝ SẢN PHẨM</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-quan-ly-don-hang-tab" data-toggle="pill" href="#tab-quan-ly-don-hang" role="tab"
                aria-controls="tab-quan-ly-don-hang" aria-selected="false">QUẢN LÝ ĐƠN HÀNG</a>
        </li>
    </ul>
    <div class="tab-content" id="custom-content-below-tabContent" style="padding-top: 25px">
        <div class="tab-pane fade active show" id="tab-chinh-sua-item" role="tabpanel"
            aria-labelledby="tab-chinh-sua-item-tab">
            <form method="POST" action="<?= BASE_URL('ajaxs/admin/modal/connect-api-edit.php?id=' . $row['id']); ?>"
                accept-charset="UTF-8">
                <div class="form-group">
                    <label for="exampleInputEmail1">Domain</label>
                    <input class="form-control" type="url" placeholder="https://shopclone6.cmsnt.site/" name="domain"
                        value="<?= $row['domain']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Loại API</label>
                    <select class="form-control select2bs4" name="type">
                        <option <?= $row['type'] == 'CMSNT' ? 'selected' : ''; ?> value="CMSNT">
                            CMSNT
                        </option>
                        <?php if(checkAddon(11412) == true):?>
                        <option <?= $row['type'] == 'API_1' ? 'selected' : ''; ?> value="API_1">
                            API 1
                        </option>
                        <?php endif?>
                        <?php if(checkAddon(11413) == true):?>
                        <option <?= $row['type'] == 'API_4' ? 'selected' : ''; ?> value="API_4">
                            API 4
                        </option>
                        <?php endif?>
                        <?php if(checkAddon(11422) == true):?>
                        <option <?= $row['type'] == 'DONGVANFB' ? 'selected' : ''; ?> value="DONGVANFB">DONGVANFB</option>
                        <?php endif?>
                        <?php if(checkAddon(11427) == true):?>
                        <option <?= $row['type'] == 'API_6' ? 'selected' : ''; ?> value="API_6">
                            API 6
                        </option>
                        <?php endif?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Tên đăng nhập</label>
                    <input class="form-control" type="text" placeholder="Nhập tên đăng nhập" name="username"
                        value="<?= $row['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Mật khẩu</label>
                    <input class="form-control" type="text" placeholder="Nhập mật khẩu đăng nhập" name="password"
                        value="<?= $row['password']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Số dư hiện tại</label>
                    <input class="form-control" type="text" value="<?= $row['price']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Trạng thái</label>
                    <select class="form-control" name="status" required>
                        <option <?= $row['status'] == 1 ? 'selected' : ''; ?> value="1">Hiển thị</option>
                        <option <?= $row['status'] == 0 ? 'selected' : ''; ?> value="0">Ẩn</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="btnSave" class="btn btn-primary btn-block">LƯU THAY ĐỔI</button>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-block">HUỶ
                        THAY ĐỔI</button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab-quan-ly-san-pham" role="tabpanel" aria-labelledby="tab-quan-ly-san-pham-tab">
            <div class="table-responsive">
                <table id="products" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>PRICE/COST</th>
                            <th>ACCOUNT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($CMSNT->get_list("SELECT * FROM `products` WHERE `id_connect_api` = '" . $row['id'] . "' ORDER BY `stt` ASC ") as $product) { ?>
                        <tr onchange="updateForm(`<?= $product['id']; ?>`)">
                            <td>
                                <ul>
                                    <li>Tên sản phẩm gốc: <i><?= $product['name_api']; ?></i></li>
                                    <li>Tên sản phẩm: <b><?= $product['name']; ?></b></li>
                                    <li>Chuyên mục:
                                        <b></b><?= $product['category_id'] == 0 ? '' : getRowRealtime("categories", $product['category_id'], 'name'); ?>
                                    </li>
                                    <li>Trạng thái: <?= display_status_product($product['status']); ?></li>
                                </ul>
                            </td>
                            <td width="20%">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Giá bán</span>
                                    </div>
                                    <input type="text" id="price<?= $product['id']; ?>"
                                        value="<?= $product['price']; ?>" placeholder="Nhập giá bán gói dịch vụ"
                                        class="form-control">
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Giá vốn</span>
                                    </div>
                                    <input type="text" id="cost<?= $product['id']; ?>" value="<?= $product['cost']; ?>"
                                        placeholder="Nhập giá vốn gói dịch vụ" class="form-control">
                                </div>
                            </td>
                            <td width="15%">
                                <ul>
                                    <li>Đang bán: <b
                                            style="color: green;"><?= format_cash($product['api_stock']); ?></b></li>
                                    <li>Đã bán: <b
                                            style="color:blue;"><?= format_cash($CMSNT->get_row("SELECT COUNT(id)  FROM `accounts` WHERE `product_id` = '" . $product['id'] . "' AND `buyer` IS NOT NULL ")['COUNT(id)']); ?></b>
                                        <a href="<?= base_url_admin('account-sold/' . $product['id']); ?>">Xem</a></li>
                                </ul>
                            </td>
                            <td width="10%">
                                <a aria-label="" target="_blank"
                                    href="<?= base_url('admin/product-edit/' . $product['id']); ?>" style="color:white;"
                                    class="btn btn-info btn-block btn-sm btn-icon-left m-b-10" type="button">
                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-quan-ly-chuyen-muc" role="tabpanel"
            aria-labelledby="tab-quan-ly-chuyen-muc-tab">
            <div class="table-responsive">
                <table id="categories" class="table table-striped table-bordered text-center">
                    <thead class="head">
                        <tr>
                            <th>Tên chuyên mục</th>
                            <th>Ảnh</th>
                            <th>Trạng thái</th>
                            <th style="width: 20%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($CMSNT->get_list("SELECT * FROM `categories` WHERE `id_connect_api` = '" . $row['id'] . "' ORDER BY `stt` ASC ") as $category) { ?>
                        <tr>
                            <td><?= $category['name']; ?></td>
                            <td><img src="<?= base_url($category['image']); ?>" width="40px"></td>
                            <td><?= display_status_product($category['status']); ?></td>
                            <td>
                                <a aria-label="" target="_blank"
                                    href="<?= base_url('admin/category-edit/' . $category['id']); ?>"
                                    style="color:white;" class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-quan-ly-don-hang" role="tabpanel" aria-labelledby="tab-quan-ly-don-hang-tab">
            <div class="table-responsive">
                <table id="orders" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Bên mua</th>
                            <th>Đơn hàng</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        foreach ($CMSNT->get_list("SELECT * FROM `orders` WHERE `product_id` != 0 AND `fake` = 0 AND `id_connect_api` = '" . $row['id'] . "' ORDER BY id DESC LIMIT 1000 ") as $order) { ?>
                        <tr>
                            <td width="10%"><?= $i++; ?></td>
                            <td width="30%">
                                <ul>
                                    <li>Username: <b><a target="_blank"
                                                href="<?= base_url('admin/user-edit/' . $order['buyer']); ?>"><?= getRowRealtime("users", $order['buyer'], "username"); ?></a>
                                            (<?= __($order['buyer']); ?>)</b></li>
                                    <li>Money: <b
                                            style="color: red;"><?= format_currency(getRowRealtime("users", $order['buyer'], "money")); ?></b>
                                    </li>
                                    <li>Total money:
                                        <b><?= format_currency(getRowRealtime("users", $order['buyer'], "total_money")); ?></b>
                                    </li>
                                    <li>Email: <b><?= getRowRealtime("users", $order['buyer'], "email"); ?></b></li>
                                </ul>
                            </td>
                            <td width="40%">
                                <ul>
                                    <li>Mã giao dịch: <b>#<?= $order['trans_id']; ?></b></li>
                                    <li>Mã giao dịch API: <b>#<?= $order['api_trans_id']; ?></b></li>
                                    <li>Sản phẩm:
                                        <b><?= getRowRealtime("products", $order['product_id'], 'name'); ?></b>
                                    </li>
                                    <li>Số lượng: <b style="color:blue;"><?= format_cash($order['amount']); ?></b>
                                    </li>
                                    <li>Thanh toán: <b style="color:red;"><?= format_currency($order['pay']); ?></b>
                                    </li>
                                    <li>Giá vốn: <b style="color:red;"><?= format_currency($order['cost']); ?></b> -
                                        Lãi: <b
                                            style="color:green;"><?= format_currency($order['pay']-$order['cost']); ?></b>
                                    </li>
                                </ul>
                            </td>
                            <td width="10%"><?= $order['create_date']; ?></td>
                            <td width="10%"><button type="button" onclick="showAccounts(`<?= $order['trans_id']; ?>`)"
                                    class="btn btn-primary btn-sm showAccounts">Xem Thêm</button></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('#categories').DataTable();
    $('#products').DataTable();
    $('#orders').DataTable();
});
</script>


<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?= BASE_URL("ajaxs/admin/update.php"); ?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'changeProductAPI',
            id: id,
            price: $("#price" + id).val(),
            cost: $("#cost" + id).val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
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
</script>


<div class="modal fade" id="modalAccounts" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tài khoản đơn hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="coypyBox" rows="20" readonly></textarea>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary copy" onclick="copy()"
                    data-clipboard-target="#coypyBox">Sao chép</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function showAccounts(trans_id) {
    $.ajax({
        url: "<?=base_url('ajaxs/admin/showAccounts.php');?>",
        method: "POST",
        data: {
            trans_id: trans_id
        },
        success: function(respone) {
            $('#modalAccounts').modal();
            $('#coypyBox').val(respone);
        }
    });
}
</script>
<script>
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "Đã sao chép vào bộ nhớ tạm",
        timer: 5000
    });
}
</script> -->