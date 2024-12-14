<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'View Sending Report',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
 
';
$body['footer'] = '
 
';
require_once(__DIR__.'/../../../models/is_admin.php');

if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    $row = $CMSNT->get_row("SELECT * FROM `email_campaigns` WHERE `id` = '$id' ");
    if (!$row) {
        redirect(base_url('admin/email-campaigns'));
    }
} else {
    redirect(base_url('admin/email-campaigns'));
}


require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');


$sotin1trang = 10;
if(isset($_GET['page'])){
    $page = check_string(intval($_GET['page']));
}
else{
    $page = 1;
}
$from = ($page - 1) * $sotin1trang;
$where = " `camp_id` = '$id'  ";
$status  = '';
$username = '';
$email = '';
if(!empty($_GET['status'])){
    $status = intval(check_string($_GET['status']));
    if($status == 1){
        $where .= ' AND `status` = 0 ';
    }else if($status == 2){
        $where .= ' AND `status` = 1 ';
    }else if($status == 3){
        $where .= ' AND `status` = 2 ';
    }else if($status == 4){
        $where .= ' AND `status` = 3 ';
    }
}
if(!empty($_GET['username'])){
    $username = check_string($_GET['username']);
    $user_id = $CMSNT->get_row(" SELECT `id` FROM `users` WHERE `username` = '$username' ")['id'];
    
    $where .= ' AND `user_id` = "'.$user_id.'" ';
}
if(!empty($_GET['email'])){
    $email = check_string($_GET['email']);
    $user_id = $CMSNT->get_row(" SELECT `id` FROM `users` WHERE `email` = '$email' ")['id'];
    $where .= ' AND `user_id` = "'.$user_id.'" ';
}


$listDatatable = $CMSNT->get_list(" SELECT * FROM `email_sending` WHERE $where ORDER BY `id` ASC LIMIT $from,$sotin1trang ");


?>




<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Sending Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/email-campaigns');?>">Email
                                Campaigns</a></li>
                        <li class="breadcrumb-item active">View Sending Report</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('admin/email-campaigns');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Back</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-solid fa-list mr-1"></i>
                                SENDING REPORT
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
                                     <input type="hidden" name="action" value="email-sending-view">
                                     <input type="hidden" name="id" value="<?=$id;?>">
                                     <div class="row">
                                        <input class="form-control col-sm-2 mb-2" value="<?=$username;?>"
                                             name="username" placeholder="Username">
                                        <input class="form-control col-sm-2 mb-2" value="<?=$email;?>"
                                             name="email" placeholder="Email">
                                        <select class="form-control  col-sm-2 mb-2" name="status">
                                            <option value="">Status</option>
                                            <option <?=$status == 1 ? 'selected' : '';?> value="1"><?=__('Processing');?></option>
                                            <option <?=$status == 2 ? 'selected' : '';?> value="2"><?=__('Completed');?></option>
                                            <option <?=$status == 3 ? 'selected' : '';?> value="3"><?=__('Cancel');?></option>
                                            </select>
                                         <div class="col-sm-4 mb-2">
                                             <button type="submit" name="submit" value="filter"
                                                 class="btn btn-warning"><i class="fa fa-search"></i>
                                                 Tìm kiếm
                                             </button>
                                             <a class="btn btn-danger"
                                                 href="<?=BASE_URL('index.php?module=admin&action=email-sending-view&id='.$id);?>"><i
                                                     class="fa fa-trash"></i>
                                                 Bỏ lọc
                                             </a>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>

                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Update</th>
                                            <th>Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listDatatable as $row) {?>
                                        <tr>
                                            <td><i class="ace-icon fa fa-user bigger-130 mr-1"></i><strong><?=getRowRealtime('users', $row['user_id'], 'username');?></strong></td>
                                            <td><i class="ace-icon fa fa-envelope bigger-130 mr-1"></i><strong><?=getRowRealtime('users', $row['user_id'], 'email');?></strong></td>
                                            <td><?=display_camp($row['status']);?></td>
                                            <td><i class="fa-solid fa-clock mr-1"></i><?=$row['update_gettime'];?></td>
                                            <td>
                                                <textarea class="form-control" readonly><?=$row['response'];?></textarea>
                                            </td>
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
                                $total = $CMSNT->num_rows(" SELECT * FROM `email_sending` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(base_url("index.php?module=admin&action=email-sending-view&id=$id&status=$status&email=$email&"), $from, $total, $sotin1trang) . '</center>';}?>
                                </div>
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