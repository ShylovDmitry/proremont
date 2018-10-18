<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('catalog-master-common', get_module_css('catalog_master/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('catalog-master-common', get_module_js('catalog_master/common.js'), array('jquery'), dlv_get_ver(), true);
});

add_filter('get_catalog_master', function($term, $taxonomy) {
    return pror_catalog_localize_term($term);
}, 10, 2);

add_filter('get_terms', function($terms, $taxonomy, $query_vars, $term_query) {
    if (in_array('catalog_master', $taxonomy)) {
        foreach ($terms as &$term) {
            if ($term instanceof WP_Term) {
                $term = pror_catalog_localize_term($term);
            }
        }
        unset($term);
    }

    return $terms;
}, 10, 4);

function pror_catalog_localize_term($term, $to_lang = null) {
    if (!$to_lang) {
        $to_lang = pll_current_language();
    }

    if ($to_lang != pll_default_language()) {
        $term->name = get_field("name_{$to_lang}", "term_{$term->term_id}");
        $term->slug = get_field("slug_{$to_lang}", "term_{$term->term_id}");
    }

    return $term;
}

add_filter('pll_translation_url', function($url, $lang) {
    if (!is_tax('catalog_master')) {
        return $url;
    }

    $taxonomy = 'catalog_master';
    $term = get_queried_object();

    $hierarchical_slugs = array();
    $ancestors = get_ancestors( $term->term_id, $taxonomy, 'taxonomy' );
    foreach ( (array)$ancestors as $ancestor ) {
        $ancestor_term = pror_find_term_by('id', $ancestor, pll_current_language(), $lang);
        $hierarchical_slugs[] = $ancestor_term->slug;
    }
    $hierarchical_slugs = array_reverse($hierarchical_slugs);
    $main_term = pror_find_term_by('id', $term->term_id, pll_current_language(), $lang);
    $hierarchical_slugs[] = $main_term->slug;

    array_splice($hierarchical_slugs, 0, 0, 'mastera');
    if ($lang != pll_default_language()) {
        array_splice($hierarchical_slugs, 0, 0, $lang);
    }

    return home_url(user_trailingslashit(implode('/', $hierarchical_slugs), 'category'));
}, 10, 2);

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

function pror_catalog_get_count($tax = null) {
    $section = pror_get_section();
    $locations = get_field('locations', $section);

    $default_tax = get_term(pll_get_term($tax->term_id, pll_default_language()));

    if ($default_tax) {
        $cat = array($default_tax->term_id);
        if ($default_tax->parent == 0) {
            $sub_taxes = get_terms(array(
                'parent' => $default_tax->term_id,
                'hierarchical' => false,
                'taxonomy' => 'catalog_master',
                'hide_empty' => false,
                'fields' => 'ids',
            ));
            $cat = array_merge($cat, $sub_taxes);
        }
    } else {
        $cat = get_terms(array(
            'hierarchical' => false,
            'taxonomy' => 'catalog_master',
            'hide_empty' => false,
            'fields' => 'ids',
        ));
    }

    $q = new WP_Query(array(
        'post_type' => 'master',
        'nopaging' => true,
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
