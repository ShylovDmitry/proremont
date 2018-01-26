<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('banner-common', get_module_css('banner/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('banner-common', get_module_js('banner/common.js'), array('jquery', 'sticky-kit'), dlv_get_ver(), true);
});

add_action('wp_head', function() {
    module_template('banner/adsense');
    module_template('banner/gpt');
});

function pror_banner_get_catalog() {
    if (is_tax('catalog_master')) {
        $tax = get_queried_object();

        if ($tax->parent == 0) {
            return array($tax->slug);
        } else {
            $parent_tax = get_term_by('id', $tax->parent, 'catalog_master');
            if ($parent_tax) {
                return array($parent_tax->slug);
            }
        }
    } else if (is_singular('master')) {
        $master = get_queried_object();

        return array_map(function($el) {
            return $el->slug;
        }, pror_get_master_catalogs($master->ID));
    } else if (is_singular('post')) {
        $post = get_queried_object();

        return array_map(function($el) {
            return $el->slug;
        }, pror_get_master_catalogs($post->ID));
    } else {
        return get_terms(array(
            'parent' => 0,
            'hierarchical' => false,
            'taxonomy' => 'catalog_master',
            'hide_empty' => false,
            'fields' => 'slugs',
        ));
    }
}

function pror_get_current_page_identifier() {
    if (is_front_page()) {
        return 'homepage';
    } else if (is_tax('catalog_master')) {
        return 'catalog_master';
    } else if (is_singular('master')) {
        return 'master';
    } else if (is_home()) {
        return 'blog';
    } else if (is_singular('post')) {
        return 'blog';
    } else {
        return '-';
    }
}
