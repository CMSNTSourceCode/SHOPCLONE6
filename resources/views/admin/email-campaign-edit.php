<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Edit Campaign',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- CodeMirror -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/codemirror.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/theme/monokai.css">
<!-- ckeditor -->
<script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
$body['footer'] = '
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<!-- CodeMirror -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/codemirror.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/css/css.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/xml/xml.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
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
<script>
CKEDITOR.replace("content");
</script>
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
?>
<?php
if (isset($_POST['submit'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->update('email_campaigns', [
        'name'              => check_string($_POST['name']),
        'subject'           => $_POST['subject'],
        'cc'                => check_string($_POST['cc']),
        'bcc'               => check_string($_POST['bcc']),
        'content'           => $_POST['content'],
        'update_gettime'    => gettime()
    ], " `id` = '".$row['id']."' ");
    
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Edit Email Marketing Campaign (".check_string($_POST['name']).")"
        ]);
        die('<script type="text/javascript">if(!alert("Successful !")){location.href = "";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Failure !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Campaign</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/email-campaigns');?>">Email Campaigns</a></li>
                        <li class="breadcrumb-item active">Edit Campaign</li>
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
                            <i class="fa-solid fa-envelopes-bulk mr-1"></i>
                               EDIT CAMPAIGN
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
                                <h4 class="text-center"><?=__('Configure Campaign Recipients');?></h4>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?=__('Campaign Name');?></label>
                                    <input class="form-control" type="text" placeholder="Nhập tên cho chiến dịch" value="<?=$row['name'];?>" name="name" required>
                                </div>
                                <hr>
                                <h4 class="text-center"><?=__('Compose Message');?></h4>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Subject</label>
                                    <input class="form-control" type="text" value="<?=$row['subject'];?>"  name="subject" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CC</label>
                                    <input class="form-control" type="text" value="<?=$row['cc'];?>"  name="cc" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">BCC</label>
                                    <input class="form-control" type="text" value="<?=$row['bcc'];?>"  name="bcc" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Content</label>
                                    <textarea class="form-control" name="content" required><?=$row['content'];?></textarea>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="submit" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-paper-plane mr-1"></i>Save</button>
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