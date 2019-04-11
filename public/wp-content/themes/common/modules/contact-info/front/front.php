<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('contact-info-common', get_module_css('contact-info/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('contact-info-common', get_module_js('contact-info/common.js'), array('jquery'), dlv_get_ver(), true);
});
