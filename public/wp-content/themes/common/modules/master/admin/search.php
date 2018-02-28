<?php

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
