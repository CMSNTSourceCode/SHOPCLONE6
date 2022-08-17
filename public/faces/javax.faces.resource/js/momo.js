/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var spinner;
var opts = {
    lines: 11 // The number of lines to draw
    , length: 5 // The length of each line
    , width: 4 // The line thickness
    , radius: 9 // The radius of the inner circle
    , scale: 1 // Scales overall size of the spinner
    , corners: 1 // Corner roundness (0..1)
    , color: '#fff' // #rgb or #rrggbb or array of colors
    , opacity: 1 / 4 // Opacity of the lines
    , rotate: 0 // The rotation offset
    , direction: 1 // 1: clockwise, -1: counterclockwise
    , speed: 1.1 // Rounds per second
    , trail: 100 // Afterglow percentage
    , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
    , zIndex: 2e9 // The z-index (defaults to 2000000000)
    , className: 'spinner' // The CSS class to assign to the spinner
    , top: '50%' // Top position relative to parent
    , left: '50%' // Left position relative to parent
    , shadow: false // Whether to render a shadow
    , hwaccel: true // Whether to use hardware acceleration
    , position: 'absolute' // Element positioning
}
var MoMoPay = {
    init: function () {
        if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
            $('html, body').animate({
                scrollTop: $('#payment-content').offset().top
            }, 1000);
        }
        var x = document.getElementById('momoPassword');
        var style = window.getComputedStyle(x);
        if (style.webkitTextSecurity) {
            //do nothing
        } else {
            x.setAttribute("type", "password");
        }
    },
    showSpin2: function () {
        spinner = new Spinner(opts).spin($('#loading_wrapper').get(0));
        $('#loading_wrapper').show();
        $('#overlay').show()
    },
    stopSpin2: function () {
        spinner.stop();
        $('#loading_wrapper').hide();
        $('#overlay').hide()
    },
    limit: function (element, max) {
        var max_chars = max;
        if (element.value.length > max_chars) {
            element.value = element.value.substr(0, max_chars);
        }
    },
    showSpin: function () {
        $('body').append(
            '<div id="loader-container" style="z-index: 9999"></div>' +
            '<div class="lds-css ng-scope loader" style="z-index: 1000000">' +
            '  <div style="width:100%;height:100%" class="lds-dual-ring">\n' +
            '    <div></div>\n' +
            ' </div>' +
            '</div>'
        );
        $('#loader-container').css('height', $(window).height());
    },
    stopSpin: function () {
        $('#loader-container').remove();
        $('.lds-css').remove();
    }
}



