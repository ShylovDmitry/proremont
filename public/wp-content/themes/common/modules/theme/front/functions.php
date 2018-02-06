<?php

add_filter('oa_social_login_filter_new_user_role', function($user_role) {
    if (strpos($_SERVER['SCRIPT_NAME'], 'wp-login.php') === false) {
        return 'subscriber';
    }
    return $user_role;
});

add_filter('wp_head', function() {
    echo '<link rel="alternate" href="';
    self_link();
    echo '" hreflang="ru" />';
});
