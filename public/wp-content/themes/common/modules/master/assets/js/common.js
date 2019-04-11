jQuery(function ($) {

    pror_track_action('pror_master_action','page_view');

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
});
