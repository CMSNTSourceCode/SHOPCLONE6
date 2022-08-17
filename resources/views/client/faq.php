<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('FAQ').' | '.$CMSNT->site('title'),
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
    <div id="faqAccordion" class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="iq-accordion career-style faq-style">
                    <?php foreach ($CMSNT->get_list("SELECT * FROM `questions` WHERE `status` = 1 ") as $row) {?>
                    <div class="card iq-accordion-block">
                        <div class="active-faq clearfix" id="headingTwo">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12"><a role="contentinfo" class="accordion-title collapsed"
                                            data-toggle="collapse" data-target="#collapseTwo<?=$row['id'];?>" aria-expanded="false"
                                            aria-controls="collapseTwo<?=$row['id'];?>"><span> <?=__($row['question']);?>
                                            </span> </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-details collapse" id="collapseTwo<?=$row['id'];?>" aria-labelledby="headingTwo"
                            data-parent="#faqAccordion">
                            <p class="mb-0"><?=__($row['answer']);?></p>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once(__DIR__.'/footer.php');?>