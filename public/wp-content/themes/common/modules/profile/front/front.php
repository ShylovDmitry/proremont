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
    switch ( $error_code ) {
        case 'empty_username':
            return __( 'Необходимо ввести Email.', 'common' );

        case 'empty_password':
            return __( 'Необходимо ввести пароль.', 'common' );

        case 'invalid_username':
            return __("Пользователь с таким Email не зарегестрирован. Возможно вы использовали другой Email при регистрации", 'common');

        case 'incorrect_password':
            $err = __("Неверний пароль. Вы <a href='%s'>забыли пароль</a>?", 'common');
            return sprintf( $err, wp_lostpassword_url() );

        // Registration errors

        case 'email':
            return __( 'Вы ввели неверний Email.', 'common' );

        case 'email_exists':
            return __( 'Пользователь с таким Email уже зарегистрирован.', 'common' );

        case 'closed':
            return __( 'Регистрация для новых пользователей временно закрыта.', 'common' );

        // Lost password

        case 'invalid_email':
        case 'invalidcombo':
            return __( 'Пользователь с таким Email не найден.', 'common' );

        // Reset password

        case 'expiredkey':
        case 'invalidkey':
            return __( 'Ссылка для востановления пароля устарела.', 'common' );

        case 'password_reset_mismatch':
            return __( "Пароли не совпадают.", 'common' );

        case 'password_reset_empty':
            return __( "Извините, вы не можете использовать пустой пароль.", 'common' );


        // Settings

        case 'first_name':
            return __( 'Неправильное Имя.', 'common' );

        case 'last_name':
            return __( 'Неправильное Фамилия.', 'common' );

        case 'contact_phone':
            return __( 'Неправильный Контактный телефон.', 'common' );

        case 'user_title':
            return __( 'Неправильное Название.', 'common' );

        case 'user_type':
            return __( 'Неправильный Тип.', 'common' );

        case 'user_tel':
            return __( 'Неправильный Робочий телефон.', 'common' );

        case 'user_city':
            return __( 'Неправильный Город.', 'common' );

        case 'user_description':
            return __( 'Неправильное Описание.', 'common' );

        case 'user_catalog_master':
            return __( 'Неправильная Категория.', 'common' );

        default:
            break;
    }

    return __( 'Ошибка. Попробуйте еще раз позже.', 'common' );
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

function pror_profile_register_user( $email, $data, $role = 'subscriber' ) {
    $errors = new WP_Error();

    if ( ! is_email( $email ) ) {
        $errors->add( 'email', pror_profile_get_error_message( 'email' ) );
        return $errors;
    }

    if ( username_exists( $email ) || email_exists( $email ) ) {
        $errors->add( 'email_exists', pror_profile_get_error_message( 'email_exists') );
        return $errors;
    }

    if (empty( $data['first_name'])) {
        $errors->add( 'first_name', pror_profile_get_error_message( 'first_name' ) );
        return $errors;
    }

    if (empty( $data['last_name'])) {
        $errors->add( 'last_name', pror_profile_get_error_message( 'last_name' ) );
        return $errors;
    }

    $password = wp_generate_password( 12, false );

    $user_data = array(
        'user_login'    => $email,
        'user_email'    => $email,
        'user_pass'     => $password,
        'first_name'    => $data['first_name'],
        'last_name'     => $data['last_name'],
        'nickname'      => $data['first_name'],
        'role'          => $role,
    );

    $user_id = wp_insert_user( $user_data );

    if (!is_wp_error($user_id)) {
        if (empty( $data['contact_phone'])) {
            $errors->add( 'contact_phone', pror_profile_get_error_message( 'contact_phone' ) );
            return $errors;
        }
        update_user_meta($user_id, 'contact_phone', $data['contact_phone']);
        update_user_meta($user_id, '_contact_phone', 'field_5bc3bcf7b0285');

//        wp_new_user_notification( $user_id, $password );
    }

    return $user_id;
}

function pror_profile_register_master( $email, $data ) {
    $user_id = pror_profile_register_user($email, $data, 'master');

    if (!is_wp_error($user_id)) {
        $errors = new WP_Error();

        if (empty( $data['user_title'])) {
            $errors->add( 'user_title', pror_profile_get_error_message( 'user_title' ) );
            return $errors;
        }
        update_user_meta($user_id, 'master_title', $data['user_title']);
        update_user_meta($user_id, '_master_title', 'field_59ebc9689376d');

        if (empty( $data['user_type'])) {
            $errors->add( 'user_type', pror_profile_get_error_message( 'user_type' ) );
            return $errors;
        }
        update_user_meta($user_id, 'master_type', $data['user_type']);
        update_user_meta($user_id, '_master_type', 'field_59ebc3fa7f3e5');

        update_user_meta($user_id, 'master_url_slug', $data['user_url']);
        update_user_meta($user_id, '_master_url_slug', 'field_5ab185c6ed95e');

        if (empty( $data['user_tel'])) {
            $errors->add( 'user_tel', pror_profile_get_error_message( 'user_tel' ) );
            return $errors;
        }
        update_user_meta($user_id, 'master_phone', $data['user_tel']);
        update_user_meta($user_id, '_master_phone', 'field_5bb9dffd3c5c8');

        if (empty( $data['user_city'])) {
            $errors->add( 'user_city', pror_profile_get_error_message( 'user_city' ) );
            return $errors;
        }
        update_user_meta($user_id, 'master_location', $data['user_city']);
        update_user_meta($user_id, '_master_location', 'field_59ebd9a8748a5');

        update_user_meta($user_id, 'master_website', $data['user_website']);
        update_user_meta($user_id, '_master_website', 'field_59ebc3fa7f426');

        if (empty( $data['user_description'])) {
            $errors->add( 'user_description', pror_profile_get_error_message( 'user_description' ) );
            return $errors;
        }
        update_user_meta($user_id, 'master_text', $data['user_description']);
        update_user_meta($user_id, '_master_text', 'field_59ebc99b9376f');

        if (empty( $data['user_catalog_master'])) {
            $errors->add( 'user_catalog_master', pror_profile_get_error_message( 'user_catalog_master' ) );
            return $errors;
        }
        update_user_meta($user_id, 'master_catalog', $data['user_catalog_master']);
        update_user_meta($user_id, '_master_catalog', 'field_59ebda792dfb3');

        update_user_meta($user_id, 'master_gallery', serialize([]));
        update_user_meta($user_id, '_master_gallery', 'field_59ebc3fa7f436');

        update_user_meta($user_id, 'master_logo', '');
        update_user_meta($user_id, '_master_logo', 'field_59ebc8f130c58');
    }

    return $user_id;
}

function pror_profile_sanitize_url($title) {
    return sanitize_title($title);
}

add_action( 'login_form_register', function() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        if ($_POST['account_type'] == 'master') {
            $redirect_url = pror_get_permalink_by_slug('register-master');
        } else {
            $redirect_url = pror_get_permalink_by_slug('register');
        }

        if ( ! get_option( 'users_can_register' ) ) {
            $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
        } else {
            $email = $_POST['email'];

            $data = [
                'first_name' => sanitize_text_field($_POST['first_name']),
                'last_name' => sanitize_text_field($_POST['last_name']),
                'contact_phone' => sanitize_text_field($_POST['tel']),
            ];

            if ($_POST['account_type'] == 'master') {
                $data = array_merge($data, [
                    'user_title' => sanitize_text_field($_POST['user_title']),
                    'user_type' => sanitize_text_field($_POST['user_type']),
                    'user_tel' => sanitize_text_field($_POST['user_tel']),
                    'user_city' => sanitize_text_field($_POST['user_city']),
                    'user_website' => sanitize_text_field($_POST['user_website']),
                    'user_description' => $_POST['user_description'],
                    'user_catalog_master' => $_POST['user_catalog_master'],
                    'user_url' => pror_profile_sanitize_url($_POST['user_title']),
                ]);

                $result = pror_profile_register_master($email, $data);
            } else {
                $result = pror_profile_register_user($email, $data);
            }

            if ( is_wp_error( $result ) ) {
                $errors = join( ',', $result->get_error_codes() );
                $redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );
            } else {
                $redirect_url = pror_get_permalink_by_slug( 'login' );
                $redirect_url = add_query_arg( 'registered', $email, $redirect_url );
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

add_filter( 'retrieve_password_message', function($message, $key, $user_login, $user_data ) {
    // Create new message
    $msg  = __( 'Hello!', 'common' ) . "\r\n\r\n";
    $msg .= sprintf( __( 'You asked us to reset your password for your account using the email address %s.', 'common' ), $user_login ) . "\r\n\r\n";
    $msg .= __( "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.", 'common' ) . "\r\n\r\n";
    $msg .= __( 'To reset your password, visit the following address:', 'common' ) . "\r\n\r\n";
    $msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
    $msg .= __( 'Thanks!', 'common' ) . "\r\n";

    return $msg;
}, 10, 4 );

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
