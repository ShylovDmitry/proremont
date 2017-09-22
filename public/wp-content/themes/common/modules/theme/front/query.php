<?php

add_action('pre_get_posts', function($query) {
    if (is_admin() ||  !$query->is_main_query()) {
        return;
    }

    if (isset($_GET['f_master_type']) && $_GET['f_master_type']) {
        $query->set('meta_query', array(
            array(
                'key' => 'master_type',
                'value' => $_GET['f_master_type'],
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
