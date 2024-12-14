<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Email Campaigns',
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
<?php

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
}
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Email Campaigns</h1>
                    <p><?=__('Tạo chiến dịch gửi Email đồng loạt cho toàn bộ khách hàng của bạn.');?>
                    </p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Email Campaigns</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẤU HÌNH SMTP
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
                                    <label for="exampleInputEmail1">Email SMTP</label>
                                    <input type="email" class="form-control" name="email_smtp"
                                        value="<?=$CMSNT->site('email_smtp');?>" placeholder="Nhập địa chỉ Email SMTP">
                                    <i>Hướng dẫn cấu hình SMTP <a target="_blank"
                                            href="https://www.cmsnt.co/2022/12/huong-dan-cach-cau-hinh-smtp-e-gui.html">tại
                                            đây</a></i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password Email SMTP</label>
                                    <input type="password" class="form-control" name="pass_email_smtp"
                                        value="<?=$CMSNT->site('pass_email_smtp');?>" placeholder="Nhập mật khẩu Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Host</label>
                                    <input type="domain" class="form-control" name="host_smtp"
                                        value="<?=$CMSNT->site('host_smtp');?>" placeholder="smtp.gmail.com">
                                    <i>Chỉ thay đổi khi bạn thật sự hiểu chúng.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Port</label>
                                    <input type="text" class="form-control" name="port_smtp"
                                        value="<?=$CMSNT->site('port_smtp');?>" placeholder="587">
                                    <i>Chỉ thay đổi khi bạn thật sự hiểu chúng.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Encryption</label>
                                    <input type="text" class="form-control" name="encryption_smtp"
                                        value="<?=$CMSNT->site('encryption_smtp');?>" placeholder="tls">
                                    <i>Chỉ thay đổi khi bạn thật sự hiểu chúng.</i>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6">
                    <?php if($CMSNT->site('email_smtp') == '' || $CMSNT->site('pass_email_smtp') == ''):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Bạn cần phải cấu hình <b>SMTP</b> mới có thể sử dụng được tính năng này.
                    </div>
                    <?php endif?>
                    <?php if(time() - $CMSNT->site('check_time_cron_sending_email') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                       Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a href=" <?=base_url('cron/sending_email.php');?>" target="_blank"><?=base_url('cron/sending_email.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if(checkAddon(11469) != true):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                       Bạn cần mua Addon <a target="_blank" href="<?=base_url_admin('addons');?>">Email Campaigns</a> giá <b>300.000đ</b> mới có thể sử dụng tính năng này.
                    </div>
                    <?php endif?>
                </section>
                <section class="col-lg-12 text-right">
                    <div class="mb-3">
                        <a class="btn btn-primary btn-icon-left m-b-10"
                            href="<?=BASE_URL('admin/email-campaign-add');?>" type="button"><i
                                class="fas fa-plus-circle mr-1"></i><?=__('Create New Campaign');?></a>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-list mr-1"></i>
                                DANH SÁCH CHIẾN DỊCH EMAIL
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
                                            <th style="width: 5px;">#</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Start Date/Time </th>
                                            <th>Sending Progress</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0;
                                        foreach ($CMSNT->get_list("SELECT * FROM `email_campaigns` ORDER BY id DESC ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><b><?=$row['name'];?></b></td>
                                            <td><?=display_camp($row['status']);?></td>
                                            <td><?=$row['create_gettime'];?></td>
                                            <td>
                                                <?php
                                                $total_success = $CMSNT->get_row(" SELECT COUNT(id) FROM `email_sending` WHERE `camp_id` = '".$row['id']."' AND `status` = 1 ")['COUNT(id)'];
                                                $total = $CMSNT->get_row(" SELECT COUNT(id) FROM `email_sending` WHERE `camp_id` = '".$row['id']."' ")['COUNT(id)'];
                                                $phantram = $total_success / $total * 100;
                                                ?>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success"
                                                        role="progressbar" style="width: <?=$phantram;?>%"
                                                        aria-valuenow="<?=$total_success;?>" aria-valuemin="0"
                                                        aria-valuemax="<?=$total;?>">
                                                        <?=format_cash($total_success);?>/<?=format_cash($total);?>
                                                        (<?=format_cash($phantram);?>%)</div>
                                                </div>
                                                <div class="text-center"><a
                                                        href="<?=base_url('index.php?module=admin&action=email-sending-view&id='.$row['id']);?>">View
                                                        Sending Report</a></div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" id="dropdownMenuButton<?=$row['id'];?>"
                                                        class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="default-text">
                                                            Manage Campaign
                                                            <span class="caret"></span>
                                                        </span>

                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton<?=$row['id'];?>">
                                                        <li>
                                                            <a href="<?=base_url('index.php?module=admin&action=email-campaign-edit&id='.$row['id']);?>"
                                                                class="dropdown-item">
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>

                                                            <button onclick="CancelRow(<?=$row['id'];?>)"
                                                                <?=$row['status'] == 2 ? 'disabled' : '';?>
                                                                class="dropdown-item">
                                                                Cancel
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button onclick="RemoveRow(<?=$row['id'];?>)"
                                                                class="dropdown-item">
                                                                Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php }?>
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



<script type="text/javascript">
function CancelRow(id) {
    cuteAlert({
        type: "question",
        title: "Campaign Cancel Confirmation",
        message: "Are you sure you want to cancel this campaign?",
        confirmText: "Ok",
        cancelText: "Cancel"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL('ajaxs/admin/update.php');?>",
                type: 'POST',
                dataType: "JSON",
                data: {
                    action: 'cancel_email_campaigns',
                    id: id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: "Success",
                            timer: 3000
                        });
                        location.reload();
                    } else {
                        cuteToast({
                            type: "error",
                            message: "Error",
                            timer: 3000
                        });
                    }
                }
            });
        }
    })
}


function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Campaign deletion confirmation",
        message: "Are you sure you want to delete this campaign?",
        confirmText: "Ok",
        cancelText: "Cancel"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL('ajaxs/admin/remove.php');?>",
                type: 'POST',
                dataType: "JSON",
                data: {
                    action: 'email_campaigns',
                    id: id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: "Success",
                            timer: 3000
                        });
                        location.reload();
                    } else {
                        cuteToast({
                            type: "error",
                            message: "Error",
                            timer: 3000
                        });
                    }
                }
            });
        }
    })
}
</script>



<script>
$(function() {
    $('#datatable1').DataTable();
});
</script>