<?php


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('searchbox-common', get_module_js('searchbox/common.js'), array('jquery'), null, true);


	$cache_obj = pror_cache_obj(0, 'lang', 'pror:searchbox:data', 'catalogs');
	$catalogs = pror_cache_get($cache_obj);
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

	    pror_cache_set($cache_obj, ob_get_flush());
    }


	$cache_obj = pror_cache_obj(0, 'lang', 'pror:searchbox:data', 'sections');
	$sections = pror_cache_get($cache_obj);
	if (!$sections) {
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object($locations['header_dropdown']);
        $menuitems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC'));

        $sections = [];
        foreach ($menuitems as $menuitem) {
            $menu_post = get_term($menuitem->object_id);
            $sections[pror_get_section_localized_name($menu_post)] = pror_get_section_localized_slug($menu_post);
        }

		pror_cache_set($cache_obj, ob_get_flush());
    }

    wp_localize_script('searchbox-common', 'ProRemontSearchbox', array(
        'catalogs' => $catalogs,
        'sections' => $sections
    ));
});

add_action('wp_print_styles', function () {
    wp_enqueue_style('searchbox-common', get_module_css('searchbox/common.css'), array(), null);
});
