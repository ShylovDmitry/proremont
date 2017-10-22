<?php

add_action('acf/render_field_settings', 'my_admin_only_render_field_settings');

function my_admin_only_render_field_settings( $field ) {

	acf_render_field_setting( $field, array(
		'label'			=> __('Admin Only?'),
		'instructions'	=> '',
		'name'			=> 'admin_only',
		'type'			=> 'true_false',
		'ui'			=> 1,
	), true);

}
add_filter('acf/prepare_field', 'my_admin_only_prepare_field');

function my_admin_only_prepare_field( $field ) {

	// bail early if no 'admin_only' setting
	if( empty($field['admin_only']) ) return $field;


	// return false if is not admin (removes field)
	if( !current_user_can('administrator') ) return false;


	// return
	return $field;
}
