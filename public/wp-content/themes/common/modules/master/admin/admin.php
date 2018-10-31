<?php

add_action('edit_form_after_title', function($post) {
    if (get_post_type($post) == 'master' && pror_user_has_role('administrator')) {
        echo sprintf('<a href="%s">%s (ID %s)</a>', get_edit_user_link($post->post_author), 'Редактировать пользователя', $post->post_author);
    }
});

add_action('wp_ajax_pror_master_sanitize_title', 'pror_ajax_master_sanitize_title');
add_action('wp_ajax_nopriv_pror_master_sanitize_title', 'pror_ajax_master_sanitize_title');
function pror_ajax_master_sanitize_title() {
    $title = sanitize_title($_POST['title']);

    $res = '';
    if (empty($title)) {
        $res = 'empty';
    } else if (!preg_match('/^[a-zA-Z0-9\-\.]+$/', $_POST['title'])) {
        $res = 'chars';
    } else if ($post = get_page_by_path($title, OBJECT, 'master')) {
        if ($post->post_author != $_POST['user_id']) {
            $res = 'exists';
        }
    }

    wp_send_json_success(array(
        'title' => $title,
        'error' => $res,
    ));
}

add_action('show_user_profile', function($profileuser) {
    module_template('master/admin/profile-top', ['profileuser' => $profileuser]);
}, 5);

add_action('edit_user_profile', function($profileuser) {
    module_template('master/admin/profile-top', ['profileuser' => $profileuser]);
}, 5);

//add_filter('acf/load_value/key=field_5ab185c6ed95e', function($value, $post_id, $field) {
//    if (empty($value)) {
//        list($type, $user_id) = explode('_', $post_id);
//        $post_id = pror_get_master_post_id($user_id);
//        $post = get_post($post_id);
//
//        if ($post) {
//            return $post->post_name;
//        }
//    }
//    return $value;
//}, 10, 3);
