<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
} ?>
<nav class="main-header navbar navbar-expand navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= BASE_URL(''); ?>" class="nav-link">TRANG KHÁCH</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://www.cmsnt.co/" target="_blank" class="nav-link">LIÊN HỆ</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://zalo.me/g/idapcx933" target="_blank" class="nav-link">BOX ZALO</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://www.youtube.com/playlist?list=PLylqe6Lzq699BYT-ZXL5ZZg4gaNqwGpEW" target="_blank" class="nav-link">HƯỚNG DẪN SỬ DỤNG</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" type="button" data-toggle="modal" data-target="#modal-lg" class="nav-link">CRON JOB</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url_admin('addons'); ?>" class="nav-link">MUA THÊM CHỨC
                NĂNG</a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="https://me.momo.vn/MRI4uZf5FpiVUGipTktA" target="_blank" class="nav-link">DONATE</a>
        </li> -->
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<div class="modal fade" id="modal-lg">
<div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">CRON JOB</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="height:100%">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>URL</th>
                            <th>CRON GẦN ĐÂY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cron khi dùng nạp tiền momo tự động</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/momo.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi dùng nạp tiền ngân hàng tự động</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/bank.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_bank')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi dùng nạp tiền thesieure tự động</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/thesieure.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_thesieure')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi dùng nạp tiền zalo pay tự động</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/zalopay.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_zalopay')); ?></td>
                        </tr>
                        <tr>
                            <td>Bắt buộc cron</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_cron')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi cần tính năng check live clone/via facebook</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/checklivefb.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_checklivefb')); ?></td>
                        </tr>
                        <tr>
                            <td>Bắt buộc cron</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron1.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron1')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi kết nối API website của CMSNT</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron2.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron2')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi dùng tính năng nạp crypto tự động</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/nowpayments.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_crypto')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi kết nối API 1</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron3.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron3')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi kết nối API 4</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron4.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron3')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi kết nối API DONGVAN..</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron_dongvanfb.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_dongvanfb')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi kết nối API 6</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron6.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron6')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi dùng chức năng gửi Email</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/sending_email.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_sending_email')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi kết nối API 7</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron7.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron7')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi sử dụng chức năng bán Like, Follow</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/UpdateRateService.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_UpdateRate5gsmm')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi sử dụng chức năng bán Like, Follow</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/UpdateHistoryService.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron_UpdateHistory5gsmm')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi kết nối API 8</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron8.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron8')); ?></td>
                        </tr>
                        <tr>
                            <td>Cron khi kết nối API 9</td>
                            <td><span class="badge bg-danger"><?= base_url('cron/cron9.php'); ?></span></td>
                            </td>
                            <td><?= timeAgo($CMSNT->site('check_time_cron9')); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <p>Hướng dẫn cấu hình cron xem tại đây: <a href="https://www.youtube.com/watch?v=JMi0Scjjdqc" target="_blank">https://www.youtube.com/watch?v=JMi0Scjjdqc</a></p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>