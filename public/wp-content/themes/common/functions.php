<?php

add_image_size('pror-medium', 300, 300, true);

add_filter('request', function($query_vars) {
    if (isset($_GET['change_city'])) {
        $term = get_term($_GET['change_city']);

        $p = parse_url($_SERVER['REQUEST_URI']);
        parse_str($p['query'], $q);
        unset($q['change_city']);

        $url = sprintf('%s%s',
            str_replace('/' . $query_vars['city'] . '/', '/' . $term->slug . '/', $p['path']),
            empty($q) ? '' : '?' . http_build_query($q)
        );
        wp_redirect($url);
        exit;
    }

    return $query_vars;
});

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

//register_post_type('shop', array(
//    'labels' => array(
//        'name' => __('Shops'),
//        'singular_name' => __('Shop'),
//        'add_new_item' => __('Add New Shop'),
//        'edit_item' => __('Edit Shop'),
//    ),
//    'public' => true,
//    'supports' => array(
//        'title',
//        'excerpt',
//        'editor',
//        'comments',
//        'revisions',
//    ),
//));

register_taxonomy('location', 'master', array(
    'labels' => array(
        'name' => __('Location'),
        'singular_name' => __('Location'),
        'add_new_item' => __('Add New Location'),
        'edit_item' => __('Edit Location'),
    ),
    'hierarchical' => true,
    'public' => true,
));

register_taxonomy('catalog_master', 'master', array(
    'labels' => array(
        'name' => __('Catalog'),
        'singular_name' => __('Catalog'),
        'add_new_item' => __('Add New Catalog'),
        'edit_item' => __('Edit Catalog'),
    ),
    'hierarchical' => true,
    'rewrite' => array('slug' => 'catalog_master/%city%', 'hierarchical' => true,),
    'public' => true,
));

//register_taxonomy('catalog_shop', 'shop', array(
//    'labels' => array(
//        'name' => __('Catalog'),
//        'singular_name' => __('Catalog'),
//        'add_new_item' => __('Add New Catalog'),
//        'edit_item' => __('Edit Catalog'),
//    ),
//    'hierarchical' => true,
//    'rewrite' => array( 'hierarchical' => true, ),
//    'public' => true,
//));


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

//    $catalog_shop_page = get_page_by_template_name('template-catalog_shop.php');
//    $breadcrumb_catalog_shop = array(
//        'text' => get_the_title($catalog_shop_page),
//        'url' => get_permalink($catalog_shop_page),
//        'allow_html' => true,
//    );

    if (isset($last, $last['id']) && $last['id']) {
        $post_type = get_post_type($last['id']);

        if ($post_type == 'master') {
            array_splice($crumbs, 1, 0, array($breadcrumb_catalog_master));
//        } elseif ($post_type == 'shop') {
//            array_splice($crumbs, 1, 0, array($breadcrumb_catalog_shop));
        } else {
        }
    }

    if (isset($last, $last['term'], $last['term']->taxonomy) && $last['term']->taxonomy == $catalog_master_page->post_name) {
        array_splice($crumbs, 1, 0, array($breadcrumb_catalog_master));
    }

//    if (isset($last, $last['term'], $last['term']->taxonomy) && $last['term']->taxonomy == $catalog_shop_page->post_name) {
//        array_splice($crumbs, 1, 0, array($breadcrumb_catalog_shop));
//    }

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

add_action('pre_get_posts', function($query) {
    if (is_admin() ||  !$query->is_main_query()) {
        return;
    }

    $filter = isset($_GET['filter']) && is_array($_GET['filter']) && !empty($_GET['filter']) ? $_GET['filter'] : null;
    if (!$filter) {
        return;
    }


    if (!empty($filter['master_type'])) {
        $query->set('meta_query', array(
            array(
                'key' => 'master_type',
                'value' => $filter['master_type'],
            )
        ));
    }
});

add_action('pre_get_posts', function($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (!$query->is_tax('catalog_master')) {
        return;
    }

    $term = pror_get_city_object();
    if (!$term) {
        return;
    }

    $query->set('tax_query', array(
        array (
            'taxonomy' => 'location',
            'field' => 'slug',
            'terms' => $term->slug,
        )
    ));
});

function pror_get_city_object() {
    $city = get_query_var('city');
    $term = get_term_by('slug', $city, 'location');
    if ($term) {
        return $term;
    }

    $default_city = 'lvov';
    return get_term_by('slug', $default_city, 'location');
}


add_filter('term_link', function($post_link, $id = 0) {
    $term = pror_get_city_object();
    if ($term) {
        $post_link = str_replace('%city%', $term->slug, $post_link);
    }

    return $post_link;
});


add_action('init', function() {
    add_rewrite_tag('%city%', '([^&]+)');
});

function pror_adrotate_group_by_name($name) {
    global $wpdb;

    $group_id = $wpdb->get_var("SELECT id FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` = '{$name}';");
    if (!$group_id) {
        return '';
    }

    $group_output = adrotate_group($group_id);
    $group_output = str_replace("g g-", "g g-{$name} g-", $group_output);
    return $group_output;

}