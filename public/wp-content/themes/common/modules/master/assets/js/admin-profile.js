jQuery(function ($) {

    $('.categorychecklist-holder > ul > li > label :checkbox').remove();

    $('#your-profile').submit(function(e) {
        var should_be_master = $('[data-name="master_should_be"] .acf-input input:checked').val();

        if (should_be_master) {
            var title = $('[data-name="master_title"] .acf-input input').val();

            $('#display_name option:selected').text(title);
            $('#nickname').val(title);
        }
    });

    var catalog_master = $('*[data-taxonomy="catalog_master"]');
    $(':checkbox', catalog_master).click(function() {
        manageCatalogCheckboxes(true);
    });
    manageCatalogCheckboxes();

    function manageCatalogCheckboxes(show_dialog) {
        show_dialog = show_dialog || false;

        if ($(':checkbox:checked', catalog_master).length < 5) {
            $(':checkbox', catalog_master).attr('disabled', false);
        } else {
            $(':checkbox:not(:checked)', catalog_master).attr('disabled', true);
            if (show_dialog) {
                $('#modalCatalogLimitreached').modal('show');
            }
        }
    }

    $('#adminmenu li.self-page-link a').attr('target', '_blank');
    $('#adminmenu li.pro-account-link a').attr('target', '_blank');

    var referral_tel = $('[data-name="master_referral_tel"] input');
    if (referral_tel.val()) {
        referral_tel.attr('disabled', true);
    }
});
