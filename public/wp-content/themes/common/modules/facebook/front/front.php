<?php

add_filter('wp_head', function() {
    if (!WP_ENV_LOCAL) {
        module_template('facebook/pixel');
    }
});
