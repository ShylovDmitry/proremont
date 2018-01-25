<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('catalog-master-common', get_module_css('catalog_master/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('catalog-master-common', get_module_js('catalog_master/common.js'), array('jquery'), dlv_get_ver(), true);
});


function pror_get_catalog($parent_id = 0, $hide_empty = true) {
    $terms = get_terms(array(
        'parent' => $parent_id,
        'hierarchical' => false,
        'taxonomy' => 'catalog_master',
        'hide_empty' => false,
        'meta_key' => 'sort',
        'orderby' => 'meta_value',
    ));
    if (!$hide_empty) {
        return $terms;
    }

    $non_empty_terms = array();
    foreach ($terms as $term) {
        if (pror_catalog_get_count($term) > 0) {
            $non_empty_terms[] = $term;
        }
    }
    return $non_empty_terms;

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
