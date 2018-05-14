<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:100,300,400,500,700,900|Roboto:100,300,400,500,700,900|Roboto+Condensed:700', array(), null);
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
    wp_enqueue_script('jquery', get_module_js('theme/jquery-3.3.1.min.js'), false, null, true);
}, 1);

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('popper', get_module_js('theme/popper-1.11.0.min.js'), array('jquery'), null, true);
    wp_enqueue_script('bootstrap', get_module_js('theme/bootstrap-4.0.0-beta.min.js'), array('popper', 'jquery'), null, true);
    wp_enqueue_script('slick', get_module_js('theme/slick-1.6.0.min.js'), array('jquery'), null, true);
    wp_enqueue_script('select2', get_module_js('theme/select2-4.0.3.min.js'), array('jquery'), null, true);
    wp_enqueue_script('blockadblock', get_module_js('theme/blockadblock-3.2.1.js'), array(), null, true);

    wp_enqueue_script('slick-lightbox', get_module_js('theme/slick-lightbox.min.js'), array('slick', 'jquery'), dlv_get_ver(), true);
    wp_enqueue_script('sticky-kit', get_module_js('theme/jquery.sticky-kit.min.js'), array('jquery'), dlv_get_ver(), true);
    wp_enqueue_script('theme-common', get_module_js('theme/common.js'), array('slick', 'select2', 'jquery'), dlv_get_ver(), true);

	wp_localize_script('theme-common', 'ProRemontObj', array('ajaxurl' => admin_url('admin-ajax.php'), 'postid' => get_the_ID()));
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

add_shortcode('clearfix', function() {
    return '<div class="clearfix"></div>';
});

add_action('wp_footer', function() {
    echo '<!-- Page generated in ' . timer_stop() . ' seconds (' . get_num_queries() . ' queries). -->' . "\n";
}, 1000);


function pror_user_has_role($roles, $user_id = null) {
    $user = $user_id ? get_user_by('id', $user_id) : wp_get_current_user();

    if (!$user) {
        return false;
    }

    foreach (explode(' ', $roles) as $role) {
        if (in_array($role, (array)$user->roles)) {
            return true;
        }
    }
    return false;
}

function pror_cache_expire($expire = 0) {
    return $expire ? $expire - time()%$expire : 0;
}

function pror_cache_key($key = null, $depends_str = '') {
    $depends = explode(',', $depends_str);
    if (empty($key)) {
        $key = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }

    if (in_array('section', $depends)) {
        $key .= '-' . pror_get_section()->slug;
    }

    foreach ($_COOKIE as $name => $value) {
        if (strpos($name, 'wordpress_logged_in_') === 0) {
            $user = wp_get_current_user();
            $key .= '-loggedin=' . (isset($user->roles[0]) ? $user->roles[0] : '_');

            break;
        }
    }

    return $key;
}

function pror_cache_delete_wildcard($group) {
    global $wp_object_cache;

    if (method_exists($wp_object_cache, 'get_mc')) {
        foreach ($wp_object_cache->get_mc('default')->getAllKeys() as $full_key) {
            if (strpos($full_key, ':' . $group . ':') !== false) {
                $key = end(explode(':', $full_key));

                $correct_group = substr($full_key, strpos($full_key, $group));
                $correct_group = str_replace(':' . $key, '', $correct_group);

                wp_cache_delete($key, $correct_group);
            }
        }
    }
}

add_filter('wp_get_attachment_image_attributes', function($attr, $attachment, $size) {
    if (isset($attr['pror_no_scrset']) && $attr['pror_no_scrset']) {
        unset($attr['srcset']);
        unset($attr['sizes']);
        unset($attr['pror_no_scrset']);
    }
    return $attr;
}, 11, 3);

function pror_declension_words($n, $words){
    return ($words[($n=($n=$n%100)>19?($n%10):$n)==1?0 : (($n>1&&$n<=4)?1:2)]);
}
