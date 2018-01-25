<?php

register_nav_menus(array(
    'header_dropdown' => 'Header Dropdown',
    'footer_main' => 'Footer Main',
    'footer_master' => 'Footer Master',
));

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
