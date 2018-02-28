<?php

add_action('init', function() {
    if (pror_current_user_has_role('master') || pror_current_user_has_role('subscriber')) {
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
        show_admin_bar(false);
    }
});

add_action('admin_enqueue_scripts', function($hook) {
    if ((pror_current_user_has_role('master') || pror_current_user_has_role('subscriber')) && is_admin()) {
        wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Roboto:100,300,400,500,700,900', array(), null);
        wp_enqueue_style('bootstrap', get_module_css('theme/bootstrap-4.0.0-beta.min.css'), array(), null);
        wp_enqueue_style('open-iconic', get_module_css('theme/open-iconic/css/open-iconic-bootstrap.min.css'), array(), '1.1.1');
        wp_enqueue_style('admin-profile', get_module_css('master/admin-profile.css'), array(), dlv_get_ver());

        wp_enqueue_script('admin-profile', get_module_js('master/admin-profile.js'), array(), dlv_get_ver(), true);
        wp_enqueue_script('popper', get_module_js('theme/popper-1.11.0.min.js'), array('jquery'), null, true);
        wp_enqueue_script('bootstrap', get_module_js('theme/bootstrap-4.0.0-beta.min.js'), array('popper', 'jquery'), null, true);
    }
});

add_action('show_user_profile', function($profileuser) {
    module_template('master/admin/profile-top', ['profileuser' => $profileuser]);
}, 5);

add_action('show_user_profile', function($profileuser) {
    module_template('master/admin/profile-bottom', ['profileuser' => $profileuser]);
}, 100);

add_action('edit_user_profile', function($profileuser) {
    module_template('master/admin/profile-top', ['profileuser' => $profileuser]);
}, 5);

add_action('edit_form_after_title', function($post) {
    if (get_post_type($post) == 'master' && pror_current_user_has_role('administrator')) {
        echo sprintf('<a href="%s">%s (ID %s)</a>', get_edit_user_link($post->post_author), 'Редактировать пользователя', $post->post_author);
    }
});

add_action('admin_menu', function() {
    if (pror_current_user_has_role('master')) {
        $master_post_id = pror_get_master_post_id(get_current_user_id());
        if ($master_post_id) {
            global $submenu;
            $submenu['profile.php'][] = array('Перейти на Вашу страницу', 'read', get_permalink($master_post_id), null, 'self-page-link');
            $submenu['profile.php'][] = array('PRO-аккаунт', 'read', home_url('/pro-akkaunt-dlya-masterov/?utm_source=adminpanel&utm_medium=side_menu&utm_campaign=link'), null, 'pro-account-link');
        }
    }
});
