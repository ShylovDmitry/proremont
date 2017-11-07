jQuery(function ($) {
    $('.gallery-carousel').slick({
        infinite: true,
        speed: 300,
        centerMode: true,
        variableWidth: true
    });
    $('.gallery-carousel').slickLightbox();


    $('#master_search_catalog').select2();
    $('#master_search_catalog').on('change', function () {
        $('#master_search_form').submit();
    });
    $('#master_search_catalog .form-check-input').on('change', function () {
        $('#master_search_form').submit();
    });

    $('#master_search_section').select2();
    $('#master_search_section').on('change', function () {
        $('#master_search_form').submit();
    });
    $('#master_search_form .form-check-input').on('change', function () {
        $('#master_search_form').submit();
    });

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

        if (typeof ga != 'undefined') {
            ga('send', 'event', 'Master Page', 'phone click');
        }

        var parent = $(this).parents('.master-phones');
        $('.stub', parent).addClass('d-none');
        $('.phones', parent).removeClass('d-none');
    });
});
