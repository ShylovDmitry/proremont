<?php

add_action('wp_head', function() {
    if (WP_ENV_LOCAL) {
        return;
    }

//    module_template('scripts/ga');
    module_template('scripts/gtm');
    module_template('scripts/pixel');
    module_template('scripts/yandex_metrica');
});

add_action('login_head', function() {
    if (WP_ENV_LOCAL) {
        return;
    }

//    module_template('scripts/ga');
    module_template('scripts/gtm');
    module_template('scripts/pixel');
    module_template('scripts/yandex_metrica');
});

add_action('admin_head', function() {
    if (WP_ENV_LOCAL) {
        return;
    }
    if (is_user_logged_in() && !pror_user_has_role('master subscriber')) {
        return;
    }

//    module_template('scripts/ga');
    module_template('scripts/gtm');
    module_template('scripts/pixel');
    module_template('scripts/yandex_metrica');
});

add_action('pror_body_before', function() {
    if (WP_ENV_LOCAL) {
        return;
    }

    module_template('scripts/gtm_body');
});
