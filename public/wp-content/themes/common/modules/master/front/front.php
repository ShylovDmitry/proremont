<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('master-common', get_module_css('master/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('master-common', get_module_js('master/common.js'), array('jquery'), dlv_get_ver(), true);
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

function pror_get_section() {
    $section = pror_get_section_by_slug(get_query_var('section'));
    if (!$section) {
        $section = pror_get_section_by_slug('lvov');
    }
    return $section;
}

function pror_get_section_by_slug($slug) {
    return get_term_by('slug', $slug, 'section');
}

function pror_get_section_by_id($id) {
    return get_term_by('id', $id, 'section');
}

function pror_get_section_by_location_id($location_id) {
    $sections = get_terms(array(
        'taxonomy' => 'section',
        'hide_empty' => false,
    ));

    foreach ($sections as $section) {
        if (in_array($location_id, get_field('locations', $section))) {
            return $section;
        }
    }

    return null;
}

function pror_format_phones($phones_str) {
    $phones_str = str_replace(chr(13), '', $phones_str);
    $phones = explode("\n", $phones_str);
    return array_map(function($phone) {
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
            $tel = '+' . $phone;
            if (preg_match('/(\d{2})(\d{3})(\d{3})(\d{4})/', $phone, $matches)) {
                $phone = sprintf('+%s (%s) %s %s', $matches[1], $matches[2], $matches[3], $matches[4]);
            }
        } else {
            $tel = $phone;
        }

        return array('tel' => $tel, 'text' => $phone);
    }, $phones);
}

function pror_get_master_location($master_id = null) {
    $term = get_the_terms($master_id, 'location');
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
    return $author;
}, 10, 3);
