<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Roboto:100,300,400,500,700,900|Roboto+Condensed', array(), null);
    wp_enqueue_style('bootstrap', get_module_css('theme/bootstrap-4.0.0-beta.min.css'), array(), null);
    wp_enqueue_style('slick', get_module_css('theme/slick-1.6.0.css'), array(), null);
    wp_enqueue_style('slick-theme', get_module_css('theme/slick-theme-1.6.0.css'), array(), null);
    wp_enqueue_style('select2', get_module_css('theme/select2-4.0.3.min.css'), array(), null);

    wp_enqueue_style('open-iconic', get_module_css('theme/open-iconic/css/open-iconic-bootstrap.min.css'), array(), '1.1.1');
    wp_enqueue_style('slick-lightbox', get_module_css('theme/slick-lightbox.css'), array(), dlv_get_ver());
    wp_enqueue_style('theme-common', get_module_css('theme/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_module_js('theme/jquery-3.2.1.slim.min.js'), false, null, true);
}, 1);

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('popper', get_module_js('theme/popper-1.11.0.min.js'), array('jquery'), null, true);
    wp_enqueue_script('bootstrap', get_module_js('theme/bootstrap-4.0.0-beta.min.js'), array('jquery'), null, true);
    wp_enqueue_script('slick', get_module_js('theme/slick-1.6.0.min.js'), array('jquery'), null, true);
    wp_enqueue_script('select2', get_module_js('theme/select2-4.0.3.min.js'), array('jquery'), null, true);

    wp_enqueue_script('slick-lightbox', get_module_js('theme/slick-lightbox.min.js'), array('slick', 'jquery'), dlv_get_ver(), true);
    wp_enqueue_script('sticky-kit', get_module_js('theme/jquery.sticky-kit.min.js'), array('jquery'), dlv_get_ver(), true);
    wp_enqueue_script('theme-common', get_module_js('theme/common.js'), array('slick', 'select2', 'jquery'), dlv_get_ver(), true);

	wp_localize_script('theme-common', 'ProRemont', array('ajax_url' => admin_url( 'admin-ajax.php')));
});

add_theme_support( 'post-thumbnails' );

add_image_size('pror-medium', 300, 300, true);

add_theme_support( 'html5', array(
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
) );

if( function_exists('acf_add_options_page') ) {
    $parent = acf_add_options_page(array(
		'page_title' 	=> 'Front Page Settings',
		'menu_title' 	=> 'Front Page Settings',
		'redirect' 		=> false
	));
}

add_filter('comment_form_default_fields', function($fields) {
    unset($fields['url']);
    unset($fields['author']);
    unset($fields['email']);

    return $fields;
});

add_filter('comment_form_defaults', function($defaults) {
    $defaults['must_log_in'] = '<p class="must-log-in">Только авторизированый пользователь может оставить отзыв.</p>';

    return $defaults;
}, 1, 5);

add_action('wp_footer', function() {
    echo '<!-- Page generated in ' . timer_stop() . ' seconds (' . get_num_queries() . ' queries). -->' . "\n";
}, 1000);


function pror_user_has_role($user_id, $role) {
    $user = get_user_by('id', $user_id);
    return $user && in_array($role, (array)$user->roles);
}

function pror_current_user_has_role($role) {
    $user = wp_get_current_user();
    return $user && pror_user_has_role($user->ID, $role);
}
