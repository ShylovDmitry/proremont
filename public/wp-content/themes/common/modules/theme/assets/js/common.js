jQuery(function ($) {
    $('[data-toggle="tooltip"]').tooltip({html:true});

    $('.gallery-2columns-carousel').slickLightbox();

    $("#side_banner").stick_in_parent({offset_top: 15});

    init();


    function init() {
        var section = pror_get_section_slug();
        if (section) {
            pror_update_links(section);
            pror_update_section_list(section);
        } else {
            pror_detect_location(function(section) {
                pror_update_links(section);
                pror_update_section_list(section);
            });
        }

        $('.navbar .section-list .dropdown-menu a').click(function() {
            setCookie('pror_section', $(this).data('slug'), 365);
        });
    }

    function pror_detect_location(callback) {
        $.get(ProRemont.ajax_url, {action: 'detect_location'}, function(response) {
            if (response.success) {
                callback && callback(response.data);
            }
        });
    }

    function pror_get_section_slug() {
        var container = $('.navbar .section-list');

        var match = /\/([^\/]+)\//g.exec(document.location.pathname);
        if (match && $('.dropdown-item[data-slug=' + match[1] + ']', container).length) {
            return match[1];
        }

        var cookie = getCookie('pror_section');
        if (cookie && $('.dropdown-item[data-slug=' + cookie + ']', container).length) {
            return cookie;
        }

        return false;
    }

    function pror_update_links(section) {
        var container = $('.navbar .section-list');
        var old_section = $('.dropdown-toggle', container).data('slug');

        $('.navbar a, .footer a').each(function() {
            var href = $(this).attr('href');
            href = href.replace('/' + old_section + '/', '/' + section + '/');
            $(this).attr('href', href);
        });
    }

    function pror_update_section_list(section) {
        var container = $('.navbar .section-list');
        var el = $('.dropdown-item[data-slug=' + section + ']', container);
        $('.dropdown-toggle', container).html(el.html());
        $('.dropdown-toggle', container).data('slug', section);
        container.removeClass('invisible');

        setCookie('pror_section', section, 365);
    }
});


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
