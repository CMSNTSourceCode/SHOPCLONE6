<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Biến động số dư').' | '.$CMSNT->site('title'),
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
                            <h4 class="card-title"><?=__('Biến động số dư');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-hover mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th class="text-center"><?=__('Số tiền trước');?></th>
                                        <th class="text-center"><?=__('Số tiền thay đổi');?></th>
                                        <th class="text-center"><?=__('Số tiền hiện tại');?></th>
                                        <th class="text-center"><?=__('Thời gian');?></th>
                                        <th><?=__('Nội dung');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE `user_id` = '".$getUser['id']."'  ORDER BY id DESC  ") as $row) {?>
                                    <tr>
                                        <td class="text-center"><?=$i++;?></td>
                                        <td class="text-center"><b style="color: green;"><?=format_currency($row['sotientruoc']);?></b></td>
                                        <td class="text-center"><b style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b></td>
                                        <td class="text-center"><b style="color: blue;"><?=format_currency($row['sotiensau']);?></b></td>
                                        <td class="text-center"><i><?=$row['thoigian'];?></i></td>
                                        <td><i><?=$row['noidung'];?></i></td>
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