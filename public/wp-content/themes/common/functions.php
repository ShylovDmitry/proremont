<?php

require_once(__DIR__ . '/module_functions.php');


define('DLV_THEME_MODULES_DIR', __DIR__ . '/modules');

dlv_include_php_files_from_dir(__DIR__ . '/plugins', true);

if (is_admin()) {
    foreach (glob(DLV_THEME_MODULES_DIR . '/*/admin', GLOB_ONLYDIR) as $folder) {
        dlv_include_php_files_from_dir($folder);
    }
}

foreach (glob(DLV_THEME_MODULES_DIR . '/*/front', GLOB_ONLYDIR) as $folder) {
    dlv_include_php_files_from_dir($folder);
}

foreach (glob(DLV_THEME_MODULES_DIR . '/*/widgets', GLOB_ONLYDIR) as $folder) {
    dlv_register_widgets_from_dir($folder);
}


function dlv_get_ver() {
    $rev_file = APP_PATH . 'rev.txt';
    return file_exists($rev_file) ? trim(file_get_contents($rev_file)) : time();
}


add_filter('post_type_link', function($permalink, $post, $leavename) {
    $post_types = ['master', 'partner'];

    if (in_array(get_post_type($post->ID), $post_types) && pll_default_language() != pll_current_language()) {
        $host = parse_url($permalink, PHP_URL_HOST);
        $permalink = str_replace("{$host}/", "{$host}/" . pll_current_language() . "/", $permalink);
    }
    return $permalink;
}, 10, 3);

add_filter('pll_rewrite_rules', function($types) {
    $types[] = 'master';
    $types[] = 'partner';

    return $types;
});

add_filter('pll_pre_translation_url', function($url, $language, $queried_object_id) {
    $post_types = ['master', 'partner'];

    if (in_array(get_post_type($queried_object_id), $post_types) && pll_default_language() != $language->slug) {
        $url = get_permalink($queried_object_id);
        $host = parse_url($url, PHP_URL_HOST);
        $url = str_replace("{$host}/", "{$host}/{$language->slug}/", $url);
    }
    return $url;
}, 10, 3);
