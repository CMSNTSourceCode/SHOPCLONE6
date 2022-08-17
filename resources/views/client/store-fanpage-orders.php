<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Lịch sử đơn hàng mua Fanpage/Group').' | '.$CMSNT->site('title'),
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
                <div class="alert bg-white alert-primary" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text"><?=$CMSNT->site('notice_store_fanpage');?></div>
                </div>
            </div>
            <div class="col-lg-6 text-left">
                <div class="mb-3">
                    <a href="<?=$_SERVER['HTTP_REFERER'];?>" type="button" class="btn btn-danger btn-sm"><i
                            class="fas fa-arrow-left mr-1"></i><?=__('Quay Lại');?></a>
                </div>
            </div>
            <div class="col-lg-6 text-right">
 
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Lịch sử mua hàng');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped table-bordered mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%"><?=__('Fanpage/Group');?></th>
                                        <th><?=__('Số lượng Like/Mem');?></th>
                                        <th><?=__('Thời gian tạo');?></th>
                                        <th><?=__('Loại');?></th>
                                        <th><?=__('Giá');?></th>
                                        <th><?=__('Mô tả');?></th>
                                        <th><?=__('FB Admin');?></th>
                                        <th><?=__('Tên cần đổi');?></th>
                                        <th><?=__('Ghi chú từ người bán');?></th>
                                        <th><?=__('Thời gian');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list(" SELECT * FROM `store_fanpage` WHERE `buyer` = '".$getUser['id']."' ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td>
                                            <a href="https://www.facebook.com/<?=$row['uid'];?>" target="_blank">
                                                <img src="<?=base_url($row['icon']);?>" width="50px" height="50px"
                                                    class="avatar-rounded" alt="<?=$row['name'];?>">
                                                <span class="mb-0 ml-2"><?=$row['name'];?></span>
                                            </a>
                                        </td>
                                        <td><b style="color:blue;"><?=format_cash($row['sl_like']);?></b></td>
                                        <td><b><?=$row['nam_tao_fanpage'];?></b></td>
                                        <td><b><?=$row['type'];?></b></td>
                                        <td><b style="color:red;"><?=format_currency($row['price']);?></b></td>
                                        <td><?=base64_decode($row['content']);?></td>
                                        <td><a href="<?=$row['fb_admin'];?>" target="_blank"><?=$row['fb_admin'];?></a></td>
                                        <td><?=$row['new_name'];?></td>
                                        <td><?=$row['note'];?></td>
                                        <td><?=$row['update_gettime'];?> - <?=timeAgo($row['update_time']);?></td>
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
 