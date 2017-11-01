jQuery(function ($) {
    $('#your-profile').submit(function() {
        var should_be_master = $('[data-name="master_should_be"] .acf-input input:checked').val();

        if (should_be_master == 'yes') {
            var title = $('[data-name="master_title"] .acf-input input').val();

            $('#display_name option:selected').text(title);
            $('#nickname').val(title);
        }
    });
});
