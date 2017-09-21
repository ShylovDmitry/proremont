<?php

add_filter('wpseo_breadcrumb_links', function($crumbs) {
    $last = end($crumbs);
    $section = pror_get_section();

    $catalog_master_page = pror_get_page_by_template_name('template-catalog_master.php');
    $breadcrumb_catalog_master = array(
        'text' => sprintf('%s - %s', get_the_title($catalog_master_page), $section->name),
        'url' => get_permalink($catalog_master_page),
        'allow_html' => true,
    );

    if (isset($last, $last['id']) && $last['id']) {
        $post_type = get_post_type($last['id']);

        if ($post_type == 'master') {
            array_splice($crumbs, 1, 0, array($breadcrumb_catalog_master));
        } else {
        }
    }

    if (isset($last, $last['term'], $last['term']->taxonomy) && $last['term']->taxonomy == 'catalog_master') {
        array_splice($crumbs, 1, 0, array($breadcrumb_catalog_master));
    }

    if ($section && $section->slug) {
        $crumbs[0]['url'] .= "{$section->slug}/";
    }

    return $crumbs;
});
