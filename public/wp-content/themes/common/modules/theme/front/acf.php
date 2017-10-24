<?php

global $wp_filter;
if (isset($wp_filter['register_form'])) {
    foreach ($wp_filter['register_form']->callbacks as $priority => $callbacks) {
        foreach ($callbacks as $name => $callback) {
            if (preg_match('/[a-fA-F0-9]{32}register_user$/', $name)) {
                unset($wp_filter['register_form']->callbacks[$priority][$name]);
                break;
            }
        }
    }
}



add_action('acf/render_field_settings', function( $field ) {
	acf_render_field_setting( $field, array(
		'label'			=> __('Admin Only?'),
		'instructions'	=> '',
		'name'			=> 'admin_only',
		'type'			=> 'true_false',
		'ui'			=> 1,
	), true);
});

add_filter('acf/prepare_field', function( $field ) {
	if( empty($field['admin_only']) ) return $field;

	if( !current_user_can('administrator') ) return false;

	return $field;
});
