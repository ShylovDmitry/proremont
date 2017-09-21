<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('theme-common', get_module_css('theme/common.css'), array(), dlv_get_ver());
    wp_enqueue_style('theme-slick-lightbox', get_module_css('theme/slick-lightbox.css'), array(), dlv_get_ver());
    wp_enqueue_style('theme-open-iconic', get_module_css('theme/open-iconic/css/open-iconic-bootstrap.min.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('theme-common', get_module_js('theme/common.js'), array('jquery'), dlv_get_ver(), true);
    wp_enqueue_script('theme-slick-lightbox', get_module_js('theme/slick-lightbox.min.js'), array('jquery'), dlv_get_ver(), true);
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
    $defaults['must_log_in'] = '<p class="must-log-in">Только авторизированый пользователь может оставить коментарий.</p>';

    return $defaults;
}, 1, 5);

add_action('wp_footer', function() {
    echo '<!-- Page generated in ' . timer_stop() . ' seconds (' . get_num_queries() . ' queries). -->' . "\n";
}, 1000);



//add_filter('rocket_buffer', function($buffer) {
//    $buffer = str_replace('<script src=', '<script async src=', $buffer);
//
//    preg_match_all( '/<link\s*.+href=[\'|"]([^\'|"]+\.css?.+)[\'|"](.+)>/iU' , $buffer, $tags_match );
//    $i=0;
//    foreach ( $tags_match[0] as $tag ) {
//        $css_url = set_url_scheme( $tags_match[1][ $i ] );
//        $css_filename = str_replace(home_url(), APP_PATH, $css_url);
//
//        if (file_exists($css_filename)) {
//            $buffer = str_replace( $tag, '', $buffer );
//            $buffer = str_replace( '</title>', '</title><style>'.file_get_contents($css_filename).'</style>', $buffer );
//        }
//
//        $i++;
//    }
//
//    return $buffer;
//}, PHP_INT_MAX);
