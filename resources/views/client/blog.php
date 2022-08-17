<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}

if (isset($_GET['id'])) {
    if (!$row = $CMSNT->get_row("SELECT * FROM `blogs` WHERE `slug` = '".check_string($_GET['id'])."' AND `display` = 1 ")) {
        redirect(base_url('client/blogs'));
    }
    $CMSNT->cong("blogs", 'view', 1, " `id` = '".$row['id']."' ");
}
$body = [
    'title' => __($row['title']).' | '.$CMSNT->site('title'),
    'desc'   => __($row['title']),
    'image'  => base_url($row['image']),
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-5"><?=__($row['title']);?></h3>
                        <?=base64_decode($row['content']);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once(__DIR__.'/footer.php');?>