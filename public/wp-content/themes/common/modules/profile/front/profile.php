<?php

add_action('wp_print_styles', function () {
    if (pror_profile_is_profile_pages()) {
        wp_enqueue_style('profile-common', get_module_css('profile/common.css'), array(), dlv_get_ver());
    }
});

add_action('wp_enqueue_scripts', function () {
    if (pror_profile_is_profile_pages()) {
        wp_enqueue_script('profile-common', get_module_js('profile/common.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('ui', get_module_js('theme/jquery-ui.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('ui-widget', get_module_js('theme/jquery.ui.widget.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('iframe-transport', get_module_js('theme/jquery.iframe-transport.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('fileupload', get_module_js('theme/jquery.fileupload.js'), array('jquery'), dlv_get_ver(), true);
    }
});

add_action('wp', function() {
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['profile_update_type']) && is_page('profile')) {
        $redirect_url = pror_get_permalink_by_slug('profile');
        $redirect_url = add_query_arg('section', $_GET['section'], $redirect_url);

        $role = pror_user_has_role('master') ? 'master' : 'subscriber';
        $result = pror_profile_register_user(null, $role);

        if (is_wp_error($result)) {
            $errors = join(',', $result->get_error_codes());
            $redirect_url = add_query_arg('errors', $errors, $redirect_url);
        } else {
            $redirect_url = add_query_arg('success', '1', $redirect_url);
        }

        wp_redirect( $redirect_url );
        exit;
    }
});
