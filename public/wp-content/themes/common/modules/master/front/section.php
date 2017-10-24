<?php

function pror_get_section() {
    $section = pror_get_section_by_slug(get_query_var('section'));
    if (!$section) {
        $section = pror_get_section_by_slug('kiev');
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
