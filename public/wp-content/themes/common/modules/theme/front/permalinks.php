<?php

add_filter('request', function($query_vars) {
    if (is_admin()) {
        return $query_vars;
    }

    $p_url = parse_url($_SERVER['REQUEST_URI']);
    $p_url['query'] = isset($p_url['query']) ? $p_url['query'] : '';
    parse_str($p_url['query'], $q_url);

    if (isset($_GET['f_master_type']) && empty($_GET['f_master_type'])) {
        unset($q_url['f_master_type']);
    }

    $new_url = $p_url['path'] . (empty($q_url) ? '' : '?' . http_build_query($q_url));
    if ($new_url != $_SERVER['REQUEST_URI']) {
        wp_redirect($new_url);
        exit;
    }

    return $query_vars;
});

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
