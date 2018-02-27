<?php

add_action('init', function() {
    add_rewrite_rule('cover/([^/]+)/([0-9]+)/?$', 'index.php?__cover_type=$matches[1]&__cover_id=$matches[2]', 'top');
});

add_filter('query_vars', function($query_vars) {
    $query_vars[] = '__cover_type';
    $query_vars[] = '__cover_id';
    return $query_vars;
});

add_action('template_redirect', function () {
    $type = get_query_var('__cover_type');
    if ($type) {
        $id = get_query_var('__cover_id');

        pror_cover_generate_image($type, $id);
        exit;
    }
});
