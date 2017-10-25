<?php

add_action('admin_enqueue_scripts', function($hook) {
    if (pror_current_user_has_role('master') && is_admin()) {
        wp_enqueue_style('admin-profile', get_module_css('master/admin-profile.css'), array(), dlv_get_ver());
        wp_enqueue_script('admin-profile', get_module_js('master/admin-profile.js'), array(), dlv_get_ver(), true);
    }
});


add_action('pre_get_posts', function($wp_query_obj) {
    global $current_user, $pagenow;

    $is_attachment_request = ($wp_query_obj->get('post_type')=='attachment');

    if( !$is_attachment_request )
        return;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( !in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ) )
        return;

    if( !current_user_can('delete_pages') )
        $wp_query_obj->set('author', $current_user->ID );

    return;
});
