<?php

add_action('init', function() {
    register_post_type('tender_response', array(
        'labels' => array(
            'name' => __('Tender Responses'),
            'singular_name' => __('Tender Response'),
            'add_new_item' => __('Add New Tender Response'),
            'edit_item' => __('Edit Tender Response'),
        ),
        'public' => false,
        'show_ui' => true,
        'supports' => array(
            'revisions',
        ),
    ));
});
