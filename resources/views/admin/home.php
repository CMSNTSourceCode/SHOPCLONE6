<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Dashboard',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- DataTables  & Plugins -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/jszip/jszip.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/vfs_fonts.js"></script>   
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');


function where_not_admin($type){
    global $CMSNT;
    $where_not_admin = "";
    foreach ($CMSNT->get_list("SELECT * FROM `users` WHERE `admin` = 1 ") as $qw) {
        $where_not_admin .= " `$type` != '".$qw['id']."' AND";
    }
    return $where_not_admin;
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?=base_url_admin('addons');?>" type="button" class="btn btn-primary"><i class="fas fa-puzzle-piece mr-1"></i>CỬA HÀNG ADDONS</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h5>Gửi quý khách hàng của <b>CMSNT</b></h5>
                <ul>
                    <li>Quý khách vui lòng tham gia nhóm Zalo của CMSNT để nắm bắt thông tin cập nhật chi tiết của sản
                        phẩm, luôn luôn nhận được các thông báo mới nhất về CMSNT để tối ưu nhất trong quá trình hoạt
                        động.</li>
                    <li>Quý khách nhấn tham gia nhóm tại đây: <a target="_blank"
                            href="https://zalo.me/g/idapcx933">https://zalo.me/g/idapcx933</a></li>
                    <li>Inbox ngay cho CMSNT để được duyệt tham gia nhóm, chỉ áp dụng cho quý khách hàng mua chính chủ
                        tại <a target="_blank" href="https://cmsnt.vn/">CMSNT.CO - CMSNT.VN</a></li>
                    <li>Chúng tôi chấm dứt hỗ trợ nếu phát hiện bạn crack mã nguồn, addon của chúng tôi để dùng lậu nó.</li>
                </ul>
            </div>
            <div class="alert alert-dark">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <b>Phiên bản hiện tại: <span style="color: yellow;font-size:25px;"><?=$config['version'];?></span></b>
                <ul>
                    <li>17/08/2022; Tuỳ chỉnh số lượng đã bán từng sản phẩm trong edit sản phẩm.</li>
                    <li>15/08/2022: Tuỳ chọn thứ tự mua từng sản phẩm.</li>
                    <li>14/08/2022: Nick nào check live gần nhất sẽ ưu tiên bán trước thay vì nick nào thêm trước bán trước.</li>
                    <li>13/08/2022: Fix 1 số bill không Auto khi dùng Server 2.</li>
                    <li>06/08/2022; Fix Crypto.</li>
                    <li>01/08/2022: Tuỳ chỉnh ẩn sản phẩm khi hết tài khoản.</li>
                    <li>31/07/2022: Update tuỳ chỉnh giao dịch ảo tại <b>Cài Đặt</b> -> <b>Giao dịch ảo</b>.</li>
                    <li>29/07/2022: Tuỳ chỉnh trạng thái mặc định khi thêm sản phẩm API.</li>
                    <li>23/07/2022: Thêm nút Login user, thống kê lợi nhuận khi đấu API.</li>
                    <!-- <li>23/07/2022: Thêm chức năng nạp tiền tự động qua Crypto.</li>
                    <li>21/07/2022: Thêm Tuỳ chọn tự động cập tên sản phẩm API, thêm giá vốn cho đơn hàng API để xem lợi nhuận khi đấu API.</li>
                    <li>19/07/2022: Thêm tuỳ chỉnh ON/OFF thay password định kỳ.</li>
                    <li>17/07/2022: Thêm điều kiện giá trị đơn hàng được dùng mã giảm giá (<a href="<?=base_url_admin('coupon-list');?>"><?=base_url_admin('coupon-list');?></a>)</li>
                    <li>16/07/2022: Thêm chức năng tiếp thị liên kết (affiliates), update thêm chức năng kết nối API.</li>
                    <li>10/07/2022: Cập nhật chức năng kết nối API (<a href="<?=base_url_admin('connect-api');?>"><?=base_url_admin('connect-api');?></a>).</li> -->
                    <!-- <li>07/07/2022: Tăng tốc độ check live thêm, tuỳ chọn ẩn hiện menu khác.</li>
                    <li>07/07/2022: Update nhiều quá nên không nhớ update thứ gì.</li>
                    <li>04/07/2022: Fix lỗi xoá tài khoản SLL khi tích chọn.</li>
                    <li>01/07/2022: Xoá lọc định dạng tài khoản khi Import bằng API.</li> -->
                    <!-- <li>01/06/2022: Hiển thị thống kê nạp tiền Server2 vào Tổng tiền nạp.</li> -->
                    <!-- <li>25/05/2022: Fix Auto TPBank.</li>
                    <li>24/05/2022: Tăng tốc độ Auto MBBank (vui lòng theo dõi thêm).</li>
                    <li>23/05/2022: Fix auto bank server2.</li>
                    <li>15/05/2022: Để trống Flag để không hiện quốc gia sản phẩm.</li>
                    <li>13/05/2022: Fix hiển thị ghi chú Paypal.</li>
                    <li>08/05/2022: Thêm chức năng ON/OFF duyệt thành viên khi đăng ký (cấu hình trong cài đặt -> thông tin chung).</li>
                    <li>08/05/2022: Thêm chức năng Bảo Mật cho Admin (cấu hình trong bảo mật).</li>
                    <li>07/05/2022: Thêm Addon bán Fanpage/Group (trả phí), edit hiển thị chi tiết đơn hàng.</li>
                    <li>03/05/2022: Tăng số lượng hiển thị table.</li>
                    <li>01/05/2022: Thêm chức năng bán Tương Tác (miễn phí).</li> -->
                    <!-- <li>26/04/2022: Tối ưu load thống kê, thêm addon số lượng đã bán ảo (trả phí).</li>
                    <li>22/04/2022: Thêm nút reset top nạp tiền, fix lỗi check live fb.</li>
                    <li>21/04/2022: Fix lỗi hiển thị dịch ở vài nơi, điều chỉnh giá trị giao dịch ảo.</li>
                    <li>21/04/2022: Fix tăng tỉ lệ chính xác API Check Live Facebook.</li>
                    <li>21/04/2022: Thay ảnh nên Login, Register trong Admin</li>
                    <li>19/04/2022: Thêm Addon Nạp Tiền Server 2 (nạp tiền bằng nội dung + id, tính năng trả phí).</li>
                    <li>19/04/2022: Ẩn tài khoản Admin khỏi TOP MONEY.</li>
                    <li>18/04/2022: Update tuỳ chỉnh giới hạn mua tối thiểu và tối đa.</li>
                    <li>13/04/2022: Xuất dữ liệu sang Excel (CSV).</li>
                    <li>12/04/2022: Thêm Bảng Xếp Hạng Nạp Tiền (trả phí).</li> -->
                    <!-- <li>09/04/2022: Thêm giao diện bán sản phẩm Template 4 (trả phí).</li>
                    <li>09/04/2022: Thêm sản phẩm gợi ý.</li>
                    <li>08/04/2022: Fix lỗi www Addons.</li>
                    <li>07/04/2022: Thêm tính năng tự tạo giao dịch ảo (trả phí).</li>
                    <li>07/04/2022: Thêm giao diện bán sản phẩm Template 3 (trả phí).</li>
                    <li>07/04/2022: Thêm lịch sử nạp tiền gần đây trong trang khách hàng.</li>
                    <li>06/04/2022: Thêm giao diện hiển thị sản phẩm, tuỳ chỉnh on/off rating.</li>
                    <li>05/04/2022: Thêm tính năng <b>Xoá Đơn Hàng</b></li>
                    <li>05/04/2022: Tính năng xoá tài khoản hết hạn dành cho hotmail, proxy (tuỳ chỉnh trong edit sản phẩm).</li>
                    <li>02/04/2022: Thêm chức năng Promotion.</li> -->
                    <!-- <li>30/03/2022: Thay đổi FONT website trong <b>Cài Đặt</b>.</li>
                    <li>27/03/2022: Cập nhật modun Bán Tài Liệu (TUT/TRICK).</li>
                    <li>25/03/2022: ON/OFF Hiển thị SHOP.</li> -->
                    <!-- <li>24/03/2022: Fix lỗi mã giảm giá.</li>
                    <li>22/03/2022: Sắp xếp thứ tự chuyên mục bán tài khoản.</li>
                    <li>21/03/2022: Tuỳ chỉnh hiển thị sản phẩm trước và sau khi đăng nhập.</li>
                    <li>16/03/2022: Thành viên sẽ ghi nhớ phiên đăng nhập, còn Admin sẽ phải cần đăng nhập nhiều lần để tăng tính bảo mật.</li>
                    <li>15/03/2022: Chặn đăng nhập quản trị nếu Fake IP.</li>
                    <li>13/03/2022: Update hiển thị danh sách acc đã bán.</li>
                    <li>13/03/2022: Tăng độ dài sản phẩm lên 1.000 ký tự thay vì 255 như mặc định.</li>
                    <li>13/03/2022: Fix API importAccount, xoá lưu đăng nhập bằng cookie.</li>
                    <li>11/03/2022: Update nội dung nạp tiền, không phân biệt chữ hoa hay thường.</li>
                    <li>10/03/2022: Fix nạp thẻ cào.</li> 
                    <li>25/02/2022: Fix nạp thẻ, thêm hiển thị task cron job để debug lỗi.</li>
                    <li>25/02/2022: Update chức năng bài viết, tối ưu chi tiết 1 vài thứ.</li>
                    <li>24/02/2022: Fix hiển thị hoá đơn, điều chỉnh thứ tự hiển thị sản phẩm.</li>
                    <li>11/02/2022: Hiển thị giao dịch gần đây.</li>
                    <li>10/02/2022: Thêm phương tức thanh toán crypto thủ công, tối ưu tốc độ load.</li>
                    <li>13/01/2022: Thêm phương thức thanh toán qua Perfect Money</li>
                    <li>12/01/2022: Thêm tính năng vòng quay may mắn.</li>
                    <li>09/01/2022: Tuỳ chỉnh hiệu ứng nhấp chuột, gửi email đến từng user.</li>
                    <li>07/01/2022: Gửi Email thông tin đơn hàng sau khi mua hàng, chỉnh thời gian hết hạn hoá đơn theo
                        ý.</li>
                    <li>06/01/2022: Update nạp tiền qua Paypal tự động.</li>
                    <li>05/01/2022: Cho phép dùng thẻ HTML vào tiêu đề và mô tả sản phẩm.</li>
                    <li>04/01/2022: Thêm tiền tệ USD và tuỳ chỉnh rate theo ý.</li>
                    <li>03/01/2022: Thêm thời gian check live và tuỳ chỉnh thời gian check.</li>
                    <li>02/01/2022: Tuỳ chọn min nạp, fix hiển thị sản phẩm, fix 1 số lỗi nhỏ.</li>
                    <li>30/12/2021: Thêm nạp tiền tự động qua Zalo Pay.</li>
                    <li>29/12/2021: Thêm tuỳ chọn ON/OFF hiển thị đã bán, chiết khấu giảm giá từng thành viên.</li> -->
                </ul>
                <i>Hệ thống tự động cập nhật phiên bản mới nhất khi vào trang Quản Trị.</i>
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `fake` = 0 ")['COUNT(id)']);?></h3>
                            <p>Đơn hàng đã bán</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL ")['COUNT(id)']);?>
                            </h3>
                            <p>Tài khoản đã bán</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` ")['COUNT(id)']);?></h3>
                            <p>Tổng thành viên</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?=base_url_admin('users');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 ")['SUM(`pay`)']);?>
                            </h3>
                            <p>Doanh thu đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê tháng <?=date('m', time());?></h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê tuần</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê hôm nay</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền nạp toàn thời gian</span>
                            <span class="info-box-number"><?=format_currency(
    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` ")['SUM(`price`)']+
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` ")['SUM(amount)']+
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' ")['SUM(price)']
);?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền nạp tháng <?=date('m', time());?></span>
                            <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`pay`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE  YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`price`)']
                                +
                                $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(amount)'] 
                                +
                                $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND YEAR(created_at) = ".date('Y')." AND MONTH(created_at) = ".date('m')." ")['SUM(price)']
                                
                                );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền nạp tuần</span>
                            <span class="info-box-number"><?=format_currency(
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE WEEK(create_gettime, 1) = WEEK(CURDATE(), 1) ")['SUM(amount)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND WEEK(created_at, 1) = WEEK(CURDATE(), 1) ")['SUM(price)']
                                );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền nạp hôm nay</span>
                            <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `create_gettime` >= DATE(NOW()) AND `create_gettime` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(amount)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND `created_at` >= DATE(NOW()) AND `created_at` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(price)']
                                    );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                200 GIAO DỊCH GẦN ĐÂY (<i>Ẩn dòng tiền của Admin</i>)
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
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Username</th>
                                            <th>Số tiền trước</th>
                                            <th>Số tiền thay đổi</th>
                                            <th>Số tiền hiện tại</th>
                                            <th>Thời gian</th>
                                            <th>Nội dung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE ".where_not_admin('user_id')." `id` > 0 ORDER BY id DESC LIMIT 200 ") as $row) {?>
                                        <tr>
                                            <td class="text-center"><?=$i++;?></td>
                                            <td class="text-center"><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: green;"><?=format_currency($row['sotientruoc']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: blue;"><?=format_currency($row['sotiensau']);?></b>
                                            </td>
                                            <td class="text-center"><i><?=$row['thoigian'];?></i></td>
                                            <td><i><?=$row['noidung'];?></i></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end align-items-center border-top-table p-2">
                                <a type="button" href="<?=base_url_admin('dong-tien');?>" class="btn btn-primary">Xem
                                    Thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                200 NHẬT KÝ HOẠT ĐỘNG GẦN ĐÂY (<i>Ẩn nhật ký của Admin</i>)
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
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table id="datatable2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Username</th>
                                            <th width="40%">Action</th>
                                            <th>Time</th>
                                            <th>Ip</th>
                                            <th width="30%">Device</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE ".where_not_admin('user_id')." `id` > 0 ORDER BY id DESC LIMIT 200 ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td class="text-center"><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                            </td>
                                            <td><?=$row['action'];?></td>
                                            <td><?=$row['createdate'];?></td>
                                            <td><?=$row['ip'];?></td>
                                            <td><?=$row['device'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end align-items-center border-top-table p-2">
                                <a type="button" href="<?=base_url_admin('logs');?>" class="btn btn-primary">Xem
                                    Thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


<?php
require_once(__DIR__.'/footer.php');
?>
 