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

add_action('show_user_profile', function($profileuser) {
    module_template('master/admin/profile-top', ['profileuser' => $profileuser]);
}, 5);

add_action('show_user_profile', function($profileuser) {
    module_template('master/admin/profile-bottom', ['profileuser' => $profileuser]);
}, 100);

add_action('edit_user_profile', function($profileuser) {
    module_template('master/admin/profile-top', ['profileuser' => $profileuser]);
}, 5);

add_action('edit_form_after_title', function($post) {
    if (get_post_type($post) == 'master' && pror_current_user_has_role('administrator')) {
        echo sprintf('<a href="%s">%s (ID %s)</a>', get_edit_user_link($post->post_author), 'Редактировать пользователя', $post->post_author);
    }
});

add_action('pre_user_query', function($u_query) {
    if ( $u_query->query_vars['search'] ){
        $search_query = trim( $u_query->query_vars['search'], '*' );
        if ( $_REQUEST['s'] == $search_query ){
            global $wpdb;

            $u_query->query_from .= " LEFT JOIN {$wpdb->usermeta} phone_usermeta ON phone_usermeta.user_id = {$wpdb->users}.ID AND phone_usermeta.meta_key LIKE 'master_phones_%'";
			$u_query->query_from .= " LEFT JOIN {$wpdb->usermeta} name_usermeta ON name_usermeta.user_id = {$wpdb->users}.ID AND name_usermeta.meta_key = 'master_title'";

//			 $u_query->query_from .= " JOIN {$wpdb->usermeta} cstm ON cstm.user_id = {$wpdb->users}.ID AND cstm.meta_key = 'YOU CUSTOM meta_key'";
//			$u_query->query_from .= " JOIN {$wpdb->posts} psts ON psts.post_author = {$wpdb->users}.ID";

 			$search_by = array( 'user_login', 'user_email', 'display_name', 'name_usermeta.meta_value', 'phone_usermeta.meta_value'/*, 'psts.post_title'*/ );

 			$u_query->query_where = 'WHERE 1=1' . $u_query->get_search_sql( $search_query, $search_by, 'both' );
        }
    }
});
