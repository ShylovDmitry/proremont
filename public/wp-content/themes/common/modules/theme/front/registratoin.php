<?php

add_action('login_head', function(){
?>
    <style>
        #registerform > p:first-child{
            display:none;
        }
    </style>
<?php
});

//Remove error for username, only show error for email only.
add_filter('registration_errors', function($wp_error, $sanitized_user_login, $user_email){
    if (isset($wp_error->errors['empty_username'])) {
        unset($wp_error->errors['empty_username']);
    }

    if (isset($wp_error->errors['username_exists'])) {
        unset($wp_error->errors['username_exists']);
    }
    return $wp_error;
}, 10, 3);

add_action('login_form_register', function(){
    if (isset($_POST['user_login']) && isset($_POST['user_email']) && !empty($_POST['user_email'])) {
        $_POST['user_login'] = sanitize_user($_POST['user_email'], true);
    }
});
