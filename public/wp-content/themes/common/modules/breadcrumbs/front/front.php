<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('breadcrumbs-common', get_module_css('breadcrumbs/common.css'), array(), dlv_get_ver());
});

add_filter('wpseo_breadcrumb_links', function($crumbs) {
    $section = pror_get_section();
    if ($section && $section->slug) {
        $crumbs[0]['url'] .= "{$section->slug}/";
    }

    return $crumbs;
});


//add_filter('wp_seo_get_bc_title', function($text, $id) {
//    if (get_post_type($id) == 'master') {
//        $text = sprintf('%s (%s)', $text, mb_strtolower(get_field('master_type')));
//    }
//
//    return $text;
//}, 10, 2);
