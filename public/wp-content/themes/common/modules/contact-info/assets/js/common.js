jQuery(function ($) {

    $('.show-contact-info').click(function(e) {
        e.preventDefault();

        pror_track_action('pror_master_action','show_phone');

        if (typeof ga != 'undefined') {
            ga('send', 'event', 'Master Page', 'phone click');
        }

        var parent = $(this).parents('.contact-info');
        $('.stub', parent).addClass('d-none');
        $('.contact-info-list', parent).removeClass('d-none');

        if (typeof ga != 'undefined') {
            ga('send', 'event', 'Master Page', 'phone shown');
        }
    });
});
