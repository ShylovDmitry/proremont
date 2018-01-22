<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('blog-common', get_module_css('blog/common.css'), array(), dlv_get_ver());
});
