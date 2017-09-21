<?php

function pror_catalog_get_main() {
    return get_terms(array(
        'parent' => 0,
        'hierarchical' => false,
        'taxonomy' => 'catalog_master',
        'hide_empty' => false,
    ));
}

function pror_catalog_get_sub($parent_id) {
    return get_terms(array(
        'parent' => $parent_id,
        'hierarchical' => false,
        'taxonomy' => 'catalog_master',
        'hide_empty' => false,
    ));
}

function pror_catalog_get_count($tax) {
    $section = pror_get_section();
    $locations = get_field('locations', $section);

    $cat = array($tax->term_id);
    if ($tax->parent == 0) {
        $sub_taxes = get_terms(array(
            'parent' => $tax->term_id,
            'hierarchical' => false,
            'taxonomy' => 'catalog_master',
            'hide_empty' => false,
            'fields' => 'ids',
        ));
        $cat = array_merge($cat, $sub_taxes);
    }

    $q = new WP_Query(array(
        'post_type' => 'master',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'location',
			    'terms' => $locations,
                'include_children' => false,
            ),
            array(
                'taxonomy' => 'catalog_master',
                'terms' => $cat,
                'include_children' => false,
            ),
        ),
    ));
    return $q->found_posts;
}
