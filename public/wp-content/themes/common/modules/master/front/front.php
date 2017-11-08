<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('master-common', get_module_css('master/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('master-common', get_module_js('master/common.js'), array('jquery'), dlv_get_ver(), true);
});

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

function pror_get_master_types() {
    return array(
        '' => 'Все',
        'master' => 'Мастера',
        'brіgada' => 'Бригады',
        'kompania' => 'Компании',
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
    $phone = preg_replace('/\s+/', '', $phone);

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
            $phone = sprintf('%s %s %s', $matches[2], $matches[3], $matches[4]);
        }
    }

    return array('tel' => $tel, 'text' => $phone);
}

function pror_get_master_location($master_post_id = null) {
    $term = get_the_terms($master_post_id, 'location');
    if (isset($term, $term[0])) {
        return trim(get_term_parents_list($term[0]->term_id, 'location', array(
            'separator' => ' / ',
            'link' => false
        )), '/ ');
    }

    return '-';
}

function pror_get_master_catalogs($master_id = null) {
    $master_terms = get_the_terms($master_id, 'catalog_master');

    $sub_terms = array();
    foreach ($master_terms as $master_term) {
        if ($master_term->parent) {
            if (!isset($sub_terms[$master_term->parent])) {
                $sub_terms[$master_term->parent] = array();
            }
            $sub_terms[$master_term->parent][] = $master_term;
        } else {
            $sub_terms[$master_term->term_id] = array();
        }
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

add_filter('comment_form_submit_button', function($submit_button, $args) {
    $submit_button = sprintf('<a href="%1$s" class="cancel-form">Отмена</a> ',
            wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
        ). $submit_button;
    return $submit_button;
}, 10, 2);

add_filter('get_comment_author_link', function($return, $author, $comment_ID) {
    // Remove link tag
    return $author;
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
    return $query->results ? $query->results : array(-999);
}

//add_filter('oa_social_login_filter_new_user_fields', function($user_fields) {
//    $user_fields['user_login'] = $user_fields['user_email'];
//    return $user_fields;
//});

