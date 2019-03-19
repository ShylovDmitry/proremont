jQuery(function ($) {

    function pror_track_master_action(type) {
        $.post(ProRemontObj.ajaxurl, {action: 'pror_master_action', type: type, post_id: ProRemontObj.postid}, function (response) {
            // console.log(response);
        });
    }

    pror_track_master_action('page_view');

    $('.master-detailed .gallery-carousel').slick({
        infinite: true,
        speed: 300,
        centerMode: true,
        variableWidth: true
    });
    $('.master-detailed .gallery-carousel').slickLightbox();


    $('#commentform').submit(function(e) {
        $('#comment-error').html('');
        if ($('#comment').val() == '') {
            e.preventDefault();
            $('#comment-error').html('Отзыв не может быть пустым.');
        }
    });
    $('#comment').on('keypress', function(e) {
        $('#comment-error').html('');
    });

    $('.show-number').click(function(e) {
        e.preventDefault();

        pror_track_master_action('show_phone');

        if (typeof ga != 'undefined') {
            ga('send', 'event', 'Master Page', 'phone click');
        }

        var parent = $(this).parents('.master-phones-container');
        if ($('.registration-required-message', parent).length) {
            $('.registration-required-message', parent).removeClass('d-none');
        } else {
            $('.stub', parent).addClass('d-none');
            $('.phones', parent).removeClass('d-none');

            if (typeof ga != 'undefined') {
                ga('send', 'event', 'Master Page', 'phone shown');
            }
        }
    });
});
