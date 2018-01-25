<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('breadcrumbs-common', get_module_css('breadcrumbs/common.css'), array(), dlv_get_ver());
});
