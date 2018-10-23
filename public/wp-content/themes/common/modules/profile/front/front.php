<?php

function pror_profile_is_profile_pages() {
    return is_page('login') || is_page('register') || is_page('register-master') || is_page('profile') || is_page('password-lost') || is_page('password-reset');
}

add_action('wp_print_styles', function () {
    if (pror_profile_is_profile_pages()) {
        wp_enqueue_style('profile-common', get_module_css('profile/common.css'), array(), dlv_get_ver());
    }
});

add_action('wp_enqueue_scripts', function () {
    if (pror_profile_is_profile_pages()) {
        wp_enqueue_script('profile-common', get_module_js('profile/common.js'), array('jquery'), dlv_get_ver(), true);
    }
});

add_filter('oa_social_login_filter_new_user_role', function($user_role) {
    $oa_social_login_source = (!empty ($_REQUEST ['oa_social_login_source']) ? strtolower (trim ($_REQUEST ['oa_social_login_source'])) : '');
    if ($oa_social_login_source == 'comments') {
        return 'subscriber';
    } else if ($oa_social_login_source) {
        return 'master';
    }
    return $user_role;
});

add_action('login_form_login', function() {
    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;

        if ( is_user_logged_in() ) {
            pror_profile_redirect_logged_in_user( $redirect_to );
            exit;
        }

        // The rest are redirected to the login page
        $login_url = pror_get_permalink_by_slug( 'login' );
        if ( ! empty( $redirect_to ) ) {
            $login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
        }

        wp_redirect( $login_url );
        exit;
    }
});

function pror_profile_redirect_logged_in_user( $redirect_to = null ) {
    $user = wp_get_current_user();
    if ( user_can( $user, 'manage_options' ) ) {
        if ( $redirect_to ) {
            wp_safe_redirect( $redirect_to );
        } else {
            wp_redirect( admin_url() );
        }
    } else {
        wp_redirect( pror_get_permalink_by_slug( 'login' ) );
    }
}

add_filter('authenticate', function( $user, $username, $password ) {
    // Check if the earlier authenticate filter (most likely,
    // the default WordPress authentication) functions have found errors
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        if ( is_wp_error( $user ) ) {
            $error_codes = join( ',', $user->get_error_codes() );

            $login_url = pror_get_permalink_by_slug( 'login' );
            $login_url = add_query_arg( 'login', $error_codes, $login_url );

            wp_redirect( $login_url );
            exit;
        }
    }

    return $user;
}, 101, 3);

function pror_profile_get_error_message( $error_code ) {
    $codes = [
        'empty_username' => __( 'Необходимо ввести Email.', 'common' ),
        'empty_password' => __( 'Необходимо ввести пароль.', 'common' ),
        'invalid_username' => __("Пользователь с таким Email не зарегестрирован. Возможно вы использовали другой Email при регистрации", 'common'),
        'existing_user_login' => sprintf( __("Пользователь с таким Email уже зарегестрирован. <a href='%s'>Войти</a> на сайт.", 'common'), wp_login_url() ),
        'incorrect_password' => sprintf( __("Неверний пароль. Вы <a href='%s'>забыли пароль</a>?", 'common'), wp_lostpassword_url() ),
        'email' => __( 'Вы ввели неверний Email.', 'common' ),
        'email_exists' => __( 'Пользователь с таким Email уже зарегистрирован.', 'common' ),
        'closed' => __( 'Регистрация для новых пользователей временно закрыта.', 'common' ),
        'invalid_email' => __( 'Пользователь с таким Email не найден.', 'common' ),
        'invalidcombo' => __( 'Пользователь с таким Email не найден.', 'common' ),
        'expiredkey' => __( 'Ссылка для востановления пароля устарела.', 'common' ),
        'invalidkey' => __( 'Ссылка для востановления пароля устарела.', 'common' ),
        'password_reset_mismatch' => __( "Пароли не совпадают.", 'common' ),
        'password_reset_empty' => __( "Извините, вы не можете использовать пустой пароль.", 'common' ),
        'first_name' => __( 'Неправильное Имя.', 'common' ),
        'last_name' => __( 'Неправильное Фамилия.', 'common' ),
        'contact_phone' => __( 'Неправильный Контактный телефон.', 'common' ),
        'role' => __( 'Неверная Роль.', 'common' ),
        'user_title' => __( 'Неправильное Название.', 'common' ),
        'user_type' => __( 'Неправильный Тип.', 'common' ),
        'user_tel' => __( 'Неправильный Робочий телефон.', 'common' ),
        'user_city' => __( 'Неправильный Город.', 'common' ),
        'user_description' => __( 'Неправильное Описание.', 'common' ),
        'user_catalog_master' => __( 'Неправильная Категория.', 'common' ),
    ];
    return isset($codes[$error_code]) ? $codes[$error_code] : __( 'Ошибка. Попробуйте еще раз позже.', 'common' );
}

add_action( 'wp_logout', function() {
    $redirect_url = pror_get_permalink_by_slug( '/' );
    wp_safe_redirect( $redirect_url );
    exit;
} );

add_filter( 'login_redirect', function($redirect_to, $requested_redirect_to, $user) {
    $redirect_url = pror_get_permalink_by_slug( '/' );

    if ( ! isset( $user->ID ) ) {
        return $redirect_url;
    }

    if ( user_can( $user, 'manage_options' ) ) {
        // Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
        if ( $requested_redirect_to == '' ) {
            $redirect_url = admin_url();
        } else {
            $redirect_url = $requested_redirect_to;
        }
    } else {
        // Non-admin users always go to their account page after login
        if ( $requested_redirect_to == '' ) {
            $redirect_url = pror_get_permalink_by_slug( 'profile' );
        } else {
            $redirect_url = $requested_redirect_to;
        }

    }

    return wp_validate_redirect( $redirect_url, home_url() );
}, 10, 3 );


add_action( 'login_form_register', function() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        if ( is_user_logged_in() ) {
            pror_profile_redirect_logged_in_user();
        } else {
            $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;

            $register_url = pror_get_permalink_by_slug( 'register' );
            if ( ! empty( $redirect_to ) ) {
                $register_url = add_query_arg( 'redirect_to', $redirect_to, $register_url );
            }
            wp_redirect( $register_url );
        }
        exit;
    }
} );

function pror_profile_register_user( $email = null, $role = 'subscriber' ) {
    if (!in_array( $role, ['subscriber', 'master'] )) {
        return new WP_Error( 'role', pror_profile_get_error_message( 'role' ) );
    }

    if (empty( pror_profile_get_send_param('first_name') )) {
        return new WP_Error( 'first_name', pror_profile_get_error_message( 'first_name' ) );
    }

    if (empty( pror_profile_get_send_param('last_name') )) {
        return new WP_Error( 'last_name', pror_profile_get_error_message( 'last_name' ) );
    }

    if (empty( pror_profile_get_send_param('tel') )) {
        return new WP_Error( 'contact_phone', pror_profile_get_error_message( 'contact_phone' ) );
    }

    if ($role == 'master') {
        if (empty(pror_profile_get_send_param('user_title'))) {
            return new WP_Error('user_title', pror_profile_get_error_message('user_title'));
        }

        if (empty(pror_profile_get_send_param('user_type'))) {
            return new WP_Error('user_type', pror_profile_get_error_message('user_type'));
        }

        if (empty(pror_profile_get_send_param('user_tel'))) {
            return new WP_Error('user_tel', pror_profile_get_error_message('user_tel'));
        }

        if (empty(pror_profile_get_send_param('user_city'))) {
            return new WP_Error('user_city', pror_profile_get_error_message('user_city'));
        }

        if (empty(pror_profile_get_send_param('user_description'))) {
            return new WP_Error('user_description', pror_profile_get_error_message('user_description'));
        }

        if (empty(pror_profile_get_send_param('user_catalog_master'))) {
            return new WP_Error('user_catalog_master', pror_profile_get_error_message('user_catalog_master'));
        }
    }

    $user_id = get_current_user_id();
    if ($user_id) {
        return wp_update_user(array(
            'ID'            => get_current_user_id(),
            'first_name'    => pror_profile_get_send_param('first_name'),
            'last_name'     => pror_profile_get_send_param('last_name'),
            'nickname'      => pror_profile_get_send_param('first_name'),
        ));
    } else {
        if ( ! is_email( $email ) ) {
            return new WP_Error( 'email', pror_profile_get_error_message( 'email' ) );
        }

        return wp_insert_user(array(
            'user_login'    => $email,
            'user_email'    => $email,
            'user_pass'     => wp_generate_password( 12, false ),
            'first_name'    => pror_profile_get_send_param('first_name'),
            'last_name'     => pror_profile_get_send_param('last_name'),
            'nickname'      => pror_profile_get_send_param('first_name'),
            'role'          => $role,
        ));
    }
}

add_filter('insert_user_meta', function($meta, $user, $update) {
    $meta['_contact_phone'] = 'field_5bc3bcf7b0285';
    $meta['contact_phone'] = pror_profile_get_send_param('tel');

    if (pror_user_has_role('master', $user->ID)) {
        $meta['_master_title'] = 'field_59ebc9689376d';
        $meta['master_title'] = pror_profile_get_send_param('user_title');

        $meta['_master_type'] = 'field_59ebc3fa7f3e5';
        $meta['master_type'] = pror_profile_get_send_param('user_type');

        $meta['_master_url_slug'] = 'field_5ab185c6ed95e';
        $meta['master_url_slug'] = sanitize_title('user_title');

        $meta['_master_phone'] = 'field_5bb9dffd3c5c8';
        $meta['master_phone'] = pror_profile_get_send_param('user_tel');

        $meta['_master_location'] = 'field_59ebd9a8748a5';
        $meta['master_location'] = pror_profile_get_send_param('user_city');

        $meta['_master_website'] = 'field_59ebc3fa7f426';
        $meta['master_website'] = pror_profile_get_send_param('user_website');

        $meta['_master_text'] = 'field_59ebc99b9376f';
        $meta['master_text'] = pror_profile_get_send_param('user_description');

        $meta['_master_catalog'] = 'field_59ebda792dfb3';
        $meta['master_catalog'] = pror_profile_get_send_param('user_catalog_master');

        $meta['_master_gallery'] = 'field_59ebc3fa7f436';
        $meta['master_gallery'] = pror_profile_get_send_param('user_images');

        $meta['_master_logo'] = 'field_59ebc8f130c58';
        $meta['master_logo'] = pror_profile_get_send_param('');
    }

    return $meta;
}, 10, 3);

function pror_profile_get_send_param($param) {
    switch ($param) {
        case 'first_name':
        case 'last_name':
        case 'tel':
        case 'user_title':
        case 'user_type':
        case 'user_tel':
        case 'user_city':
        case 'user_website':
            return sanitize_text_field($_POST[$param]);

        case 'user_description':
        case 'user_catalog_master':
        case 'user_images':
        case 'logo_id':
        default:
            return $_POST[$param] ? $_POST[$param] : '';
    }
}

add_action( 'login_form_register', function() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        if ($_POST['user_role'] == 'master') {
            $redirect_url = pror_get_permalink_by_slug('register-master');
        } else {
            $redirect_url = pror_get_permalink_by_slug('register');
        }

        if ( ! get_option( 'users_can_register' ) ) {
            $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
        } else {
            $result = pror_profile_register_user($_POST['email'], $_POST['user_role']);

            if ( is_wp_error( $result ) ) {
                $errors = join( ',', $result->get_error_codes() );
                $redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );
            } else {
                $redirect_url = pror_get_permalink_by_slug( 'login' );
                $redirect_url = add_query_arg( 'registered', $_POST['email'], $redirect_url );
            }
        }

        wp_redirect( $redirect_url );
        exit;
    }
} );

add_action( 'login_form_lostpassword', function() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        if ( is_user_logged_in() ) {
            pror_profile_redirect_logged_in_user();
            exit;
        }

        wp_redirect( pror_get_permalink_by_slug( 'password-lost' ) );
        exit;
    }
} );

add_action( 'login_form_lostpassword', function() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $errors = retrieve_password();
        if ( is_wp_error( $errors ) ) {
            // Errors found
            $redirect_url = pror_get_permalink_by_slug( 'password-lost' );
            $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
        } else {
            // Email sent
            $redirect_url = pror_get_permalink_by_slug( 'login' );
            $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
        }

        wp_redirect( $redirect_url );
        exit;
    }
} );

add_action( 'login_form_rp', 'pror_profile_redirect_to_custom_password_reset' );
add_action( 'login_form_resetpass', 'pror_profile_redirect_to_custom_password_reset' );
function pror_profile_redirect_to_custom_password_reset() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        // Verify key / login combo
        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( pror_get_permalink_by_slug( 'login' ) . '?login=expiredkey' );
            } else {
                wp_redirect( pror_get_permalink_by_slug( 'login' ) . '?login=invalidkey' );
            }
            exit;
        }

        $redirect_url = pror_get_permalink_by_slug( 'password-reset' );
        $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
        $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

        wp_redirect( $redirect_url );
        exit;
    }
}

add_action( 'login_form_rp', 'pror_profile_do_password_reset' );
add_action( 'login_form_resetpass', 'pror_profile_do_password_reset' );
function pror_profile_do_password_reset() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $rp_key = $_REQUEST['rp_key'];
        $rp_login = $_REQUEST['rp_login'];

        $user = check_password_reset_key( $rp_key, $rp_login );

        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( pror_get_permalink_by_slug( 'login' ) . '?login=expiredkey');
            } else {
                wp_redirect( pror_get_permalink_by_slug( 'login' ) . '?login=invalidkey' );
            }
            exit;
        }

        if ( isset( $_POST['pass1'] ) ) {
            if ( $_POST['pass1'] != $_POST['pass2'] ) {
                // Passwords don't match
                $redirect_url = pror_get_permalink_by_slug( 'password-reset' );

                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

            if ( empty( $_POST['pass1'] ) ) {
                // Password is empty
                $redirect_url = pror_get_permalink_by_slug( 'password-reset' );

                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

            // Parameter checks OK, reset password
            reset_password( $user, $_POST['pass1'] );
            wp_redirect( pror_get_permalink_by_slug( 'login' ) . '?password=changed');
        } else {
            echo "Invalid request.";
        }

        exit;
    }
}


add_action('wp_ajax_pror_profile_search_city', 'pror_profile_search_city_ajax');
add_action('wp_ajax_nopriv_pror_profile_search_city', 'pror_profile_search_city_ajax');
function pror_profile_search_city_ajax() {
    $results = [];

    $parent_terms = get_terms([
        'taxonomy' => 'location',
        'parent' => 0,
        'fields' => 'id=>name',
    ]);

    $terms = get_terms([
        'taxonomy' => 'location',
        'orderby' => 'name',
        'name__like' => $_REQUEST['term'],
        'childless' => true,
    ]);
    foreach ($terms as $term) {
        $results[] = [
            'id' => $term->term_id,
            'text' => $term->name,
            'parent' => $parent_terms[$term->parent],
        ];
    }

    wp_send_json([
        'results' => $results,
    ]);
}

add_action('wp_ajax_pror_profile_image_upload', 'pror_profile_image_upload_ajax');
function pror_profile_image_upload_ajax() {
    if (!pror_user_has_role('master')) {
        wp_send_json_error('Not a master');
    }

    $post_id = pror_get_master_post_id();
    if (!$post_id) {
        wp_send_json_error('Master does not have presentation');
    }

    $attachment_id = media_handle_upload('files', $post_id);
    if (is_wp_error($attachment_id)) {
        wp_send_json_error($attachment_id);
    }

    $img_data = wp_get_attachment_image_src($attachment_id, 'pror-medium');
    if (!$img_data) {
        wp_send_json_error('Image size does not exist');
    }

    $res = array_combine(
        ['url', 'width', 'height', 'is_intermediate'],
        $img_data
    );
    $res['id'] = $attachment_id;

    wp_send_json_success($res);
}

remove_action('register_new_user', 'wp_send_new_user_notifications');
add_action('user_register', function($user_id) {
    wp_send_new_user_notifications($user_id, 'admin');
});
