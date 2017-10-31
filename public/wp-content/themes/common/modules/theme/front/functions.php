<?php

function pror_get_page_by_template_name($name) {
    $args = array(
        'post_type' => 'page',
        'posts_per_page' => 1,
        'meta_key' => '_wp_page_template',
        'meta_value' => $name,
    );
    $pages = get_posts($args);
    return $pages[0];
}


add_filter('oa_social_login_filter_new_user_role', function() {
    return 'subscriber';
});
