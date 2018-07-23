<?php

add_action('init', function() {
    register_post_type('family', array(
        'labels' => array(
            'name' => __('Family'),
            'singular_name' => __('Family'),
            'add_new_item' => __('Add New Family'),
            'edit_item' => __('Edit Family'),
        ),
        'public' => false,
        'show_ui' => true,
        'supports' => array(
            'title',
            'revisions',
        ),
    ));
});
