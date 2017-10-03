jQuery(function ($) {
    $('.pror-collapse').click(function(e) {
        e.preventDefault();

        var el = $(this);
        var parent = $(el.data('pror-parent'));
        var target = $(el.data('pror-target'), parent);

        var isHidden = target.hasClass('d-none');

        $(parent.data('pror-children'), parent).addClass('d-none');
        if (isHidden) {
            target.removeClass('d-none');
        }
    });
});
