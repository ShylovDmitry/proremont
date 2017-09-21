<?php

add_filter('request', function($query_vars) {
    if (isset($_GET['change_section'])) {
        $p = parse_url($_SERVER['REQUEST_URI']);
        parse_str($p['query'], $q);
        unset($q['change_section']);

        $url = sprintf('%s%s',
            str_replace('/' . $query_vars['section'] . '/', '/' . pror_get_section_by_slug($_GET['change_section'])->slug . '/', $p['path']),
            empty($q) ? '' : '?' . http_build_query($q)
        );
        wp_redirect($url);
        exit;
    }

    if ('/' === parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        || strpos($_SERVER['REQUEST_URI'], '/page/') === 0)
    {
        $url = sprintf('/%s%s',
            pror_get_section()->slug,
            $_SERVER['REQUEST_URI']
        );
        wp_redirect($url);
        exit;
    }

    if (isset($query_vars['section']) && get_page_by_path($query_vars['section'])) {
        $query_vars['pagename'] = $query_vars['section'];
        unset($query_vars['section']);
    }

    return $query_vars;
});

add_action('init', function() {
    add_rewrite_rule('([^/]+)/(.?.+?)(?:/([0-9]+))?/?$','index.php?section=$matches[1]&pagename=$matches[2]&page=$matches[3]','top');
});

add_filter('term_link', function($termlink, $term, $taxonomy) {
    return str_replace('%section%', pror_get_section()->slug, $termlink);
}, 10, 3);

add_filter('post_type_link', function($post_link, $post, $leavename, $sample) {
    if (get_post_type($post) == 'master') {
        $locations = get_the_terms($post, 'location');
        if (isset($locations, $locations[0]) && $locations[0]->term_id) {
            $post_link = str_replace('%section%', pror_get_section_by_location_id($locations[0]->term_id)->slug, $post_link);
        }
    }

    return $post_link;
}, 10, 4);

add_filter('page_link', function($link, $post_ID, $sample) {
    $catalog_master_page = pror_get_page_by_template_name('template-catalog_master.php');
    if ($catalog_master_page->ID == $post_ID) {
        $section_slug = pror_get_section()->slug;
        $link = str_replace("/{$catalog_master_page->post_name}/", "/{$section_slug}/{$catalog_master_page->post_name}/", $link);
    }

    return $link;
}, 10, 3);

add_filter('wp_seo_get_bc_title', function($link_text, $id) {
    $catalog_master_page = pror_get_page_by_template_name('template-catalog_master.php');
    if ($catalog_master_page->ID == $id) {
        return sprintf('%s - %s', $link_text, pror_get_section()->name);
    }

    return $link_text;
}, 10, 2);
