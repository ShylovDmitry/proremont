<?php

register_nav_menus(array(
    'header_main' => 'Header Main',
    'footer_main' => 'Footer Main',
    'footer_secondary' => 'Footer Secondary',
));

register_post_type('master', array(
    'labels' => array(
        'name' => __('Masters'),
        'singular_name' => __('Master'),
        'add_new_item' => __('Add New Master'),
        'edit_item' => __('Edit Master'),
    ),
    'public' => true,
    'supports' => array(
        'title',
        'excerpt',
        'editor',
        'comments',
        'revisions',
    ),
));

register_post_type('shop', array(
    'labels' => array(
        'name' => __('Shops'),
        'singular_name' => __('Shop'),
        'add_new_item' => __('Add New Shop'),
        'edit_item' => __('Edit Shop'),
    ),
    'public' => true,
    'supports' => array(
        'title',
        'excerpt',
        'editor',
        'comments',
        'revisions',
    ),
));

register_taxonomy('catalog_master', 'master', array(
    'labels' => array(
        'name' => __('Catalog'),
        'singular_name' => __('Catalog'),
        'add_new_item' => __('Add New Catalog'),
        'edit_item' => __('Edit Catalog'),
    ),
    'hierarchical' => true,
    'rewrite' => array( 'hierarchical' => true, ),
    'public' => true,
));

register_taxonomy('catalog_shop', 'shop', array(
    'labels' => array(
        'name' => __('Catalog'),
        'singular_name' => __('Catalog'),
        'add_new_item' => __('Add New Catalog'),
        'edit_item' => __('Edit Catalog'),
    ),
    'hierarchical' => true,
    'rewrite' => array( 'hierarchical' => true, ),
    'public' => true,
));


if( function_exists('acf_add_options_page') ) {

 	// add parent
	$parent = acf_add_options_page(array(
		'page_title' 	=> 'Front Page Settings',
		'menu_title' 	=> 'Front Page Settings',
		'redirect' 		=> false
	));


	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'TOP Lviv',
		'menu_title' 	=> 'TOP Lviv',
		'parent_slug' 	=> $parent['menu_slug'],
	));

}


add_filter('comment_form_default_fields', function($fields) {
    unset($fields['url']);

    return $fields;
});

add_filter('nav_menu_link_attributes', function($atts, $item, $args, $depth) {
    if (strpos($args->menu_class, 'navbar-nav') !== false) {
        if (isset($atts['class']) && !empty($atts['class'])) {
            $atts['class'] .= ' nav-link';
        } else {
            $atts['class'] = 'nav-link';
        }
    }

    return $atts;
}, 10, 4);

add_filter('wp_nav_menu_objects', function($sorted_menu_items, $args) {
    if (strpos($args->menu_class, 'navbar-nav') !== false) {
        foreach ($sorted_menu_items as &$sorted_menu_item) {
            $sorted_menu_item->classes[] = 'nav-item';

            if (in_array('current_page_item', $sorted_menu_item->classes)) {
                $sorted_menu_item->classes[] = 'active';
            }
        }
        unset($sorted_menu_item);
    }

    if (strpos($args->menu_class, 'list-inline') !== false) {
        foreach ($sorted_menu_items as &$sorted_menu_item) {
            $sorted_menu_item->classes[] = 'list-inline-item';
        }
        unset($sorted_menu_item);
    }

    return $sorted_menu_items;
}, 10, 2);


add_filter('wpseo_breadcrumb_links', function($crumbs) {
    $last = end($crumbs);

    $catalog_master_page = get_page_by_template_name('template-catalog_master.php');
    $breadcrumb_catalog_master = array(
        'text' => get_the_title($catalog_master_page),
        'url' => get_permalink($catalog_master_page),
        'allow_html' => true,
    );

    $catalog_shop_page = get_page_by_template_name('template-catalog_shop.php');
    $breadcrumb_catalog_shop = array(
        'text' => get_the_title($catalog_shop_page),
        'url' => get_permalink($catalog_shop_page),
        'allow_html' => true,
    );

    if (isset($last, $last['id']) && $last['id']) {
        $post_type = get_post_type($last['id']);

        if ($post_type == 'master') {
            array_splice($crumbs, 1, 0, array($breadcrumb_catalog_master));
        } elseif ($post_type == 'shop') {
            array_splice($crumbs, 1, 0, array($breadcrumb_catalog_shop));
        } else {
        }
    }

    if (isset($last, $last['term'], $last['term']->taxonomy) && $last['term']->taxonomy == $catalog_master_page->post_name) {
        array_splice($crumbs, 1, 0, array($breadcrumb_catalog_master));
    }

    if (isset($last, $last['term'], $last['term']->taxonomy) && $last['term']->taxonomy == $catalog_shop_page->post_name) {
        array_splice($crumbs, 1, 0, array($breadcrumb_catalog_shop));
    }

    return $crumbs;
});

function get_page_by_template_name($name) {
    $args = array(
        'post_type' => 'page',
        'posts_per_page' => 1,
        'meta_key' => '_wp_page_template',
        'meta_value' => $name,
    );
    $pages = get_posts($args);
    return $pages[0];
}
