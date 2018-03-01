<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('partner-common', get_module_css('partner/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('partner-common', get_module_js('partner/common.js'), array('jquery'), dlv_get_ver(), true);
});
