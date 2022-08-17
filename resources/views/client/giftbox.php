<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


$body = [
    'title'     => __('Mở hộp quà').' | '.$CMSNT->site('title'),
    'desc'      => $CMSNT->site('description'),
    'keyword'   => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';
require_once(__DIR__."/../../../libs/database/users.php");
require_once(__DIR__.'/../../../models/is_user.php');
require_once(__DIR__.'/header.php');
if (isset($_GET['id'])) {
    if (!$row = $CMSNT->get_row("SELECT * FROM `giftbox` WHERE `id` = '".check_string($_GET['id'])."' ")) {
        redirect(base_url(''));
    }
    if ($row['user_id'] == $getUser['id']) {
        $data = [
            'msg1'  => '<font style="color:red;">'.__('Nhận Quà Thất Bại').'</font>',
            'msg2'  => __('Bạn đã mở hộp quà này rồi')
        ];
    } elseif ($row['status'] != 0) {
        $data = [
            'msg1'  => '<font style="color:red;">'.__('Nhận Quà Thất Bại').'</font>',
            'msg2'  => __('Hộp quà này đã có người nhận, chúc bạn máy mắn lần sau')
        ];
    } elseif ($row['status'] == 0 && $row['user_id'] == 0) {
        $data = [
            'msg1'  => '<font style="color:green;">'.__('Nhận Quà Thành Công').'</font> <script>confetti();audio1.play();</script>',
            'msg2'  => __('Chúc mừng bạn đã nhận được hộp quà trị giá').' <b style="color:red">'.format_currency($row['price']).'</b> '
        ];
        $isUpdate = $CMSNT->update("giftbox", [
            'update_date'   => gettime(),
            'status'        => 1,
            'user_id'       => $getUser['id']
        ], " `id` = '".$row['id']."' AND `status` = 0 ");
        if ($isUpdate) {
            $User = new users();
            $User->AddCredits($getUser['id'], $row['price'], 'Mở hộp quà trị giá '.format_currency($row['price']));
        }
    }
}
?>
<script>
    var audio1 = new Audio('<?=base_url('assets/audio/congratulation.mp3');?>');
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
<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <div class="wrapper">
        <section class="login-content">
            <div class="container-fluid h-100">
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-lg-12 text-center">
                                        <img src="<?=base_url($CMSNT->site('gif_giftbox'));?>"
                                            class="img-fluid  rounded-normal  darkmode-logo" width="250" alt="logo">
                                        <img src="<?=base_url($CMSNT->site('gif_giftbox'));?>"
                                            class="img-fluid rounded-normal light-logo" width="250" alt="logo">
                                        <h2 class="mt-3 mb-0"><?=$data['msg1'];?></h2>
                                        <p class="mb-1"><?=$data['msg2'];?></p>
                                        <div class="d-inline-block w-100">
                                            <a href="<?=base_url('');?>" class="btn btn-primary mt-3">
                                                <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                </svg>
                                                <span><?=__('Quay về Trang Chủ');?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Backend Bundle JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/backend-bundle.min.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/customizer.js"></script>
    <script src="<?=BASE_URL('public/datum');?>/assets/js/sidebar.js"></script>
    <!-- Flextree Javascript-->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/flex-tree.min.js"></script>
    <script src="<?=BASE_URL('public/datum');?>/assets/js/tree.js"></script>
    <!-- Table Treeview JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/table-treeview.js"></script>
    <!-- SweetAlert JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/sweetalert.js"></script>
    <!-- Vectoe Map JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/vector-map-custom.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/chart-custom.js"></script>
    <script src="<?=BASE_URL('public/datum');?>/assets/js/charts/01.js"></script>
    <script src="<?=BASE_URL('public/datum');?>/assets/js/charts/02.js"></script>
    <!-- slider JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/slider.js"></script>
    <!-- Emoji picker -->
    <script src="<?=BASE_URL('public/datum');?>/assets/vendor/emoji-picker-element/index.js" type="module"></script>
    <!-- app JavaScript -->
    <script src="<?=BASE_URL('public/datum');?>/assets/js/app.js"></script>
</body>

</html>
