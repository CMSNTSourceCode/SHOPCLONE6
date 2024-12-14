<?php
if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$CMSNT = new DB();



if(checkWhiteDomain($_SERVER['SERVER_NAME']) != true){
    if($CMSNT->site('license_key') == '' || checkLicenseKey($CMSNT->site('license_key'))['status'] != true){
        if (isset($_POST['btnSaveLicense'])) {
            if ($CMSNT->site('status_demo') != 0) {
                die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
            }
            foreach ($_POST as $key => $value) {
                $CMSNT->update("settings", array(
                    'value' => $value
                ), " `name` = '$key' ");
            }
            $checkKey = checkLicenseKey($CMSNT->site('license_key'));
            if($checkKey['status'] != true){
                die('<script type="text/javascript">if(!alert("'.$checkKey['msg'].'")){window.history.back().location.reload();}</script>');
            }
            die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
        } ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cấu hình thông tin bản quyền</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">THÔNG TIN BẢN QUYỀN CODE</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Mã bản quyền (license key)</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="license_key" placeholder="Nhập mã bản quyền của bạn để sử dụng chức năng này" value="<?=$CMSNT->site('license_key');?>"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveLicense" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">HƯỚNG DẪN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Quý khách có thể lấy License key tại đây: <a target="_blank" href="https://client.cmsnt.co/clientarea.php?action=products&module=licensing">https://client.cmsnt.co/clientarea.php?action=products&module=licensing</a></p>
                        <p>Nếu quý khách mua hàng tại CMSNT.CO mà chưa có License key, vui lòng liên hệ Zalo <b>0947838128</b> để được cấp.</p>
                        <p>Chỉ áp dúng cho những ai mua code, không hỗ trợ những trường hợp mua lại hay sử dụng mã nguồn lậu.</p>
                        <p>Nếu bạn chưa mua code tại CMSNT.CO, bạn có thể mua giấy phép tại đây: <a target="_blank" href="https://www.cmsnt.co/2021/12/shopclone6-thiet-ke-website-ban-nguyen.html">CLIENT CMSNT</a></p>
                        <img src="https://i.imgur.com/VzDVIx0.png" width="100%">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php 
    require_once(__DIR__."/../resources/views/admin/footer.php");
?>
<?php die(); } } ?>