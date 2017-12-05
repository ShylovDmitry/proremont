<?php

add_action('wp_head', function() {
    if (!WP_ENV_LOCAL) {
        module_template('scripts/ga');
        module_template('scripts/gtm');
        module_template('scripts/adsense');
        module_template('scripts/pixel');
        module_template('scripts/yandex_metrica');
    }
});

add_action('login_head', function() {
    if (!WP_ENV_LOCAL) {
        module_template('scripts/ga');
        module_template('scripts/gtm');
        module_template('scripts/adsense');
        module_template('scripts/pixel');
        module_template('scripts/yandex_metrica');
    }
});

add_action('pror_body_before', function() {
    module_template('scripts/gtm_body');
});
