jQuery(function ($) {
    $("#banner_sidebar").stick_in_parent({offset_top: 15});

    var breakpoint = detect_breakpoint();

    $(window).resize(function() {
        if (breakpoint != detect_breakpoint()) {
            breakpoint = detect_breakpoint();

            googletag && googletag.pubads().refresh();
        }
    });

    function detect_breakpoint() {
        var w = jQuery(window).width();
        if (w >= 1200) {
            return 1200;
        } else if (w >= 992) {
            return 992;
        } else if (w >= 768) {
            return 768;
        } else if (w >= 576) {
            return 576;
        } else if (w >= 420) {
            return 420;
        } else {
            return w;
        }
    }
});
