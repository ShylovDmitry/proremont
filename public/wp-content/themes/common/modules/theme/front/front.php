<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Roboto:100,300,400,700,900|Roboto+Condensed', array(), null);
    wp_enqueue_style('open-iconic', get_module_css('theme/open-iconic/css/open-iconic-bootstrap.min.css'), array(), '1.1.1');

    wp_enqueue_style('slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', array(), null);
    wp_enqueue_style('slick-theme', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css', array(), null);
    wp_enqueue_style('slick-lightbox', get_module_css('theme/slick-lightbox.css'), array(), dlv_get_ver());

    wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css', array(), null);
    wp_enqueue_style('theme-common', get_module_css('theme/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js', array('jquery'), null, true);

    wp_enqueue_script('slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array('jquery'), null, true);
    wp_enqueue_script('slick-lightbox', get_module_js('theme/slick-lightbox.min.js'), array('jquery', 'slick'), dlv_get_ver(), true);

    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'), null, true);
    wp_enqueue_script('theme-common', get_module_js('theme/common.js'), array('jquery', 'slick', 'select2'), dlv_get_ver(), true);
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
    return in_array($role, (array)$user->roles);
}

function pror_current_user_has_role($role) {
    $user = wp_get_current_user();
    return pror_user_has_role($user->ID, $role);
}
