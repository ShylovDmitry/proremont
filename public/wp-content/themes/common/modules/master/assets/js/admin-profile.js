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
        if (ProRemontMasterObj.is_pro) {
            return;
        }

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


    var jqxhr;
    function check_sanitize_title(title, cb) {
        if (jqxhr) {
            jqxhr.abort();
        }
        jqxhr = $.post(ProRemontMasterObj.ajaxurl, {action: 'pror_master_sanitize_title', title: title, user_id: ProRemontMasterObj.user_id}, cb);
    }

    $('[data-name="master_title"] .acf-input input').blur(function() {
        check_sanitize_title($(this).val(), function(response) {
            var input = $('[data-name="master_url_slug"] .acf-input input');
            if (input.val() == '') {
                input.val(response.data.title);
                check_url_slug();
            }
        });
    });

    $('[data-name="master_url_slug"] .acf-input').append('<div class="master_url_slug_helptext mt-1"></div>');

    var url_slug_input = $('[data-name="master_url_slug"] .acf-input input');
    var url_slug_helptext = $('[data-name="master_url_slug"] .master_url_slug_helptext');

    function check_url_slug() {
        url_slug_helptext.removeClass('text-success').removeClass('text-danger').text('Загружается...');

        check_sanitize_title(url_slug_input.val(), function(response) {
            switch (response.data.error) {
                case 'empty':
                    url_slug_input.removeClass('text-success').addClass('text-danger');
                    url_slug_helptext.removeClass('text-success').addClass('text-danger').text('URL не может быть пустым.');
                    break;
                case 'chars':
                    url_slug_input.removeClass('text-success').addClass('text-danger');
                    url_slug_helptext.removeClass('text-success').addClass('text-danger').text('Используються запрещенные символы');
                    break;
                case 'exists':
                    url_slug_input.removeClass('text-success').addClass('text-danger');
                    url_slug_helptext.removeClass('text-success').addClass('text-danger').text('Такой URL уже используется.');
                    break;
                default:
                    url_slug_input.removeClass('text-danger').addClass('text-success');
                    url_slug_helptext.removeClass('text-danger').addClass('text-success').text('Хорошо!');
                    break;
            }
        });
    }

    url_slug_input.keyup(check_url_slug);
    url_slug_input.blur(check_url_slug);
});
