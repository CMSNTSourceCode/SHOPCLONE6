<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Đơn rút tiền',
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
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
 
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Đơn rút tiền</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Đơn rút tiền</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                DANH SÁCH ĐƠN RÚT TIỀN
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
                            <div class="table-responsive p-0">
                            <table id="datatable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5px">#</th>
                                            <th>MÃ GIAO DỊCH</th>
                                            <th>KHÁCH HÀNG</th>
                                            <th>THÔNG TIN RÚT</th>
                                            <th>SỐ TIỀN RÚT</th>
                                            <th>TRẠNG THÁI</th>
                                            <th>THỜI GIAN</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach ($CMSNT->get_list(" SELECT * FROM `withdraw_ref` ORDER BY id DESC  ") as $row) {
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td>#<?=$row['trans_id']; ?></td>
                                            <td>
                                                <ul>
                                                    <li>Username: <b><a
                                                                href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getRowRealtime("users", $row['user_id'], "username");?></a>
                                                            (<?=__($row['user_id']);?>)</b></li>
                                                    <li>Ví chính: <b style="color: red;"><?=format_currency(getRowRealtime("users", $row['user_id'], "money"));?></b></li>              
                                                    <li>Ví hoa hồng: <b style="color:green;"><?=format_currency(getRowRealtime("users", $row['user_id'], "ref_money"));?></b></li>
                                                    <li>Email: <b><?=getRowRealtime("users", $row['user_id'], "email");?></b></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li><b>Ngân hàng:</b> <?=$row['bank']; ?></li>
                                                    <li><b>Số tài khoản:</b> <?=$row['stk']; ?></li>
                                                    <li><b>Chủ tài khoản:</b> <?=$row['name']; ?></li>
                                                </ul>
                                            </td>
                                            <td><?=format_currency($row['amount']); ?></td>
                                            <td><?=display_card($row['status']); ?></td>
                                            <td><?=$row['create_gettime']; ?></td>
                                            <td>
                                                <button class="edit-charging-btn btn-sm btn btn-info" onclick="editModal(`<?= $row['id']; ?>`)" type="button">
                                                        <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </button>
                                                <button style="color:white;" onclick="RemoveRow('<?=$row['id']; ?>')"
                                                    class="btn btn-danger btn-sm" type="button">
                                                    <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }?>
                                    </tbody>
                                </table>
                            </div>
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
$(function() {
    $('#datatable1').DataTable();
});
</script>
<div class="modal fade" id="ChargingModal" tabindex="-1" role="dialog" aria-labelledby="ChargingModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="CharigngAjaxContent"></div>
        </div>
    </div>
</div>
<script>
    function editModal(id){
        $("#CharigngAjaxContent").html('');
        $.get("<?= BASE_URL('ajaxs/admin/modal/withdraw-ref.php?id='); ?>" + id, function(data) {
            $("#CharigngAjaxContent").html(data);
        });
        $("#ChargingModal").modal();
    }
</script>
<script type="text/javascript">
function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/remove.php');?>",
        type: 'POST',
        dataType: "JSON",
        data: {
            id: id,
            action: 'removeWithdrawRef'
        },
        success: function(response) {
            if (response.status == 'success') {
                cuteToast({
                    type: "success",
                    message: "Đã xóa thành công item " + id,
                    timer: 3000
                });
            } else {
                cuteToast({
                    type: "error",
                    message: "Đã xảy ra lỗi khi xoá item " + id,
                    timer: 5000
                });
            }
        }
    });
}

function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác nhận xoá đơn rút tiền",
        message: "Bạn có chắc chắn muốn xóa đơn rút tiền này không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            postRemove(id);
            location.reload();
        }
    })
}
</script>