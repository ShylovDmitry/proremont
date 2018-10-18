<?php

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
