$(function () {
    $('[data-toggle="tooltip"]').tooltip({html:true});

    $('.master-gallery').slick({
        dots: true,
        infinite: true,
        speed: 300,
        centerMode: true,
        variableWidth: true
    });
    $('.master-gallery').slickLightbox();


    $('#master_search_section').select2();
    $('#master_search_section').on('change', function () {
        $('#master_search_form').submit();
    });
    $('#master_search_form .form-check-input').on('change', function () {
        $('#master_search_form').submit();
    });
});
