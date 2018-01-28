<?php

add_action('init', function() {
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
            'slug' => '%location%/master',
        ),
        'delete_with_user' => true,
        'supports' => array(
            'title',
            'excerpt',
            'editor',
            'comments',
            'revisions',
        ),
    ));

    register_taxonomy('catalog_master', array('master', 'post'), array(
        'labels' => array(
            'name' => __('Catalog'),
            'singular_name' => __('Catalog'),
            'add_new_item' => __('Add New Catalog'),
            'edit_item' => __('Edit Catalog'),
        ),
        'hierarchical' => true,
        'rewrite' => array(
            'with_front' => false,
            'slug' => 'mastera',
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

    add_rewrite_rule('([^/]+)/master/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$','index.php?location=$matches[1]&master=$matches[2]&feed=$matches[3]','top');
    add_rewrite_rule('([^/]+)/master/([^/]+)/(feed|rdf|rss|rss2|atom)/?$','index.php?location=$matches[1]&master=$matches[2]&feed=$matches[3]','top');
});

add_filter('rewrite_rules_array', function($rules) {
    foreach ($rules as $regexp => $rule) {
        if (strpos($rule, 'index.php?section=$matches[1]') === 0 && strpos($regexp, '/mastera/') === false) {
            unset($rules[$regexp]);
        }
        if (strpos($rule, 'index.php?location=$matches[1]') === 0 && strpos($regexp, '/master/') === false) {
            unset($rules[$regexp]);
        }
        if (strpos($rule, 'index.php?category_name=$matches[1]') === 0) {
            unset($rules[$regexp]);
        }
    }

    return $rules;
});
