<?php

add_action('admin_enqueue_scripts', function() {
    if (pror_current_user_has_role('master')) {
        wp_enqueue_style('admin-profile', get_module_css('master/admin-profile.css'), array(), dlv_get_ver());
    }
});

add_action('admin_head', function() {
    if (!pror_current_user_has_role('master')) {
        return;
    }

    echo '<style>
#wpfooter {
  display: none !important;
}
    </style>';
});
