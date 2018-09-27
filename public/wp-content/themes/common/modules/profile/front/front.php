<?php

add_action('wp_print_styles', function () {
//    if (is_page('login')) {
        wp_enqueue_style('profile-common', get_module_css('profile/common.css'), array(), dlv_get_ver());
//    }
});

add_action('wp_enqueue_scripts', function () {
//    if (is_page('login')) {
        wp_enqueue_script('profile-common', get_module_js('profile/common.js'), array('jquery'), dlv_get_ver(), true);
//    }
});


add_action('wp_ajax_pror_profile_login', 'pror_profile_login_ajax');
add_action('wp_ajax_nopriv_pror_profile_login', 'pror_profile_login_ajax');
function pror_profile_login_ajax() {
    $res = wp_signon();
    if (is_wp_error($res)) {
        wp_send_json_error($res);
    }
    wp_send_json_success();
}

add_action('wp_ajax_pror_profile_register', 'pror_profile_register_ajax');
add_action('wp_ajax_nopriv_pror_profile_register', 'pror_profile_register_ajax');
function pror_profile_register_ajax() {
    $email = $_POST['user_email'];
//    $username = sanitize_user($email, true);

    $user_id = register_new_user($email, $email);
    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id);
    }

    $user_id = wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $_POST['user_first_name'],
        'last_name' => $_POST['user_last_name']
    ));

    // TODO: update tel

    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id);
    }

    wp_send_json_success();
}

add_action('wp_ajax_pror_profile_lostpassword', 'pror_profile_lostpassword_ajax');
add_action('wp_ajax_nopriv_pror_profile_lostpassword', 'pror_profile_lostpassword_ajax');
function pror_profile_lostpassword_ajax() {
//    retrieve_password();

    $email = $_POST['user_email'];
//    $username = sanitize_user($email, true);

    $user_id = register_new_user($email, $email);
    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id);
    }

    $user_id = wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $_POST['user_first_name'],
        'last_name' => $_POST['user_last_name']
    ));

    // TODO: update tel

    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id);
    }

    wp_send_json_success();
}
