<?php

add_action('wp_print_styles', function () {
//    if (is_page('login')) {
        wp_enqueue_style('profile-common', get_module_css('profile/common.css'), array(), dlv_get_ver());
        wp_enqueue_style('select2', get_module_css('theme/select2.min.css'), array(), dlv_get_ver());
//    }
});

add_action('wp_enqueue_scripts', function () {
//    if (is_page('login')) {
        wp_enqueue_script('profile-common', get_module_js('profile/common.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('select2', get_module_js('theme/select2.min.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('ui', get_module_js('theme/jquery-ui.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('ui-widget', get_module_js('theme/jquery.ui.widget.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('iframe-transport', get_module_js('theme/jquery.iframe-transport.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('fileupload', get_module_js('theme/jquery.fileupload.js'), array('jquery'), dlv_get_ver(), true);
//    }
});


function pror_profile_update_user( $first_name, $last_name ) {
    $errors = new WP_Error();

    if (empty($first_name)) {
        $errors->add( 'first_name', pror_profile_get_error_message( 'first_name') );
        return $errors;
    }
    if (empty($last_name)) {
        $errors->add( 'last_name', pror_profile_get_error_message( 'last_name') );
        return $errors;
    }

    $user_data = array(
        'ID'            => get_current_user_id(),
        'first_name'    => $first_name,
        'last_name'     => $last_name,
        'nickname'      => $first_name,
    );

    $user_id = wp_update_user( $user_data );

    return $user_id;
}

function pror_profile_update_master( $first_name, $last_name, $data ) {

    $user_id = pror_profile_update_user($first_name, $last_name);

    if (!is_wp_error($user_id)) {
        update_user_meta($user_id, 'master_title', $data['user_title']);
//        update_user_meta($user_id, '_master_title', 'field_59ebc9689376d');

        update_user_meta($user_id, 'master_type', $data['user_type']);
//        update_user_meta($user_id, '_master_type', 'field_59ebc3fa7f3e5');

        update_user_meta($user_id, 'master_gallery', serialize([]));
//        update_user_meta($user_id, '_master_gallery', 'field_59ebc3fa7f436');

        // master_url_slug - field_5ab185c6ed95e

        update_user_meta($user_id, 'master_phone', $data['user_tel']);
//        update_user_meta($user_id, '_master_phone', 'field_5bb9dffd3c5c8');

        update_user_meta($user_id, 'master_location', $data['user_city']);
//        update_user_meta($user_id, '_master_location', 'field_59ebd9a8748a5');

        update_user_meta($user_id, 'master_website', $data['user_website']);
//        update_user_meta($user_id, '_master_website', 'field_59ebc3fa7f426');

        update_user_meta($user_id, 'master_text', $data['user_description']);
//        update_user_meta($user_id, '_master_text', 'field_59ebc99b9376f');

        update_user_meta($user_id, 'master_catalog', $data['user_catalog_master']);
//        update_user_meta($user_id, '_master_catalog', 'field_59ebda792dfb3');

        update_user_meta($user_id, 'master_gallery', $data['user_images']);

        update_user_meta($user_id, 'master_logo', $data['logo_id']);
    }

    return $user_id;
}

add_action('wp', function() {
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['profile_update_type']) && is_page('profile')) {
        $redirect_url = home_url('profile'); // TODO: lang
        $redirect_url = add_query_arg('section', $_GET['section'], $redirect_url);

        if ($_POST['profile_update_type'] == 'master') {
            $first_name = sanitize_text_field($_POST['first_name']);
            $last_name = sanitize_text_field($_POST['last_name']);

            $data = [
                'user_title' => sanitize_text_field($_POST['user_title']),
                'user_type' => sanitize_text_field($_POST['user_type']),
                'user_tel' => sanitize_text_field($_POST['user_tel']),
                'user_city' => sanitize_text_field($_POST['user_city']),
                'user_website' => sanitize_text_field($_POST['user_website']),
                'user_description' => $_POST['user_description'],
                'user_catalog_master' => $_POST['user_catalog_master'],
                'user_images' => $_POST['user_images'],
                'logo_id' => (int) $_POST['logo_id'],
            ];

            $result = pror_profile_update_master($first_name, $last_name, $data);
        } else {
            $first_name = sanitize_text_field($_POST['first_name']);
            $last_name = sanitize_text_field($_POST['last_name']);

            $result = pror_profile_update_user($first_name, $last_name);
        }

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