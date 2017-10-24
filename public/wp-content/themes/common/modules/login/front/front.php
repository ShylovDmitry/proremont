<?php

add_action('login_enqueue_scripts', function() {
    wp_enqueue_style('custom-login', get_module_css('login/common.css'), array(), dlv_get_ver());
//    wp_enqueue_script('custom-login', get_stylesheet_directory_uri() . '/style-login.js');
});

