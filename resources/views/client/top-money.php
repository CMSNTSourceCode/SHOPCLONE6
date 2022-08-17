<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Bảng Xếp Hạng Nạp Tiền').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';
if($CMSNT->site('sign_view_product') == 0){
    if (isset($_COOKIE["token"])) {
        $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_COOKIE['token'])."' ");
        if (!$getUser) {
            header("location: ".BASE_URL('client/logout'));
            exit();
        }
        $_SESSION['login'] = $getUser['token'];
    }
    if (isset($_SESSION['login'])) {
        require_once(__DIR__.'/../../../models/is_user.php');
    }
}else{
    require_once(__DIR__.'/../../../models/is_user.php');
}
if(checkAddon(4) != true){
    redirect(base_url(''));
}
if ($CMSNT->site('stt_topnap') != 1) {
    redirect(base_url(''));
}
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
                            <h4 class="card-title"><?=__('Bảng Xếp Hạng Nạp Tiền');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th class="text-center"><?=__('Xếp Hạng');?></th>
                                        <th><?=__('Thành Viên');?></th>
                                        <th><?=__('Tổng Nạp');?></th>
                                        <th class="text-center"><?=__('Vị Trí');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($CMSNT->get_list("SELECT * FROM `users` WHERE `banned` = 0 AND `total_money` > 0 AND `admin` != 1 ORDER BY `total_money` DESC LIMIT 10 ") as $row):?>
                                    <?php
                                        $CMSNT->update("users", [
                                            'rankings' => $i,
                                        ], " `id` = '".$row['id']."' ");
                                        if($i > $row['rankings']){
                                            $CMSNT->update("users", [
                                                'icon_ranking'  => '<i class="fas fa-long-arrow-alt-down text-danger"></i>'
                                            ], " `id` = '".$row['id']."' ");
                                            $rank = '<i class="fas fa-long-arrow-alt-down text-danger"></i>';
                                        }elseif($i < $row['rankings']){
                                            $CMSNT->update("users", [
                                                'icon_ranking'  => '<i class="fas fa-long-arrow-alt-up text-success"></i>'
                                            ], " `id` = '".$row['id']."' ");
                                            $rank = '<i class="fas fa-long-arrow-alt-up text-success"></i>';
                                        }else{
                                            $rank = $row['icon_ranking'];
                                        }
                                    ?>
                                    <tr>
                                        <td class="text-center"><b><?=$i++;?></b></td>
                                        <td><b><?=substr($row['username'], 0, 3);?>********</b></td>
                                        <td><b class="mr-1" style="color:blue;"><?=format_currency($row['total_money']);?></b></td>
                                        <td class="text-center"><?=$rank;?></td>
                                    </tr>
                                    <?php endforeach?>
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