jQuery(function ($) {
    $("#banner_sidebar").stick_in_parent({offset_top: 15});

    $(window).resize(function() {
        googletag && googletag.pubads().refresh();
    });
});
