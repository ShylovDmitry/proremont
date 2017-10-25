jQuery(function ($) {
    $('#your-profile').submit(function() {
        var title = $('[data-name="master_title"] .acf-input input').val();

        $('#display_name option:selected').text(title);
        $('#nickname').val(title);
    });
});
