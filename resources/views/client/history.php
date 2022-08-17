<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Nhật ký hoạt động').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '

 ';
$body['footer'] = '

 ';

require_once(__DIR__.'/../../../models/is_user.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Nhật ký hoạt động');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="40%"><?=__('Hành động');?></th>
                                        <th><?=__('Thời gian');?></th>
                                        <th><?=__('Địa chỉ IP');?></th>
                                        <th width="25%"><?=__('Thiết bị');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE `user_id` = '".$getUser['id']."'  ORDER BY id DESC  ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['action'];?></td>
                                        <td><?=$row['createdate'];?></td>
                                        <td><?=$row['ip'];?></td>
                                        <td><?=$row['device'];?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once(__DIR__.'/footer.php');?>