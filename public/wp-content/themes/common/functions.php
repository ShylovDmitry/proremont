<?php


/*
 * Common
 */

add_image_size('pror-medium', 300, 300, true);

add_theme_support( 'html5', array(
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
) );

if( function_exists('acf_add_options_page') ) {
    $parent = acf_add_options_page(array(
		'page_title' 	=> 'Front Page Settings',
		'menu_title' 	=> 'Front Page Settings',
		'redirect' 		=> false
	));
}

add_filter('comment_form_default_fields', function($fields) {
    unset($fields['url']);
    unset($fields['author']);
    unset($fields['email']);

    return $fields;
});

add_filter('comment_form_defaults', function($defaults) {
    $defaults['must_log_in'] = '<p class="must-log-in">Только авторизированый пользователь может оставить коментарий.</p>';

    return $defaults;
}, 1, 5);


/*
 * Menu
 */

register_nav_menus(array(
    'header_main' => 'Header Main',
    'header_dropdown' => 'Header Dropdown',
    'footer_main' => 'Footer Main',
    'footer_secondary' => 'Footer Secondary',
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


/*
 * Custom post types
 */

register_post_type('master', array(
    'labels' => array(
        'name' => __('Masters'),
        'singular_name' => __('Master'),
        'add_new_item' => __('Add New Master'),
        'edit_item' => __('Edit Master'),
    ),
    'public' => true,
    'rewrite' => array(
        'with_front' => false,
        'slug' => '%section%/master'
    ),
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

register_taxonomy('catalog_master', 'master', array(
    'labels' => array(
        'name' => __('Catalog'),
        'singular_name' => __('Catalog'),
        'add_new_item' => __('Add New Catalog'),
        'edit_item' => __('Edit Catalog'),
    ),
    'hierarchical' => true,
    'rewrite' => array(
        'with_front' => false,
        'slug' => '%section%/mastera',
        'hierarchical' => true,
    ),
    'public' => true,
));

register_taxonomy('section', 'master', array(
    'labels' => array(
        'name' => __('Sections'),
        'singular_name' => __('Section'),
        'add_new_item' => __('Add New Section'),
        'edit_item' => __('Edit Section'),
    ),
    'public' => true,
));

register_taxonomy('location', 'master', array(
    'labels' => array(
        'name' => __('Locations'),
        'singular_name' => __('Location'),
        'add_new_item' => __('Add New Location'),
        'edit_item' => __('Edit Location'),
    ),
    'hierarchical' => true,
    'public' => true,
    'publicly_queryable' => false,
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


/*
 * Breadcrumbs
 */

add_filter('wpseo_breadcrumb_links', function($crumbs) {
    $last = end($crumbs);
    $section = pror_get_section();

    $catalog_master_page = get_page_by_template_name('template-catalog_master.php');
    $breadcrumb_catalog_master = array(
        'text' => sprintf('%s - %s', get_the_title($catalog_master_page), $section->name),
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

    if (isset($last, $last['term'], $last['term']->taxonomy) && $last['term']->taxonomy == 'catalog_master') {
        array_splice($crumbs, 1, 0, array($breadcrumb_catalog_master));
    }

//    if (isset($last, $last['term'], $last['term']->taxonomy) && $last['term']->taxonomy == $catalog_shop_page->post_name) {
//        array_splice($crumbs, 1, 0, array($breadcrumb_catalog_shop));
//    }

    if ($section && $section->slug) {
        $crumbs[0]['url'] .= "{$section->slug}/";
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

/*
 * Query
 */

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

global $save_prev_section_value;
add_action('pre_get_posts', function($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (!$query->is_tax('catalog_master')) {
        return;
    }

    $query->set('tax_query', array(
        array (
            'taxonomy' => 'location',
            'terms' => get_field('locations', pror_get_section()),
            'include_children' => false,
            'operator' => 'IN',
        )
    ));

    global $save_prev_section_value;
    $save_prev_section_value = $query->get('section');
    $query->set('section', null);
});

add_filter('the_posts', function($posts, $query) {
    global $save_prev_section_value;
    if ($save_prev_section_value) {
        $query->set('section', $save_prev_section_value);
        unset($save_prev_section_value);
    }
    return $posts;
}, 10 ,2);

/*
 * AdRotate
 */

function pror_adrotate_group_by_name($name) {
    global $wpdb;

    $section_name = sprintf('%s_%s', pror_get_section()->slug, $name);
    $group_id = $wpdb->get_var("SELECT id FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` = '{$section_name}';");
    if ($group_id) {
        $group_output = adrotate_group($group_id);
        $group_output = str_replace("g g-", "g g-{$name} g-{$section_name} g-", $group_output);
        return $group_output;
    }

    $group_id = $wpdb->get_var("SELECT id FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` = '{$name}';");
    if ($group_id) {
        $group_output = adrotate_group($group_id);
        $group_output = str_replace("g g-", "g g-{$name} g-", $group_output);
        return $group_output;
    }

    return '';
}


/*
 * URLs
 */

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
    $catalog_master_page = get_page_by_template_name('template-catalog_master.php');
    if ($catalog_master_page->ID == $post_ID) {
        $section_slug = pror_get_section()->slug;
        $link = str_replace("/{$catalog_master_page->post_name}/", "/{$section_slug}/{$catalog_master_page->post_name}/", $link);
    }

    return $link;
}, 10, 3);

add_filter('nav_menu_link_attributes', function( $atts, $item, $args, $depth ) {
    $catalog_master_page = get_page_by_template_name('template-catalog_master.php');
    if ($item->object_id == $catalog_master_page->ID) {
        $section = pror_get_section();
        $atts = str_replace("/{$catalog_master_page->post_name}/", "/{$section->slug}/{$catalog_master_page->post_name}/", $atts);
    }

    return $atts;
}, 10, 4);

add_filter('wp_seo_get_bc_title', function($link_text, $id) {
    $catalog_master_page = get_page_by_template_name('template-catalog_master.php');
    if ($catalog_master_page->ID == $id) {
        return sprintf('%s - %s', $link_text, pror_get_section()->name);
    }

    return $link_text;
}, 10, 2);


/*
 * Custom functions
 */

function pror_get_section() {
    $section = pror_get_section_by_slug(get_query_var('section'));
    if (!$section) {
        $section = pror_get_section_by_slug('lvov');
    }
    return $section;
}

function pror_get_section_by_slug($slug) {
    return get_term_by('slug', $slug, 'section');
}

function pror_get_section_by_location_id($location_id) {
    $sections = get_terms(array(
        'taxonomy' => 'section',
        'hide_empty' => false,
    ));

    foreach ($sections as $section) {
        if (in_array($location_id, get_field('locations', $section))) {
            return $section;
        }
    }

    return null;
}
