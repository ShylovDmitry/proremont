jQuery(function ($) {
    $('[data-toggle="tooltip"]').tooltip({html:true});

    $('.gallery-2columns-carousel').slickLightbox();


    $('.navbar .section-list .dropdown-menu a').click(function(e) {
        e.preventDefault();
        setCookie('pror_section', $(this).data('slug'), 365);
        window.location.reload(true);
    });
});

function pror_track_action(action, type) {
    $.post(ProRemontObj.ajaxurl, {action: action, type: type, post_id: ProRemontObj.postid}, function (response) {
        // console.log(response);
    });
}



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




function adBlockNotDetected() {
}

function adBlockDetected() {
	$('.prom-placeholder').hide();
	$('.prom-placeholder-blocked').show();
}

if(typeof blockAdBlock === 'undefined') {
	adBlockDetected();
} else {
	blockAdBlock.on(true, adBlockDetected).onNotDetected(adBlockNotDetected);
}
