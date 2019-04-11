<?php

add_action('init', function() {
    register_taxonomy('catalog_master', array('master', 'post', 'partner', 'tender'), array(
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
});
