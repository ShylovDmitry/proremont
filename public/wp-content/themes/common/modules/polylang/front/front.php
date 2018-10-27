<?php

function pror_fix_lang_link($url, $lang) {
    $host = parse_url($url, PHP_URL_HOST);
    $deflang = pll_default_language();
    $curlang = pll_current_language();

    $url = str_replace("{$host}/{$deflang}/", "{$host}/", $url);
    $url = str_replace("{$host}/{$curlang}/", "{$host}/", $url);

    if ($deflang != $lang) {
        $url = str_replace("{$host}/", "{$host}/{$lang}/", $url);
    }

    return $url;
}

add_filter('post_type_link', function($permalink, $post, $leavename) {
    if (is_admin()) {
        return $permalink;
    }

    $post_types = ['master', 'partner'];

    if (in_array(get_post_type($post->ID), $post_types)) {
        return pror_fix_lang_link($permalink, pll_current_language());
    }
    return $permalink;
}, 10, 3);

add_filter('post_link', function($permalink, $post, $leavename) {
    if (is_admin()) {
        return $permalink;
    }

    $post_types = ['post'];

    if (in_array(get_post_type($post->ID), $post_types)) {
        return pror_fix_lang_link($permalink, pll_current_language());
    }
    return $permalink;
}, 10, 3);

add_filter('pll_pre_translation_url', function($url, $language, $queried_object_id) {
    $post_types = ['master', 'partner', 'post'];

    if (in_array(get_post_type($queried_object_id), $post_types)) {
        return pror_fix_lang_link(get_permalink($queried_object_id), $language->slug);
    }
    return $url;
}, 10, 3);

add_filter('pll_hide_archive_translation_url', function($hide, $lang, $args) {
    return false;
}, 10, 3);

add_filter('pll_rewrite_rules', function($types) {
    $types[] = 'post';
    $types[] = 'master';
    $types[] = 'partner';
    $types[] = 'catalog_master';
    $types[] = 'category';

    return $types;
});

add_filter('pll_check_canonical_url', function($redirect_url, $language) {
    global $wp_query;

    if ($wp_query->is_posts_page) {
        return false;
    }
    return $redirect_url;
}, 10, 2);


global $pror_pll_fix_post_types;
$pror_pll_fix_post_types = true;

add_filter('parse_query', function($query) {
    global $pror_pll_fix_post_types;

    $pror_pll_fix_post_types = false;
    PLL()->model->cache->clean();
}, -1);

add_filter('parse_query', function($query) {
    global $pror_pll_fix_post_types;

    $pror_pll_fix_post_types = true;
    PLL()->model->cache->clean();
}, 1);

add_filter('pll_get_post_types', function($post_types, $is_settings) {
    global $pror_pll_fix_post_types;

    if ($pror_pll_fix_post_types) {
        unset($post_types['post']);
    }
    return $post_types;
}, 10, 2);

add_filter('pll_get_taxonomies', function($taxonomies, $is_settings) {
    unset($taxonomies['category']);
    return $taxonomies;
}, 10, 2 );


add_action('pre_get_posts', function($query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_posts_page) {
        return;
    }

    $query->set('lang', '');

    return $query;
}, 100);

add_action('pll_set_language_from_query', function($lang, $query) {
    if ($query->is_admin() || !$query->is_main_query() || !$query->is_posts_page) {
        return $lang;
    }

    return false;
}, 10, 2);
