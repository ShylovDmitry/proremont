<?php

add_action('init', function() {
    register_post_type('partner', array(
        'labels' => array(
            'name' => __('Partners'),
            'singular_name' => __('Partner'),
            'add_new_item' => __('Add New Partner'),
            'edit_item' => __('Edit Partner'),
        ),
        'public' => true,
        'rewrite' => array(
            'with_front' => false,
        ),
        'supports' => array(
            'title',
            'excerpt',
            'editor',
            'thumbnail',
            'revisions',
        ),
    ));
});
