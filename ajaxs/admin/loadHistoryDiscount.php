<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');

$CMSNT = new DB;

if(!$CMSNT->get_row(" SELECT * FROM `discounts` WHERE `product_id` = '".check_string($_GET['id'])."' ")){
    die('');
}
?>

<div class="table-responsive p-0">
    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giảm</th>
                <th>Điều kiện</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; foreach ($CMSNT->get_list(" SELECT * FROM `discounts` WHERE `product_id` = '".check_string($_GET['id'])."' ORDER BY `amount` ASC ") as $row) {?>
            <tr>
                <td><b><?=getRowRealtime('products', $row['product_id'], 'name');?></b></td>
                <td><span style="font-size: 15px;"
                        class="badge badge-dark"><?=$row['discount'];?>%</span></td>
                <td><b style="color: blue;"><?=format_cash($row['amount']);?></b> nick</td>
                <td>
                    <a aria-label="" href="<?=base_url_admin('discount-edit&id='.$row['id']);?>"
                        style="color:white;"
                        class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                        <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                    </a>
                    <button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>')"
                        class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                        <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                    </button>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác nhận xoá item",
        message: "Bạn có chắc chắn muốn xóa dữ liệu này không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/remove.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    action: 'removeDiscount',
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