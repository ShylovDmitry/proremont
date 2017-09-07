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
});
