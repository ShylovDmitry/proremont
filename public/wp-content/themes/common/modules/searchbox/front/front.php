<?php


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('searchbox-common', get_module_js('searchbox/common.js'), array('jquery'), null, true);


    $cache_expire = pror_cache_expire(0);
    $cache_key = pror_cache_key('catalogs', 'lang');
    $cache_group = 'pror:searchbox:data';

    $catalogs = wp_cache_get($cache_key, $cache_group);
    if (!$catalogs) {
        $catalogs = [];
        $terms = get_terms(array(
            'taxonomy' => 'catalog_master',
            'hierarchical' => false,
            'hide_empty' => false,
        ));
        foreach ($terms as $term) {
            $catalogs[$term->name] = get_term_link($term);
        }

        wp_cache_add($cache_key, $catalogs, $cache_group, $cache_expire);
    }


    $cache_expire = pror_cache_expire(0);
    $cache_key = pror_cache_key('sections', 'lang');
    $cache_group = 'pror:searchbox:data';

    $sections = wp_cache_get($cache_key, $cache_group);
    if (!$sections) {
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object($locations['header_dropdown']);
        $menuitems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC'));

        $sections = [];
        foreach ($menuitems as $menuitem) {
            $menu_post = get_term($menuitem->object_id);
            $sections[pror_get_section_name($menu_post)] = $menu_post->slug;
        }

        wp_cache_add($cache_key, $sections, $cache_group, $cache_expire);
    }

    wp_localize_script('searchbox-common', 'ProRemontSearchbox', array(
        'catalogs' => $catalogs,
        'sections' => $sections
    ));
});

add_action('wp_print_styles', function () {
    wp_enqueue_style('searchbox-common', get_module_css('searchbox/common.css'), array(), null);
});
