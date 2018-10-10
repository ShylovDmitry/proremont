<?php

add_action('wp_print_styles', function () {
//    if (is_page('login')) {
        wp_enqueue_style('profile-common', get_module_css('profile/common.css'), array(), dlv_get_ver());
        wp_enqueue_style('profile-select2', get_module_css('theme/select2.min.css'), array(), dlv_get_ver());
//    }
});

add_action('wp_enqueue_scripts', function () {
//    if (is_page('login')) {
        wp_enqueue_script('profile-common', get_module_js('profile/common.js'), array('jquery'), dlv_get_ver(), true);
        wp_enqueue_script('profile-select2', get_module_js('theme/select2.min.js'), array('jquery'), dlv_get_ver(), true);
//    }
});


add_action('login_form_login', function() {
    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;

        if ( is_user_logged_in() ) {
            pror_profile_redirect_logged_in_user( $redirect_to );
            exit;
        }

        // The rest are redirected to the login page
        // TODO: lang
        $login_url = home_url( 'login' );
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
        // TODO: lang
        wp_redirect( home_url( 'login' ) );
    }
}

add_filter('authenticate', function( $user, $username, $password ) {
    // Check if the earlier authenticate filter (most likely,
    // the default WordPress authentication) functions have found errors
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        if ( is_wp_error( $user ) ) {
            $error_codes = join( ',', $user->get_error_codes() );

            // TODO: lang
            $login_url = home_url( 'login' );
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

        default:
            break;
    }

    return __( 'Ошибка. Попробуйте еще раз позже.', 'common' );
}

add_action( 'wp_logout', function() {
    $redirect_url = home_url( 'login?logged_out=true' );
    wp_safe_redirect( $redirect_url );
    exit;
} );

add_filter( 'login_redirect', function($redirect_to, $requested_redirect_to, $user) {
    $redirect_url = home_url();

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
        // TODO: lang
        $redirect_url = home_url( 'profile' );
    }

    return wp_validate_redirect( $redirect_url, home_url() );
}, 10, 3 );


add_action( 'login_form_register', function() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        if ( is_user_logged_in() ) {
            pror_profile_redirect_logged_in_user();
        } else {
            wp_redirect( home_url( 'register' ) );
        }
        exit;
    }
} );

function pror_profile_register_user( $email, $first_name, $last_name ) {
    $errors = new WP_Error();

    if ( ! is_email( $email ) ) {
        $errors->add( 'email', pror_profile_get_error_message( 'email' ) );
        return $errors;
    }

    if ( username_exists( $email ) || email_exists( $email ) ) {
        $errors->add( 'email_exists', pror_profile_get_error_message( 'email_exists') );
        return $errors;
    }

    $password = wp_generate_password( 12, false );

    $user_data = array(
        'user_login'    => $email,
        'user_email'    => $email,
        'user_pass'     => $password,
        'first_name'    => $first_name,
        'last_name'     => $last_name,
        'nickname'      => $first_name,
    );

    $user_id = wp_insert_user( $user_data );
//    wp_new_user_notification( $user_id, $password );

    return $user_id;
}

function pror_profile_register_master( $email, $first_name, $last_name, $data ) {

    $user_id = pror_profile_register_user($email, $first_name, $last_name);

    if (!is_wp_error($user_id)) {
        update_user_meta($user_id, 'master_title', $data['user_title']);
        update_user_meta($user_id, '_master_title', 'field_59ebc9689376d');

        update_user_meta($user_id, 'master_type', $data['user_type']);
        update_user_meta($user_id, '_master_type', 'field_59ebc3fa7f3e5');

        update_user_meta($user_id, 'master_gallery', serialize([]));
        update_user_meta($user_id, '_master_gallery', 'field_59ebc3fa7f436');

        // master_url_slug - field_5ab185c6ed95e

        update_user_meta($user_id, 'master_phone', $data['user_tel']);
        update_user_meta($user_id, '_master_phone', 'field_5bb9dffd3c5c8');

        update_user_meta($user_id, 'master_location', $data['user_city']);
        update_user_meta($user_id, '_master_location', 'field_59ebd9a8748a5');

        update_user_meta($user_id, 'master_website', $data['user_website']);
        update_user_meta($user_id, '_master_website', 'field_59ebc3fa7f426');

        update_user_meta($user_id, 'master_text', $data['user_description']);
        update_user_meta($user_id, '_master_text', 'field_59ebc99b9376f');

        update_user_meta($user_id, 'master_catalog', $data['user_catalog_master']);
        update_user_meta($user_id, '_master_catalog', 'field_59ebda792dfb3');
    }

    return $user_id;
}

add_action( 'login_form_register', function() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        if ($_POST['account_type'] == 'master') {
            $redirect_url = home_url('register-master'); // TODO: lang
        } else {
            $redirect_url = home_url('register'); // TODO: lang
        }

        if ( ! get_option( 'users_can_register' ) ) {
            $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
        } else {
            if ($_POST['account_type'] == 'master') {
                $email = $_POST['email'];
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
                ];

                $result = pror_profile_register_master($email, $first_name, $last_name, $data);
            } else {
                $email = $_POST['email'];
                $first_name = sanitize_text_field($_POST['first_name']);
                $last_name = sanitize_text_field($_POST['last_name']);

                $result = pror_profile_register_user($email, $first_name, $last_name);
            }

            if ( is_wp_error( $result ) ) {
                $errors = join( ',', $result->get_error_codes() );
                $redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );
            } else {
                $redirect_url = home_url( 'login' ); // TODO: lang
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

        wp_redirect( home_url( 'password-lost' ) );
        exit;
    }
} );

add_action( 'login_form_lostpassword', function() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $errors = retrieve_password();
        if ( is_wp_error( $errors ) ) {
            // Errors found
            $redirect_url = home_url( 'password-lost' );
            $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
        } else {
            // Email sent
            $redirect_url = home_url( 'login' );
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
                wp_redirect( home_url( 'login?login=expiredkey' ) );
            } else {
                wp_redirect( home_url( 'login?login=invalidkey' ) );
            }
            exit;
        }

        $redirect_url = home_url( 'password-reset' );
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
                wp_redirect( home_url( 'login?login=expiredkey' ) );
            } else {
                wp_redirect( home_url( 'login?login=invalidkey' ) );
            }
            exit;
        }

        if ( isset( $_POST['pass1'] ) ) {
            if ( $_POST['pass1'] != $_POST['pass2'] ) {
                // Passwords don't match
                $redirect_url = home_url( 'password-reset' );

                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

            if ( empty( $_POST['pass1'] ) ) {
                // Password is empty
                $redirect_url = home_url( 'password-reset' );

                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

            // Parameter checks OK, reset password
            reset_password( $user, $_POST['pass1'] );
            wp_redirect( home_url( 'login?password=changed' ) );
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
