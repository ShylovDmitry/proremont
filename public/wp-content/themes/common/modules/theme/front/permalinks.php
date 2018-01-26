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

add_filter('post_type_link', function($post_link, $post, $leavename, $sample) {
    if (get_post_type($post) == 'master') {
        $locations = get_the_terms($post, 'location');
        if (isset($locations, $locations[0]) && $locations[0]->term_id) {
            $post_link = str_replace('%location%', $locations[0]->slug, $post_link);
        }
    }

    return $post_link;
}, 10, 4);

add_action('wp', function() {
    if (!is_admin() && is_singular('master') && get_post_type() == 'master') {
        global $wp;
        $locations = get_the_terms(null, 'location');
        $parts = explode('/', $wp->request);

        if (isset($locations, $locations[0]) && $locations[0]->term_id && $parts[0] != $locations[0]->slug) {
            $url = str_replace($parts[0] . '/', $locations[0]->slug . '/', $wp->request);
            wp_redirect(home_url($url));
            exit;
        }
    }
});
