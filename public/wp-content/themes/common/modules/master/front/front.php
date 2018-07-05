<?php

__('Мастер', 'common');
__('Бригада', 'common');
__('Компания', 'common');

add_action('wp_print_styles', function () {
    wp_enqueue_style('master-common', get_module_css('master/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    if (get_post_type() == 'master') {
        wp_enqueue_script('master-common', get_module_js('master/common.js'), array('jquery'), dlv_get_ver(), true);
    }
});

add_action('comment_rating_field_pro_rating_input_updated_post_rating', function ($post_id, $totalRatings, $averageRatings, $commentsWithARating, $countRatings, $averageRating, $ratingSplit, $ratingSplitPercentages) {
    $n = $commentsWithARating * 3 * 5;
    $pos = is_array($totalRatings) ? array_sum($totalRatings) : 0;

    if ($n == 0) return 0;

    $z = 1.96;
    $phat = 1.0 * $pos / $n;
    $rating = ($phat + $z * $z / (2 * $n) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $n)) / $n)) / (1 + $z * $z / $n);

    update_post_meta($post_id, 'pror-crfp-lower-bound', $rating);

    return true;
}, 10, 8);

add_action('pre_get_posts', function($query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_tax('catalog_master')) {
        return;
    }

    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'DESC');
    $query->set('meta_query', array(
        'relation' => 'OR',
        array(
            'key' => 'pror-crfp-lower-bound',
            'compare' => 'NOT EXISTS',
        ),
        array(
            'key' => 'pror-crfp-lower-bound',
            'compare' => 'EXISTS',
        ),
    ));

    $query->set('lang', '');

    return $query;
});

add_filter('get_terms_args', function($args, $taxonomies) {
    if (!isset($args['lang'])) {
        $args['lang'] = '';
    }

    return $args;
}, 10, 2);



add_action('wpseo_register_extra_replacements', function() {
    wpseo_register_var_replacement('%%master_type%%', function() {
        if (get_post_type() == 'master') {
            return get_field('master_type', "user_" . get_post_field('post_author'));
        }
        return '';
    });

    wpseo_register_var_replacement('%%city%%', function() {
        if (get_post_type() == 'master') {
            $terms = get_the_terms(null, 'location');
            if (isset($terms, $terms[0])) {
                return $terms[0]->name;
            }
        }
        return '';
    });

    wpseo_register_var_replacement('%%catalogs%%', function() {
        $catalogs = array();
        if (get_post_type() == 'master') {
            foreach (pror_get_master_catalogs() as $pos => $parent) {
                $catalogs[] = $parent->name;
                foreach ($parent->children as $child) {
                    $catalogs[] = $child->name;
                }
            }
        }
        return implode(', ', $catalogs);
    });
});


add_filter('excerpt_length', function( $length ) {
    return 20;
}, 999);

function pror_is_master_published($user_id = null) {
    return pror_get_master_post_id($user_id);
}

function pror_get_master_types() {
    return array(
        '' => __('Все', 'common'),
        'master' => __('Мастера', 'common'),
        'brigada' => __('Бригады', 'common'),
        'kompania' => __('Компании', 'common'),
    );
}

function pror_get_master_phones($user_id) {
    $master_phones = get_field('master_phones', "user_{$user_id}");

    $phones = array();
    foreach ($master_phones as $master_phone) {
        $phones[] = pror_format_phones($master_phone['tel']);
    }

    return $phones;
}

function pror_format_phones($phone) {
//    $phones_str = str_replace(chr(13), '', $phones_str);
//    $phones = explode("\n", $phones_str);
    $phone = preg_replace('/[\s-)(]+/', '', $phone);

    if (strlen($phone) == 9) {
        $phone = '380' . $phone;
    }
    if (strlen($phone) == 10) {
        $phone = '38' . $phone;
    }
    if (strlen($phone) == 11) {
        $phone = '3' . $phone;
    }
    if (strlen($phone) == 12) {
        $phone = '+' . $phone;
    }

    $tel = $phone;
    if (strlen($phone) == 13) {
        if (preg_match('/\+(\d{2})(\d{3})(\d{3})(\d{4})/', $phone, $matches)) {
            $phone = sprintf('(%s) %s %s', $matches[2], $matches[3], $matches[4]);
        }
    }

    return array('tel' => $tel, 'text' => $phone);
}

function pror_get_master_location($master_post_id = null) {
    $term = get_the_terms($master_post_id, 'location');
    if (!is_wp_error($term) && isset($term, $term[0])) {
        $location_str = trim(get_term_parents_list($term[0]->term_id, 'location', array(
            'separator' => '/',
            'link' => false
        )), '/');
        return explode('/', $location_str);
    }

    return array();
}

function pror_get_master_section($master_post_id = null) {
    $term = get_the_terms($master_post_id, 'location');
    if (!is_wp_error($term) && isset($term, $term[0])) {
        return pror_get_section_by_location_id($term[0]->term_id);
    }

    return '';
}

function pror_get_master_catalogs($master_post_id = null) {
    $master_terms = get_the_terms($master_post_id, 'catalog_master');

    $sub_terms = array();
    foreach ($master_terms as $master_term) {
        if ($master_term->parent) {
            if (!isset($sub_terms[$master_term->parent])) {
                $sub_terms[$master_term->parent] = array();
            }
            $sub_terms[$master_term->parent][] = $master_term;
        }
    }

    if (empty($sub_terms)) {
        return [];
    }

    $parent_terms = get_terms(array(
        'term_taxonomy_id' => array_keys($sub_terms),
        'hierarchical' => false,
        'taxonomy' => 'catalog_master',
        'hide_empty' => false,
        'meta_key' => 'sort',
        'orderby' => 'meta_value',
    ));


    foreach ($parent_terms as &$parent_term) {
        $parent_term->children = $sub_terms[$parent_term->term_id];
    }
    unset($parent_term);

    return $parent_terms;

}

function pror_get_master_img_alt() {
    $catalogs = array_map(function($el) {
        return $el->name;
    }, pror_get_master_catalogs());

    return sprintf('%s - %s - %s', implode(', ', $catalogs), end(pror_get_master_location()), get_the_title());
}

add_filter('comment_form_submit_button', function($submit_button, $args) {
    $submit_button = sprintf('<a href="%1$s" class="cancel-form">Отмена</a> ',
            wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
        ). $submit_button;
    return $submit_button;
}, 10, 2);

add_filter('get_comment_author_link', function($return, $author, $comment_ID) {
    return str_replace(' rel=', 'target="_blank" rel=', $return);
}, 10, 3);


function pror_get_query_pro_master_ids() {
    $query = new WP_User_Query(array(
        'role' => 'master',
        'fields' => 'ID',
        'meta_query' => array(
            array(
                'key' => 'master_location',
                'value' => get_field('locations', pror_get_section()),
                'compare' => 'IN',
            ),
            array(
                'key' => 'master_is_pro',
                'value' => '1',
            ),
        ),
    ));
    return $query->results ? $query->results : array(-1);
}


add_filter('acf/update_value/key=field_59ebc80ea9687', function($value, $post_id, $field) {
    $formatted = pror_format_phones(preg_replace('/\D+/', '', $value));
    return $formatted['tel'];
}, 10, 3);

add_filter('acf/load_value/key=field_59ebc80ea9687', function($value, $post_id, $field) {
    $formatted = pror_format_phones($value);
    return $formatted['text'];
}, 10, 3);


add_filter('acf/update_value/key=field_5a967ee9592b1', function($value, $post_id, $field) {
    $formatted = pror_format_phones(preg_replace('/\D+/', '', $value));
    return $formatted['tel'];
}, 10, 3);

add_filter('acf/load_value/key=field_5a967ee9592b1', function($value, $post_id, $field) {
    $formatted = pror_format_phones($value);
    return $formatted['text'];
}, 10, 3);


add_filter('login_headerurl', function($login_header_url) {
    return home_url();
});

add_filter('login_headertitle', function() {
    if ($_GET['action'] == 'register' || $_GET['checkemail'] == 'registered') {
        return 'Регистрация';
    }
    if ($_GET['action'] == 'lostpassword') {
        return 'Востановление пароля';
    }
    if ($_GET['action'] == 'rp') {
        return 'Установка нового пароля';
    }
    return 'Вход';
});

add_action('login_header', function() {
    if ($_GET['checkemail'] == 'registered') {
        echo <<< "HTML"
<style>
#loginform {display: none;}
</style>
HTML;
    }
});
