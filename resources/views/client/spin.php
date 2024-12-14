<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title'     => __('Vòng quay may mắn').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';
require_once(__DIR__.'/../../../models/is_user.php');
if ($CMSNT->site('status_spin') != 1) {
    redirect(base_url(''));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<style>
.fortune__body {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -moz-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 20px;
    overflow: hidden
}

.fortune__wheel {
    width: 80%
}

.fortune__form {
    min-height: 350px;
    -webkit-flex-basis: 20%;
    -ms-flex-preferred-size: 20%;
    flex-basis: 20%;
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
    -moz-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -moz-box-orient: vertical;
    -moz-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -moz-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between
}

.fortune__form-subtitle,
.fortune__form-title {
    margin-bottom: 25px;
    font-size: 30px;
    white-space: nowrap
}

.fortune__form-logo {
    margin: 0 auto 25px;
    max-width: 80%;
    width: 100%;
    display: block
}

.fortune__form-btn {
    margin: 0 auto;
    max-width: 200px
}

.fortune__form-btn:hover {
    opacity: .8
}

.fortune__form-text {
    text-align: center;
    font-size: 20px;
    font-weight: 500
}

.fortune__form .form-error {
    text-align: center
}

.fortune__text {
    margin-bottom: 25px
}

.fortune__text-item {
    margin-bottom: 25px;
    color: #4072b0;
    line-height: 1.4
}

.fortune__text-card {
    padding: 15px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -moz-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -moz-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -moz-box-orient: vertical;
    -moz-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    height: 135px;
    background-color: #f0f0f0;
    border: 1px solid rgba(0, 0, 0, .125);
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    color: #222c38
}

.fortune__text-row {
    margin-bottom: 10px
}

.fortune__prize-desc a {
    color: #4172b0;
    text-decoration: underline
}

.blinking {
    -webkit-animation: blinkingText 1.2s infinite;
    -moz-animation: blinkingText 1.2s infinite;
    -o-animation: blinkingText 1.2s infinite;
    animation: blinkingText 1.2s infinite
}

@-webkit-keyframes blinkingText {
    0% {
        color: #4172b0
    }

    49% {
        color: #4172b0
    }

    60% {
        color: rgba(0, 0, 0, 0)
    }

    99% {
        color: rgba(0, 0, 0, 0)
    }

    to {
        color: #4172b0
    }
}

@-moz-keyframes blinkingText {
    0% {
        color: #4172b0
    }

    49% {
        color: #4172b0
    }

    60% {
        color: rgba(0, 0, 0, 0)
    }

    99% {
        color: rgba(0, 0, 0, 0)
    }

    to {
        color: #4172b0
    }
}

@-o-keyframes blinkingText {
    0% {
        color: #4172b0
    }

    49% {
        color: #4172b0
    }

    60% {
        color: rgba(0, 0, 0, 0)
    }

    99% {
        color: rgba(0, 0, 0, 0)
    }

    to {
        color: #4172b0
    }
}

@keyframes blinkingText {
    0% {
        color: #4172b0
    }

    49% {
        color: #4172b0
    }

    60% {
        color: rgba(0, 0, 0, 0)
    }

    99% {
        color: rgba(0, 0, 0, 0)
    }

    to {
        color: #4172b0
    }
}

.wheelText {
    font-size: 16px;
    font-family: Arial Black, Gadget, sans-serif;
    font-weight: 400;
    text-align: center;
    text-shadow: 2px 2px #434343;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-box-shadow: 3px 3px 6px 6px #434343;
    -moz-box-shadow: 3px 3px 6px 6px #434343;
    box-shadow: 3px 3px 6px 6px #434343;
    fill: #fff
}

@media (max-width:1220px) {
    .fortune__body {
        padding-top: 50px;
        padding-bottom: 30px
    }

    .fortune__wheel {
        -webkit-transform: scale(1.25);
        -moz-transform: scale(1.25);
        -ms-transform: scale(1.25);
        -o-transform: scale(1.25);
        transform: scale(1.25)
    }
}

@media (max-width:920px) {
    .fortune__body {
        max-width: 100%;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -moz-box-orient: vertical;
        -moz-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 50px
    }

    .fortune__wheel {
        width: 100%
    }

    .fortune__form {
        min-height: 120px
    }

    .fortune__form-subtitle,
    .fortune__form-title {
        font-size: 20px;
        white-space: normal
    }

    .fortune__form-logo {
        display: none
    }
}

@media (max-width:480px) {
    .fortune__body {
        padding-left: 10px;
        padding-right: 10px
    }
}

@media (max-width:350px) {
    .fortune__form {
        min-height: 350px
    }

    .fortune__form-subtitle,
    .fortune__form-title {
        font-size: 24px
    }
}

/*# sourceMappingURL=wheel.css.map*/
</style>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <div id="wheel" class="fortune__wheel">
                    <svg viewBox="0 0 800 800">
                        <g class="chartholder" transform="translate(400,400)">
                            <g id="vongquay">
                                <image xlink:href="<?=base_url('assets/img/wheel.webp');?>" width="800" height="800"
                                    x="-400" y="-400"></image>
                                <?php $spin = $CMSNT->get_list("SELECT * FROM `spin_option` WHERE `display` = 1 ");?>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(-78)translate(290)"><?=$spin[0]['name'];?>
                                        <path fill-opacity="0.0" fill="#1f77b4"
                                            d="M1.8369701987210297e-14,-300A300,300 0 0,1 122.02099292274006,-274.06363729278024L0,0Z">
                                        </path>
                                    </text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(-54)translate(290)"><?=$spin[1]['name'];?><path
                                            fill-opacity="0.0" fill="#aec7e8"
                                            d="M122.02099292274006,-274.06363729278024A300,300 0 0,1 222.94344764321826,-200.73918190765747L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(-30.000000000000007)translate(290)"><?=$spin[2]['name'];?>
                                        <path fill-opacity="0.0" fill="#ff7f0e"
                                            d="M222.94344764321826,-200.73918190765747A300,300 0 0,1 285.31695488854604,-92.70509831248422L0,0Z">
                                        </path>
                                    </text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(-6.000000000000014)translate(290)"><?=$spin[3]['name'];?><path
                                            fill-opacity="0.0" fill="#ffbb78"
                                            d="M285.31695488854604,-92.70509831248422A300,300 0 0,1 298.356568610482,31.358538980296018L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(18)translate(290)"><?=$spin[4]['name'];?><path
                                            fill-opacity="0.0" fill="#2ca02c"
                                            d="M298.356568610482,31.358538980296018A300,300 0 0,1 259.8076211353316,149.99999999999994L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(42)translate(290)"><?=$spin[5]['name'];?><path
                                            fill-opacity="0.0" fill="#98df8a"
                                            d="M259.8076211353316,149.99999999999994A300,300 0 0,1 176.33557568774194,242.70509831248424L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(66)translate(290)"><?=$spin[6]['name'];?><path
                                            fill-opacity="0.0" fill="#d62728"
                                            d="M176.33557568774194,242.70509831248424A300,300 0 0,1 62.37350724532777,293.4442802201417L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(90)translate(290)"><?=$spin[7]['name'];?><path
                                            fill-opacity="0.0" fill="#ff9896"
                                            d="M62.37350724532777,293.4442802201417A300,300 0 0,1 -62.37350724532787,293.44428022014165L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(114.00000000000003)translate(290)"><?=$spin[8]['name'];?><path
                                            fill-opacity="0.0" fill="#9467bd"
                                            d="M-62.37350724532787,293.44428022014165A300,300 0 0,1 -176.335575687742,242.70509831248418L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(138.00000000000003)translate(290)"><?=$spin[9]['name'];?><path
                                            fill-opacity="0.0" fill="#c5b0d5"
                                            d="M-176.335575687742,242.70509831248418A300,300 0 0,1 -259.80762113533166,149.99999999999986L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(162)translate(290)"><?=$spin[10]['name'];?><path
                                            fill-opacity="0.0" fill="#8c564b"
                                            d="M-259.80762113533166,149.99999999999986A300,300 0 0,1 -298.35656861048204,31.358538980295986L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(186.00000000000006)translate(290)"><?=$spin[11]['name'];?>
                                        <path fill-opacity="0.0" fill="#c49c94"
                                            d="M-298.35656861048204,31.358538980295986A300,300 0 0,1 -285.3169548885461,-92.70509831248418L0,0Z">
                                        </path>
                                    </text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(209.99999999999994)translate(290)"><?=$spin[12]['name'];?>
                                        <path fill-opacity="0.0" fill="#e377c2"
                                            d="M-285.3169548885461,-92.70509831248418A300,300 0 0,1 -222.94344764321835,-200.73918190765738L0,0Z">
                                        </path>
                                    </text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(234)translate(290)"><?=$spin[13]['name'];?><path
                                            fill-opacity="0.0" fill="#f7b6d2"
                                            d="M-222.94344764321835,-200.73918190765738A300,300 0 0,1 -122.02099292274028,-274.0636372927802L0,0Z">
                                        </path></text></g>
                                <g><text x="-110" y="5" class="wheelText" text-anchor="middle"
                                        text-rendering="optimizeLegibility"
                                        transform="rotate(257.9999999999999)translate(290)"><?=$spin[14]['name'];?><path
                                            fill-opacity="0.0" fill="#7f7f7f"
                                            d="M-122.02099292274028,-274.0636372927802A300,300 0 0,1 -3.2156263187166844e-13,-300L0,0Z">
                                        </path></text></g>

                            </g>
                        </g>
                        <image xlink:href="<?=base_url('assets/img/outwheel.webp');?>" width="800" height="800"></image>
                    </svg>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form py-5 text-center">
                            <h3 class="text-center mb-5"><?=__('Vòng quay may mắn');?></h3>
                            <div class="alert bg-white alert-primary" role="alert">
                                <div class="iq-alert-icon">
                                    <i class="ri-alert-line"></i>
                                </div>
                                <div class="iq-alert-text"><?=__($CMSNT->site('notice_spin'));?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-outline-success btn-block"><i
                                            class="fas fa-coins mr-1"></i><?=__('LƯỢT QUAY CÒN LẠI');?>:
                                        <?=$getUser['spin'];?></button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-danger btn-block"><i
                                            class="fas fa-cart-plus mr-1"></i><?=__('KIẾM LƯỢT QUAY');?></button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-block" id="quaybtn"><i
                                    class="fas fa-play mr-1"></i><?=__('QUAY NGAY');?></button>
                            <p class="form-error"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=__('Lịch Sử Quay Thưởng');?></h4>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table table-striped mb-0">
                                <thead class="table-color-heading">
                                    <tr>
                                        <th width="5%">STT</th>
                                        <th><?=__('Giải thưởng');?></th>
                                        <th><?=__('Thời gian');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `spin_history` WHERE `user_id` = '".$getUser['id']."'  ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['name'];?></td>
                                        <td><b style="font-size:15px;"><?=timeAgo($row['create_time']);?></b></td>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?=__('Cách kiếm thêm lượt quay');?></h5>                            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <?=__('Thanh toán 1 đơn hàng có giá lớn hơn hoặc bằng');?> <b style="color:red;"><?=format_currency($CMSNT->site('condition_spin'));?></b> <?=__('sẽ nhận được thêm 1 lượt quay.');?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=__('ĐÓNG');?></button>
            <a type="button" href="<?=base_url('client/home');?>" class="btn btn-primary"><?=__('Mua Ngay');?></a>
         </div>
      </div>
   </div>
</div>


<script src="<?=BASE_URL('assets/js/jquery.confetti.js');?>"></script>
<script>
$("#quaybtn").click(function() {
    StartSpin();
});

var quayStatus = true;
var quayCount = $(".wheelText").length;
var vp = 360 / quayCount;

function StartSpin() {
    if (quayStatus) {
        quayStatus = false;
    } else {
        return;
    }
    $('#quaybtn').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang chờ kết quả...');?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/spin.php');?>",
        method: "POST",
        data: {
            token: '<?=$getUser['token'];?>'
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status == 'error') {
                cuteToast({
                    type: "error",
                    message: response.msg,
                    timer: 5000
                });
                $('#quaybtn').html('<i class="fas fa-play mr-1"></i><?=__('QUAY NGAY');?>').prop('disabled',
                    false);
                return false;
            }
            var audio = new Audio('<?=base_url('assets/audio/roulette.mp3');?>');
            var audio1 = new Audio('<?=base_url('assets/audio/congratulation.mp3');?>');
            var out = response.location;
            var countLoop = 0;
            var x = 0;
            var loop = setInterval(() => {
                audio.play();
                document.getElementById("vongquay").style.transform = "rotate(" + (360 - x) +
                    "deg)";
                if (x >= vp * out - vp / 2 && countLoop == 2) {
                    clearInterval(loop);
                    quayStatus = true;
                    audio.pause();
                    audio1.play();
                    confetti();
                    cuteToast({
                        type: "success",
                        message: response.msg,
                        timer: 10000
                    });
                    $('#quaybtn').html('<i class="fas fa-play mr-1"></i><?=__('QUAY NGAY');?>')
                        .prop('disabled', false);
                } else {
                    if (x >= 360) {
                        countLoop = countLoop + 1;
                        x = 0;
                    }
                }
                x = x + 1;
            }, 1);
        }
    });
}


function confetti() {
    var onlyOnKonami = false;

    $(function() {
        // Globals
        var $window = $(window),
            random = Math.random,
            cos = Math.cos,
            sin = Math.sin,
            PI = Math.PI,
            PI2 = PI * 2,
            timer = undefined,
            frame = undefined,
            confetti = [];

        var runFor = 2000
        var isRunning = true

        setTimeout(() => {
            isRunning = false
        }, runFor);

        // Settings
        var konami = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65],
            pointer = 0;

        var particles = 150,
            spread = 20,
            sizeMin = 5,
            sizeMax = 12 - sizeMin,
            eccentricity = 10,
            deviation = 100,
            dxThetaMin = -.1,
            dxThetaMax = -dxThetaMin - dxThetaMin,
            dyMin = .13,
            dyMax = .18,
            dThetaMin = .4,
            dThetaMax = .7 - dThetaMin;

        var colorThemes = [
            function() {
                return color(200 * random() | 0, 200 * random() | 0, 200 * random() | 0);
            },
            function() {
                var black = 200 * random() | 0;
                return color(200, black, black);
            },
            function() {
                var black = 200 * random() | 0;
                return color(black, 200, black);
            },
            function() {
                var black = 200 * random() | 0;
                return color(black, black, 200);
            },
            function() {
                return color(200, 100, 200 * random() | 0);
            },
            function() {
                return color(200 * random() | 0, 200, 200);
            },
            function() {
                var black = 256 * random() | 0;
                return color(black, black, black);
            },
            function() {
                return colorThemes[random() < .5 ? 1 : 2]();
            },
            function() {
                return colorThemes[random() < .5 ? 3 : 5]();
            },
            function() {
                return colorThemes[random() < .5 ? 2 : 4]();
            }
        ];

        function color(r, g, b) {
            return 'rgb(' + r + ',' + g + ',' + b + ')';
        }

        // Cosine interpolation
        function interpolation(a, b, t) {
            return (1 - cos(PI * t)) / 2 * (b - a) + a;
        }

        // Create a 1D Maximal Poisson Disc over [0, 1]
        var radius = 1 / eccentricity,
            radius2 = radius + radius;

        function createPoisson() {
            // domain is the set of points which are still available to pick from
            // D = union{ [d_i, d_i+1] | i is even }
            var domain = [radius, 1 - radius],
                measure = 1 - radius2,
                spline = [0, 1];
            while (measure) {
                var dart = measure * random(),
                    i, l, interval, a, b, c, d;

                // Find where dart lies
                for (i = 0, l = domain.length, measure = 0; i < l; i += 2) {
                    a = domain[i], b = domain[i + 1], interval = b - a;
                    if (dart < measure + interval) {
                        spline.push(dart += a - measure);
                        break;
                    }
                    measure += interval;
                }
                c = dart - radius, d = dart + radius;

                // Update the domain
                for (i = domain.length - 1; i > 0; i -= 2) {
                    l = i - 1, a = domain[l], b = domain[i];
                    // c---d          c---d  Do nothing
                    //   c-----d  c-----d    Move interior
                    //   c--------------d    Delete interval
                    //         c--d          Split interval
                    //       a------b
                    if (a >= c && a < d)
                        if (b > d) domain[l] = d; // Move interior (Left case)
                        else domain.splice(l, 2); // Delete interval
                    else if (a < c && b > c)
                        if (b <= d) domain[i] = c; // Move interior (Right case)
                        else domain.splice(i, 0, c, d); // Split interval
                }

                // Re-measure the domain
                for (i = 0, l = domain.length, measure = 0; i < l; i += 2)
                    measure += domain[i + 1] - domain[i];
            }

            return spline.sort();
        }

        // Create the overarching container
        var container = document.createElement('div');
        container.style.position = 'fixed';
        container.style.top = '0';
        container.style.left = '0';
        container.style.width = '100%';
        container.style.height = '0';
        container.style.overflow = 'visible';
        container.style.zIndex = '9999';

        // Confetto constructor
        function Confetto(theme) {
            this.frame = 0;
            this.outer = document.createElement('div');
            this.inner = document.createElement('div');
            this.outer.appendChild(this.inner);

            var outerStyle = this.outer.style,
                innerStyle = this.inner.style;
            outerStyle.position = 'absolute';
            outerStyle.width = (sizeMin + sizeMax * random()) + 'px';
            outerStyle.height = (sizeMin + sizeMax * random()) + 'px';
            innerStyle.width = '100%';
            innerStyle.height = '100%';
            innerStyle.backgroundColor = theme();

            outerStyle.perspective = '50px';
            outerStyle.transform = 'rotate(' + (360 * random()) + 'deg)';
            this.axis = 'rotate3D(' +
                cos(360 * random()) + ',' +
                cos(360 * random()) + ',0,';
            this.theta = 360 * random();
            this.dTheta = dThetaMin + dThetaMax * random();
            innerStyle.transform = this.axis + this.theta + 'deg)';

            this.x = $window.width() * random();
            this.y = -deviation;
            this.dx = sin(dxThetaMin + dxThetaMax * random());
            this.dy = dyMin + dyMax * random();
            outerStyle.left = this.x + 'px';
            outerStyle.top = this.y + 'px';

            // Create the periodic spline
            this.splineX = createPoisson();
            this.splineY = [];
            for (var i = 1, l = this.splineX.length - 1; i < l; ++i)
                this.splineY[i] = deviation * random();
            this.splineY[0] = this.splineY[l] = deviation * random();

            this.update = function(height, delta) {
                this.frame += delta;
                this.x += this.dx * delta;
                this.y += this.dy * delta;
                this.theta += this.dTheta * delta;

                // Compute spline and convert to polar
                var phi = this.frame % 7777 / 7777,
                    i = 0,
                    j = 1;
                while (phi >= this.splineX[j]) i = j++;
                var rho = interpolation(
                    this.splineY[i],
                    this.splineY[j],
                    (phi - this.splineX[i]) / (this.splineX[j] - this.splineX[i])
                );
                phi *= PI2;

                outerStyle.left = this.x + rho * cos(phi) + 'px';
                outerStyle.top = this.y + rho * sin(phi) + 'px';
                innerStyle.transform = this.axis + this.theta + 'deg)';
                return this.y > height + deviation;
            };
        }


        function poof() {
            if (!frame) {
                // Append the container
                document.body.appendChild(container);

                // Add confetti

                var theme = colorThemes[onlyOnKonami ? colorThemes.length * random() | 0 : 0],
                    count = 0;

                (function addConfetto() {

                    if (onlyOnKonami && ++count > particles)
                        return timer = undefined;

                    if (isRunning) {
                        var confetto = new Confetto(theme);
                        confetti.push(confetto);

                        container.appendChild(confetto.outer);
                        timer = setTimeout(addConfetto, spread * random());
                    }
                })(0);


                // Start the loop
                var prev = undefined;
                requestAnimationFrame(function loop(timestamp) {
                    var delta = prev ? timestamp - prev : 0;
                    prev = timestamp;
                    var height = $window.height();

                    for (var i = confetti.length - 1; i >= 0; --i) {
                        if (confetti[i].update(height, delta)) {
                            container.removeChild(confetti[i].outer);
                            confetti.splice(i, 1);
                        }
                    }

                    if (timer || confetti.length)
                        return frame = requestAnimationFrame(loop);

                    // Cleanup
                    document.body.removeChild(container);
                    frame = undefined;
                });
            }
        }

        $window.keydown(function(event) {
            pointer = konami[pointer] === event.which ?
                pointer + 1 :
                +(event.which === konami[0]);
            if (pointer === konami.length) {
                pointer = 0;
                poof();
            }
        });

        if (!onlyOnKonami) poof();
    });
}
</script>

<?php require_once(__DIR__.'/footer.php');?>