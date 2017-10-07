<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('rating-common', get_module_css('rating/common.css'), array(), dlv_get_ver());
});
