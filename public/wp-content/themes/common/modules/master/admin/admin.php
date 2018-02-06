<?php

add_action('admin_enqueue_scripts', function($hook) {
    if ((pror_current_user_has_role('master') || pror_current_user_has_role('subscriber')) && is_admin()) {
        wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Roboto:100,300,400,500,700,900|Roboto+Condensed', array(), null);
        wp_enqueue_style('bootstrap', get_module_css('theme/bootstrap-4.0.0-beta.min.css'), array(), null);
        wp_enqueue_style('open-iconic', get_module_css('theme/open-iconic/css/open-iconic-bootstrap.min.css'), array(), '1.1.1');
        wp_enqueue_style('admin-profile', get_module_css('master/admin-profile.css'), array(), dlv_get_ver());

        wp_enqueue_script('admin-profile', get_module_js('master/admin-profile.js'), array(), dlv_get_ver(), true);
        wp_enqueue_script('popper', get_module_js('theme/popper-1.11.0.min.js'), array('jquery'), null, true);
        wp_enqueue_script('bootstrap', get_module_js('theme/bootstrap-4.0.0-beta.min.js'), array('popper', 'jquery'), null, true);
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

add_action('show_user_profile', function() {
    module_template('master/admin/profile-top');
}, 5);

add_action('show_user_profile', function() {
    module_template('master/admin/profile-bottom');
}, 100);
