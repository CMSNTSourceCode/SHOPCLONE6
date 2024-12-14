<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Theme',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '

';
$body['footer'] = '
<!-- bs-custom-file-input -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script> 
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
 
?>
 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Theme</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Theme</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php
    if (isset($_POST['SaveSettings'])) {
        if ($CMSNT->site('status_demo') != 0) {
            die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
        }
        if (check_img('logo_light') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/logo_light_'.$rand.'.png';
            $tmp_name = $_FILES['logo_light']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'logo_light' ");
            }
        }
        if (check_img('logo_dark') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/logo_dark_'.$rand.'.png';
            $tmp_name = $_FILES['logo_dark']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'logo_dark' ");
            }
        }
        if (check_img('favicon') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/favicon_'.$rand.'.png';
            $tmp_name = $_FILES['favicon']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'favicon' ");
            }
        }
        if (check_img('image') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/image_'.$rand.'.png';
            $tmp_name = $_FILES['image']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'image' ");
            }
        }
        if (check_img('bg_login') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/bg_login'.$rand.'.png';
            $tmp_name = $_FILES['bg_login']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'bg_login' ");
            }
        }
        if (check_img('bg_register') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/bg_register'.$rand.'.png';
            $tmp_name = $_FILES['bg_register']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'bg_register' ");
            }
        }
        if (check_img('gif_loading') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/gif_loading'.$rand.'.png';
            $tmp_name = $_FILES['gif_loading']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'gif_loading' ");
            }
        }
        if (check_img('gif_loader') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/gif_loader'.$rand.'.png';
            $tmp_name = $_FILES['gif_loader']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'gif_loader' ");
            }
        }
        if (check_img('gif_giftbox') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/gif_giftbox'.$rand.'.png';
            $tmp_name = $_FILES['gif_giftbox']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'gif_giftbox' ");
            }
        }
        if (check_img('bg_card') == true) {
            $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
            $uploads_dir = 'assets/storage/images/bg_card'.$rand.'.png';
            $tmp_name = $_FILES['bg_card']['tmp_name'];
            $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
            if ($addlogo) {
                $CMSNT->update('settings', [
                    'value'  => $uploads_dir
                ], " `name` = 'bg_card' ");
            }
        }
        die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
    } ?>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-image mr-1"></i>
                                THAY ĐỔI GIAO DIỆN WEBSITE
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Logo Light</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="logo_light">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px" src="<?=BASE_URL($CMSNT->site('logo_light'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Logo Dark</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="logo_dark">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px" src="<?=BASE_URL($CMSNT->site('logo_dark'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Favicon</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="favicon">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="100px" src="<?=BASE_URL($CMSNT->site('favicon'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px" src="<?=BASE_URL($CMSNT->site('image'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Background Login</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="bg_login">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px" src="<?=BASE_URL($CMSNT->site('bg_login'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Background Register</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="bg_register">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px" src="<?=BASE_URL($CMSNT->site('bg_register'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Gif Loading</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="gif_loading">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="100px" src="<?=BASE_URL($CMSNT->site('gif_loading'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Gif Loader</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="gif_loader">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="100px" src="<?=BASE_URL($CMSNT->site('gif_loader'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Gif Giftbox</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="gif_giftbox">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="100px" src="<?=BASE_URL($CMSNT->site('gif_giftbox'));?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Background Card</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="bg_card">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="300px" src="<?=BASE_URL($CMSNT->site('bg_card'));?>" />
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
require_once(__DIR__.'/footer.php');
?>