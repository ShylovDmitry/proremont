<?php

function modified_column_register( $columns ) {
	$columns['modified'] = 'Modified Date';
	return $columns;
}
add_filter('manage_edit-master_columns', 'modified_column_register');
add_filter('manage_pages_columns', 'modified_column_register');

function modified_column_display($column_name, $post_id) {
	switch ( $column_name ) {
	case 'modified':
		global $post;

		$author_name = get_the_modified_author();
		if (!$author_name) {
		    $revisions = wp_get_post_revisions($post);
		    if (!empty($revisions)) {
		        $revision = reset($revisions);
		        $last_user = get_userdata($revision->post_author);
		        if ($last_user) {
		            $author_name = apply_filters('the_modified_author', $last_user->display_name);
                }
            }
        }



        echo '<p class="mod-date">';
        echo '<em>'.get_the_modified_date().' '.get_the_modified_time().'</em><br />';
        echo '<small>' . esc_html__( 'by ', 'show_modified_date_in_admin_lists' ) . '<strong>'.$author_name.'<strong></small>';
        echo '</p>';
		break; // end all case breaks
	}
}
add_action('manage_posts_custom_column', 'modified_column_display', 10, 2);
add_action('manage_pages_custom_column', 'modified_column_display', 10, 2);

function modified_column_register_sortable($columns) {
	$columns['modified'] = 'modified';
	return $columns;
}
add_filter('manage_edit-master_sortable_columns', 'modified_column_register_sortable');
add_filter('manage_edit-page_sortable_columns', 'modified_column_register_sortable');
