<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Blogs').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
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

require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-7">
                <h3 class="mb-3"><?=__('Danh sách bài viết');?></h3>
                <?php foreach ($CMSNT->get_list("SELECT * FROM `blogs` WHERE `display` = 1 ORDER BY id DESC ") as $blog) {?>
                <div class="col-md-12 col-lg-12">
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-lg-4">
                                <a href="<?=base_url('client/blog/'.$blog['slug']);?>"><img src="<?=base_url($blog['image']);?>" style="width: 100%; height: 150px;" class="card-img" alt="#"></a>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="<?=base_url('client/blog/'.$blog['slug']);?>"><?=$blog['title'];?></a></h5>
                                     
                                    <p class="card-text"><small class="text-muted"><?=$blog['create_date'];?></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

            </div>
            <div class="col-sm-5">
                <h3 class="mb-3"><?=__('Bài viết nổi bật');?></h3>
                <?php foreach ($CMSNT->get_list("SELECT * FROM `blogs` WHERE `display` = 1 ORDER BY `view` DESC ") as $blog) {?>
                <div class="col-md-12 col-lg-12">
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-lg-4">
                                <a href="<?=base_url('client/blog/'.$blog['slug']);?>"><img src="<?=base_url($blog['image']);?>" style="height: 100%;" class="card-img" alt="#"></a>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="<?=base_url('client/blog/'.$blog['slug']);?>"><?=$blog['title'];?></a></h5>
                                    <p class="card-text"><small class="text-muted"><?=$blog['create_date'];?></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

            </div>
        </div>
    </div>
</div>


<?php require_once(__DIR__.'/footer.php');?>