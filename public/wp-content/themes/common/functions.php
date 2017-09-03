<?php

register_nav_menus(array(
    'header_main' => 'Header Main',
    'footer_main' => 'Footer Main',
    'footer_secondary' => 'Footer Secondary',
));

register_post_type('master', array(
    'labels' => array(
        'name' => __('Mastera'),
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

register_post_type('magazin', array(
    'labels' => array(
        'name' => __('Magazin'),
        'singular_name' => __('Magazin'),
        'add_new_item' => __('Add New Magazin'),
        'edit_item' => __('Edit Magazin'),
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

register_taxonomy('katalog', array( 'master', 'magazin' ), array(
    'labels' => array(
        'name' => __('Katalog'),
        'singular_name' => __('Katalog'),
        'add_new_item' => __('Add New Katalog'),
        'edit_item' => __('Edit Katalog'),
    ),
    'hierarchical' => true,
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
