<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
} ?>

</div>
</div>


<!-- Wrapper End-->
<footer class="iq-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="<?= BASE_URL('client/privacy-policy'); ?>"><?= __('Chính sách bảo mật'); ?></a></li>
                    <li class="list-inline-item"><a href="<?= BASE_URL('client/terms'); ?>"><?= __('Điều khoản sử dụng'); ?></a></li>
                </ul>
            </div>
            <div class="col-lg-6 text-right">
                <span class="mr-1">
                    <!-- <?= __('Copyright'); ?>
                    <script>
                    document.write(new Date().getFullYear())
                    </script>© <a href="#" class=""><?= $CMSNT->site('title'); ?></a>
                    <?= __('All Rights Reserved'); ?> |  -->
                    <?= __('Version'); ?> <b style="color: red;">
                        <?= $config['version']; ?>
                    </b> |
                    <?= $CMSNT->site('copyright_footer'); ?>
                </span>
            </div>
        </div>
    </div>
</footer>

<div class="switch">
    <div class="circle"></div>
</div>


<?php if ($CMSNT->site('mouse_click_effect') == 1) { ?>
    <script src="https://cdn.jsdelivr.net/mojs/latest/mo.min.js"></script>
    <script type="text/javascript">
        const OPTS = {
            fill: 'none',
            radius: 25,
            strokeWidth: {
                50: 0
            },
            scale: {
                0: 1
            },
            angle: {
                'rand(-35, -70)': 0
            },
            duration: 500,
            left: 0,
            top: 0,
            easing: 'cubic.out'
        };

        const circle1 = new mojs.Shape({
            ...OPTS,
            stroke: 'cyan',
        });

        const circle2 = new mojs.Shape({
            ...OPTS,
            radius: {
                0: 15
            },
            strokeWidth: {
                30: 0
            },
            stroke: 'magenta',
            delay: 'rand(75, 150)'
        });

        document.addEventListener('click', function (e) {

            circle1
                .tune({
                    x: e.pageX,
                    y: e.pageY
                })
                .replay();

            circle2
                .tune({
                    x: e.pageX,
                    y: e.pageY
                })
                .replay();

        });
    </script>
<?php } ?>
<?php if ($CMSNT->site('mouse_click_effect') == 2) { ?>
    <script src="https://cdn.jsdelivr.net/mojs/latest/mo.min.js"></script>
    <script type="text/javascript">
        const COLORS = {
            RED: '#FD5061',
            YELLOW: '#FFCEA5',
            BLACK: '#29363B',
            WHITE: 'white',
            VINOUS: '#A50710'
        }

        const burst1 = new mojs.Burst({
            left: 0,
            top: 0,
            count: 8,
            radius: {
                50: 150
            },
            children: {
                shape: 'line',
                stroke: ['white', '#FFE217', '#FC46AD', '#D0D202', '#B8E986', '#D0D202'],
                scale: 1,
                scaleX: {
                    1: 0
                },
                // pathScale:    'rand(.5, 1.25)',
                degreeShift: 'rand(-90, 90)',
                radius: 'rand(20, 40)',
                // duration:     200,
                delay: 'rand(0, 150)',
                isForce3d: true
            }
        });

        const largeBurst = new mojs.Burst({
            left: 0,
            top: 0,
            count: 4,
            radius: 0,
            angle: 45,
            radius: {
                0: 450
            },
            children: {
                shape: 'line',
                stroke: '#4ACAD9',
                scale: 1,
                scaleX: {
                    1: 0
                },
                radius: 100,
                duration: 450,
                isForce3d: true,
                easing: 'cubic.inout'
            }
        });

        const CIRCLE_OPTS = {
            left: 0,
            top: 0,
            scale: {
                0: 1
            },
        }

        const largeCircle = new mojs.Shape({
            ...CIRCLE_OPTS,
            fill: 'none',
            stroke: 'white',
            strokeWidth: 4,
            opacity: {
                .25: 0
            },
            radius: 250,
            duration: 600,
        });

        const smallCircle = new mojs.Shape({
            ...CIRCLE_OPTS,
            fill: 'white',
            opacity: {
                .5: 0
            },
            radius: 30,
        });

        document.addEventListener('click', function (e) {

            burst1
                .tune({
                    x: e.pageX,
                    y: e.pageY
                })
                .generate()
                .replay();

            largeBurst
                .tune({
                    x: e.pageX,
                    y: e.pageY
                })
                .replay();

            largeCircle
                .tune({
                    x: e.pageX,
                    y: e.pageY
                })
                .replay();

            smallCircle
                .tune({
                    x: e.pageX,
                    y: e.pageY
                })
                .replay();

        });
    </script>
<?php } ?>
<?php if ($CMSNT->site('mouse_click_effect') == 3) { ?>
    <script src="https://cdn.jsdelivr.net/mojs/latest/mo.min.js"></script>
    <script type="text/javascript">
        const COLORS = {
            RED: '#FD5061',
            YELLOW: '#FFCEA5',
            BLACK: '#29363B',
            WHITE: 'white',
            VINOUS: '#A50710'
        }

        const DURATION = 500;
        const CNT = 10;
        const PARENT_H = 50;
        const BURST_R = 75;
        const SHIFT = 300;

        const makeDust = (dir = -1) => {

            const parent = new mojs.Shape({
                left: 0,
                top: 0,
                width: 200,
                height: 50,
                radius: 0,
                x: {
                    0: dir * SHIFT
                },
                duration: 1.2 * DURATION,
                isShowStart: true,
                isTimelineLess: true,
                isForce3d: true
            });

            parent.el.style['overflow'] = 'hidden';

            const burst = new mojs.Burst({
                parent: parent.el,
                count: CNT,
                top: PARENT_H + BURST_R,
                degree: 90,
                radius: BURST_R,
                angle: (dir === -1) ? {
                    [-90]: 40
                } : {
                    [0]: -130
                },
                children: {
                    fill: 'white',
                    delay: (dir === -1) ?
                        `stagger(${DURATION}, -${DURATION / CNT})` : `stagger(${DURATION / CNT})`,
                    radius: 'rand(8, 25)',
                    direction: -1,
                    isSwirl: true,
                    isForce3d: true
                }
            });

            const fadeBurst = new mojs.Burst({
                parent: parent.el,
                count: 2,
                degree: 0,
                angle: -1 * dir * 75,
                radius: {
                    0: 100
                },
                top: '90%',
                timeline: {
                    delay: .8 * DURATION
                },
                children: {
                    fill: 'white',
                    pathScale: [.65, 1],
                    radius: 'rand(12, 15)',
                    direction: [dir, -1 * dir],
                    isSwirl: true,
                    isForce3d: true
                }
            });

            const timeline = new mojs.Timeline();
            timeline.add(parent, burst, fadeBurst);

            return {
                parent,
                timeline
            };
        }

        const circle = new mojs.Shape({
            left: 0,
            top: 0,
            strokeWidth: 10,
            fill: 'none',
            radius: 150,
            scale: {
                0: 1
            },
            opacity: {
                1: 0
            },
            shape: 'circle',
            stroke: 'white',
            strokeWidth: 10,
            fill: 'none',
            duration: 1.5 * DURATION,
            isForce3d: true,
            isTimelineLess: true,
        });

        const cloud = new mojs.Burst({
            left: 0,
            top: 0,
            radius: {
                4: 49
            },
            angle: 45,
            count: 12,
            children: {
                radius: 10,
                fill: 'white',
                scale: {
                    1: 0,
                    easing: 'sin.in'
                },
                pathScale: [.7, null],
                degreeShift: [13, null],
                duration: [500, 700],
                isShowEnd: false,
                isForce3d: true
            }
        });

        const burst = new mojs.Burst({
            left: 0,
            top: 0,
            radius: {
                0: 280
            },
            count: 2,
            angle: 90,
            children: {
                shape: 'rect',
                fill: COLORS.VINOUS,
                radius: 15,
                duration: DURATION,
                isForce3d: true
            }
        });

        const burst2 = new mojs.Burst({
            left: 0,
            top: 0,
            count: 5,
            radius: {
                0: 150
            },
            angle: 90,
            children: {
                shape: 'line',
                stroke: COLORS.VINOUS,
                strokeWidth: 5,
                strokeLinecap: 'round',
                radius: 25,
                // angle:    {  0: 360  },
                scale: 1,
                scaleX: {
                    1: 0
                },
                duration: DURATION,
                isForce3d: true
            }
        });

        const dust1 = makeDust(-1);
        const dust2 = makeDust(1);

        const timeline = new mojs.Timeline();
        timeline
            .add(dust1.timeline, dust2.timeline)
            .add(circle, cloud, burst, burst2)

        document.addEventListener('click', function (e) {
            const x = e.pageX,
                y = e.pageY;

            const coords = {
                x,
                y
            };
            circle.tune(coords);
            cloud.tune(coords);
            burst.tune(coords);
            burst2.tune(coords);
            dust1.parent.tune({
                x: {
                    [x]: x - SHIFT
                },
                y
            });
            dust2.parent.tune({
                x: {
                    [x]: x + SHIFT
                },
                y
            });
            timeline.replay();
        });
    </script>
<?php } ?>
<?php if ($CMSNT->site('mouse_click_effect') == 4) { ?>
    <script src="https://cdn.jsdelivr.net/mojs/latest/mo.min.js"></script>
    <script type="text/javascript">
        const RADIUS = 28;
        const circle = new mojs.Shape({
            left: 0,
            top: 0,
            stroke: '#FF9C00',
            strokeWidth: {
                [2 * RADIUS]: 0
            },
            fill: 'none',
            scale: {
                0: 1,
                easing: 'quad.out'
            },
            radius: RADIUS,
            duration: 450
        });

        const burst = new mojs.Burst({
            left: 0,
            top: 0,
            radius: {
                6: RADIUS - 7
            },
            angle: 45,
            children: {
                shape: 'line',
                radius: RADIUS / 7.3,
                scale: 1,
                stroke: '#FD7932',
                strokeDasharray: '100%',
                strokeDashoffset: {
                    '-100%': '100%'
                },
                degreeShift: 'stagger(0,-5)',
                duration: 700,
                delay: 200,
                easing: 'quad.out',
            }
        });

        class Star extends mojs.CustomShape {
            getShape() {
                return '<path d="M5.51132201,34.7776271 L33.703781,32.8220808 L44.4592855,6.74813038 C45.4370587,4.30369752 47.7185293,3 50,3 C52.2814707,3 54.5629413,4.30369752 55.5407145,6.74813038 L66.296219,32.8220808 L94.488678,34.7776271 C99.7034681,35.1035515 101.984939,41.7850013 97.910884,45.2072073 L75.9109883,63.1330483 L82.5924381,90.3477341 C83.407249,94.4217888 80.4739296,97.6810326 77.0517236,97.6810326 C76.0739505,97.6810326 74.9332151,97.3551083 73.955442,96.7032595 L49.8370378,81.8737002 L26.044558,96.7032595 C25.0667849,97.3551083 23.9260495,97.6810326 22.9482764,97.6810326 C19.3631082,97.6810326 16.2668266,94.4217888 17.4075619,90.3477341 L23.9260495,63.2960105 L2.08911601,45.2072073 C-1.98493875,41.7850013 0.296531918,35.1035515 5.51132201,34.7776271 Z" />';
            }
        }
        mojs.addShape('star', Star);

        const star = new mojs.Shape({
            left: 0,
            top: 0,
            shape: 'star',
            fill: '#FF9C00',
            scale: {
                0: 1
            },
            easing: 'elastic.out',
            duration: 1600,
            delay: 300,
            radius: RADIUS / 2.25
        });

        const timeline = new mojs.Timeline({
            speed: 1.5
        });

        timeline
            .add(burst, circle, star);

        document.addEventListener('click', function (e) {
            const coords = {
                x: e.pageX,
                y: e.pageY
            };
            burst.tune(coords);
            circle.tune(coords);
            star.tune(coords);
            timeline.replay();
        });
    </script>
<?php } ?>
<?php if ($CMSNT->site('mouse_click_effect') == 5) { ?>
    <script src="https://cdn.jsdelivr.net/mojs/latest/mo.min.js"></script>
    <script type="text/javascript">
        class Star extends mojs.CustomShape {
            getShape() {
                return '<path d="M5.51132201,34.7776271 L33.703781,32.8220808 L44.4592855,6.74813038 C45.4370587,4.30369752 47.7185293,3 50,3 C52.2814707,3 54.5629413,4.30369752 55.5407145,6.74813038 L66.296219,32.8220808 L94.488678,34.7776271 C99.7034681,35.1035515 101.984939,41.7850013 97.910884,45.2072073 L75.9109883,63.1330483 L82.5924381,90.3477341 C83.407249,94.4217888 80.4739296,97.6810326 77.0517236,97.6810326 C76.0739505,97.6810326 74.9332151,97.3551083 73.955442,96.7032595 L49.8370378,81.8737002 L26.044558,96.7032595 C25.0667849,97.3551083 23.9260495,97.6810326 22.9482764,97.6810326 C19.3631082,97.6810326 16.2668266,94.4217888 17.4075619,90.3477341 L23.9260495,63.2960105 L2.08911601,45.2072073 C-1.98493875,41.7850013 0.296531918,35.1035515 5.51132201,34.7776271 Z" />';
            }
        }
        mojs.addShape('star', Star);

        const RADIUS = 28;
        const circle = new mojs.Shape({
            left: 0,
            top: 0,
            stroke: '#FF9C00',
            strokeWidth: {
                [2 * RADIUS]: 0
            },
            fill: 'none',
            scale: {
                0: 1,
                easing: 'quad.out'
            },
            radius: RADIUS,
            duration: 450,
        });

        const burst = new mojs.Burst({
            left: 0,
            top: 0,
            radius: {
                6: RADIUS - 3
            },
            angle: 45,
            children: {
                shape: 'star',
                radius: RADIUS / 2.2,
                fill: '#FD7932',
                degreeShift: 'stagger(0,-5)',
                duration: 700,
                delay: 200,
                easing: 'quad.out',
                // delay:        100,
            }
        });

        const star = new mojs.Shape({
            left: 0,
            top: 0,
            shape: 'star',
            fill: '#FF9C00',
            scale: {
                0: 1
            },
            easing: 'elastic.out',
            duration: 1600,
            delay: 300,
            radius: RADIUS / 2.35
        });

        const timeline = new mojs.Timeline({
            speed: 1.5
        });

        timeline
            .add(burst, circle, star);

        document.addEventListener('click', function (e) {
            const coords = {
                x: e.pageX,
                y: e.pageY
            };
            burst.tune(coords);
            circle.tune(coords);
            star.tune(coords);
            timeline.replay();
        });
    </script>
<?php } ?>
<?php if ($CMSNT->site('mouse_click_effect') == 6) { ?>
    <script src="https://cdn.jsdelivr.net/mojs/latest/mo.min.js"></script>
    <script type="text/javascript">
        class Heart extends mojs.CustomShape {
            getShape() {
                return '<path d="M73.6170213,0 C64.4680851,0 56.5957447,5.53191489 51.7021277,13.8297872 C50.8510638,15.3191489 48.9361702,15.3191489 48.0851064,13.8297872 C43.4042553,5.53191489 35.3191489,0 26.1702128,0 C11.9148936,0 0,14.0425532 0,31.2765957 C0,48.0851064 14.893617,77.8723404 47.6595745,99.3617021 C49.1489362,100.212766 50.8510638,100.212766 52.1276596,99.3617021 C83.8297872,78.5106383 99.787234,48.2978723 99.787234,31.2765957 C100,14.0425532 88.0851064,0 73.6170213,0 L73.6170213,0 Z"></path>';
            }
        }
        mojs.addShape('heart', Heart);

        const CIRCLE_RADIUS = 20;
        const RADIUS = 32;
        const circle = new mojs.Shape({
            left: 0,
            top: 0,
            stroke: '#FF9C00',
            strokeWidth: {
                [2 * CIRCLE_RADIUS]: 0
            },
            fill: 'none',
            scale: {
                0: 1
            },
            radius: CIRCLE_RADIUS,
            duration: 400,
            easing: 'cubic.out'
        });

        const burst = new mojs.Burst({
            left: 0,
            top: 0,
            radius: {
                4: RADIUS
            },
            angle: 45,
            count: 14,
            timeline: {
                delay: 300
            },
            children: {
                radius: 2.5,
                fill: '#FD7932',
                scale: {
                    1: 0,
                    easing: 'quad.in'
                },
                pathScale: [.8, null],
                degreeShift: [13, null],
                duration: [500, 700],
                easing: 'quint.out'
            }
        });

        const heart = new mojs.Shape({
            left: 0,
            top: 2,
            shape: 'heart',
            fill: '#E5214A',
            scale: {
                0: 1
            },
            easing: 'elastic.out',
            duration: 1600,
            delay: 300,
            radius: 11
        });

        document.addEventListener('click', function (e) {
            const coords = {
                x: e.pageX,
                y: e.pageY
            };
            burst
                .tune(coords)
                .replay();

            circle
                .tune(coords)
                .replay();

            heart
                .tune(coords)
                .replay();

        });
    </script>
<?php } ?>

<?php if ($CMSNT->site('status_spin') == 1) { ?>
    <div id="showSpin"
        style="display: block; position: fixed; bottom: 40px; right: 25px; z-index: 1000; cursor: pointer; width: 8%;">
        <div onclick="$('#showSpin').hide()" class="" style="
    left: 100%;
    position: absolute;
">
            <p style="font-size:20px;color:red;"><i class="fas fa-window-close"></i></p>
        </div>
        <a href="<?= base_url('client/spin'); ?>">
            <center><img class="animate__animated animate__heartBeat animate__infinite infinite"
                    src="https://i.imgur.com/ZlYSYHD.gif" width="100%" style="">
            </center>
            <center class="solid" style="border-top-right-radius: 30px;
    border-top-left-radius: 30px;
    border-radius: 30px;
    background: aquamarine;">
            </center>
        </a>
    </div>
<?php } ?>
<!-- Backend Bundle JavaScript -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/backend-bundle.min.js"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/customizer.js"></script>
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/sidebar.js"></script>
<!-- Flextree Javascript-->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/flex-tree.min.js"></script>
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/tree.js"></script>
<!-- Table Treeview JavaScript -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/table-treeview.js"></script>
<!-- SweetAlert JavaScript -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/sweetalert.js"></script>
<!-- Vectoe Map JavaScript -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/vector-map-custom.js"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/chart-custom.js"></script>
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/charts/01.js"></script>
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/charts/02.js"></script>
<!-- slider JavaScript -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/slider.js"></script>
<!-- Emoji picker -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/vendor/emoji-picker-element/index.js" type="module"></script>
<!-- app JavaScript -->
<script src="<?= BASE_URL('public/datum'); ?>/assets/js/app.js"></script>
<?= $body['footer']; ?>
<!-- Dev By CMSNT.CO | FB.COM/CMSNT.CO | ZALO.ME/0947838128 | MMO Solution -->
<!-- Script Footer -->
<?= $CMSNT->site('javascript'); ?>
</body>

</html>