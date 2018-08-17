<?php

add_filter('oa_social_login_filter_new_user_role', function($user_role) {
    $oa_social_login_source = (!empty ($_REQUEST ['oa_social_login_source']) ? strtolower (trim ($_REQUEST ['oa_social_login_source'])) : '');
    if ($oa_social_login_source == 'comments') {
        return 'subscriber';
    } else if ($oa_social_login_source) {
        return 'master';
    }
    return $user_role;
});

add_filter('logout_url', function($logouturl, $redir) {
    return $logouturl . '&amp;redirect_to=' . get_permalink();
}, 10, 2);

function pror_set_section_cookie($section_slug) {
    if ($section_slug != pror_get_section_cookie()) {
        setcookie('pror_section', $section_slug, strtotime('+1 year'), '/', $_SERVER['HTTP_HOST'], false, true);
    }
}

function pror_remove_section_cookie() {
    setcookie('pror_section', '', strtotime( '-1 year' ), '/', $_SERVER['HTTP_HOST'], false, true);
}

function pror_get_section_cookie() {
    return isset($_COOKIE, $_COOKIE['pror_section']) ? $_COOKIE['pror_section'] : null;
}
