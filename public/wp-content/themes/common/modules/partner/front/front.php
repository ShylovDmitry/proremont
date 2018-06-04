<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('partner-common', get_module_css('partner/common.css'), array(), dlv_get_ver());
});

//add_action('wp_enqueue_scripts', function () {
//    wp_enqueue_script('partner-common', get_module_js('partner/common.js'), array('jquery'), dlv_get_ver(), true);
//});

add_filter('wpseo_breadcrumb_links', function($crumbs) {
    if (get_post_type() == 'partner') {
        $page = get_page_by_path('partners');

        array_splice($crumbs, 1, 0, array(
            array(
                'text' => get_the_title($page),
                'url' => get_permalink($page),
                'allow_html' => true,
            )
        ));
    }

    return $crumbs;
});
