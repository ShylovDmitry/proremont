<?php

add_action('wp_head', function() {
    if (!WP_ENV_LOCAL) {
        module_template('google/ga');
        module_template('google/gtm');
        module_template('google/adsense');
    }
});

add_action('login_head', function() {
    if (!WP_ENV_LOCAL) {
        module_template('google/ga');
        module_template('google/gtm');
        module_template('google/adsense');
    }
});
