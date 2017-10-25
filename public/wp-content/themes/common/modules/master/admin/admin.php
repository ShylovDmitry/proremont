<?php

add_action('admin_enqueue_scripts', function($hook) {
    if (pror_current_user_has_role('master') && is_admin()) {
        wp_enqueue_style('admin-profile', get_module_css('master/admin-profile.css'), array(), dlv_get_ver());
        wp_enqueue_script('admin-profile', get_module_js('master/admin-profile.js'), array(), dlv_get_ver(), true);
    }
});
