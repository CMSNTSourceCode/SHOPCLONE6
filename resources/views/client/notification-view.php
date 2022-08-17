<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Chi tiết thông báo').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';

require_once(__DIR__.'/../../../models/is_user.php');
if (isset($_GET['id'])) {
    if (!$row = $CMSNT->get_row("SELECT * FROM `notifications` WHERE `id` = '".check_string($_GET['id'])."' AND `user_id` = '".$getUser['id']."' ")) {
        redirect(base_url('client/'));
    }
} else {
    redirect(base_url('client/'));
}
$CMSNT->update("notifications", [
    'status'    => 1
], " `id` = '".$row['id']."' ");

require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-3"><?=$row['title'];?></h3>
                        <?=$row['content'];?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require_once(__DIR__.'/footer.php');?>