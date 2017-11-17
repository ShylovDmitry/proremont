<?php

add_action('wp_head', function() {
    if (!WP_ENV_LOCAL) {
        module_template('facebook/pixel');
    }
});

add_action('login_head', function() {
    if (!WP_ENV_LOCAL) {
        module_template('facebook/pixel');
    }
});
