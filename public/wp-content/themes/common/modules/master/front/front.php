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
