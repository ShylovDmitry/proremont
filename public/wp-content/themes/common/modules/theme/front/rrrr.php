<?php

add_action('after_switch_theme', function() {
    add_role(
        'master',
        'Мастер',
        array(
            'read' => true,
        )
    );
});

add_action('switch_theme', function() {
    remove_role('master');
});

//////////////////////////////////////////
add_action('init', function() {
    remove_role('master');
    add_role(
        'master',
        'Мастер',
        array(
            'read' => true,
            'upload_files' => true,
        )
    );

//    remove_role('visitor');
//    add_role(
//        'visitor',
//        'Посетитель',
//        array(
//            'read' => true,
//        )
//    );
});
//////////////////////////////////////////

function pror_user_has_role($user_id, $role) {
    $user = get_user_by('id', $user_id);
    return in_array($role, (array)$user->roles);
}

function pror_current_user_has_role($role) {
    $user = wp_get_current_user();
    return pror_user_has_role($user->ID, $role);
}

if (pror_current_user_has_role('master')) {
    remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
    show_admin_bar(false);
}

add_action('admin_head', function() {
    if (!pror_current_user_has_role('master')) {
        return;
    }

    echo '<style>
#wpfooter {
  display: none !important;
}
    </style>';
});


add_action('user_register', function($user_id) {
    if (!pror_user_has_role($user_id, 'master')) {
        return;
    }

    $user = get_user_by('id', $user_id);
    pror_create_master_post($user_id, $user->data->user_login);
});



add_action('profile_update', function ($user_id, $old_user_data) {
    if (!pror_user_has_role($user_id, 'master')) {
        return;
    }

    $master_post_id = pror_get_master_post_id($user_id);
    if (!$master_post_id) {
        $master_post_id = pror_create_master_post($user_id, $old_user_data->user_login);
    }

    if ($master_post_id) {
        wp_update_post(array(
            'ID' => $master_post_id,
            'post_title' => get_field('master_title', "user_{$user_id}"),
            'post_status' => 'publish',
            'post_excerpt' => get_field('master_excerpt', "user_{$user_id}"),
            'post_content' => get_field('master_text', "user_{$user_id}"),
        ));

        $catalog_terms = get_field('master_catalog', "user_{$user_id}");
        wp_set_post_terms($master_post_id, $catalog_terms, 'catalog_master');

        $location_terms = get_field('master_location', "user_{$user_id}");
        wp_set_post_terms($master_post_id, $location_terms, 'location');

        $logo_id = get_field('master_logo', "user_{$user_id}");
        update_post_meta($master_post_id, '_thumbnail_id', $logo_id);
    }
}, 10, 2);



function pror_create_master_post($user_id, $title) {
    return wp_insert_post(array(
        'post_author' => $user_id,
        'post_title' => $title,
        'post_type' => 'master',
    ));
}

function pror_get_master_post_id($user_id) {
    $posts = get_posts(array(
        'author' => $user_id,
        'posts_per_page' => 1,
        'post_type' => 'master',
        'post_status' => 'any',
    ));
    return isset($posts, $posts[0], $posts[0]->ID) ? $posts[0]->ID : false;
}


function pror_get_query_pro_master_ids() {
    $query = new WP_User_Query(array(
        'role' => 'master',
        'fields' => 'ID',
        'meta_query' => array(
            array(
                'key' => 'master_location',
                'value' => get_field('locations', pror_get_section()),
                'compare' => 'IN',
            ),
            array(
                'key' => 'master_is_pro',
                'value' => '1',
            ),
        ),
    ));
    return $query->results ? $query->results : array(-999);
}
