<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('catalog-master-common', get_module_css('catalog_master/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('catalog-master-common', get_module_js('catalog_master/common.js'), array('jquery'), dlv_get_ver(), true);
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
    $section = pror_detect_section();
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
