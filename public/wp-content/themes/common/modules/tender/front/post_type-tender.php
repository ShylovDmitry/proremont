<?php

add_action('init', function() {
    register_post_type('tender', array(
        'labels' => array(
            'name' => __('Tenders'),
            'singular_name' => __('Tender'),
            'add_new_item' => __('Add New Tender'),
            'edit_item' => __('Edit Tender'),
        ),
        'public' => true,
        'rewrite' => array(
            'with_front' => false,
        ),
        'supports' => array(
            'title',
            'revisions',
        ),
    ));
});
