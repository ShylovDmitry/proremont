<?php

add_filter('request', function($query_vars) {
    if (is_admin()) {
        return $query_vars;
    }


    if (isset($query_vars['catalog_master']) && $query_vars['lang'] != pll_default_language()) {
        $parts = explode('/', $query_vars['catalog_master']);
        $new_parts = [];

        foreach ($parts as $part) {
            $term = pror_find_term_by('slug', $part, 'catalog_master', $query_vars['lang'], pll_default_language());
            if (!$term) {
                $new_parts = $parts;
                break;
            }

            $new_parts[] = $term->original_slug;
        }

        $query_vars['catalog_master'] = implode('/', $new_parts);
    }


    if (isset($query_vars['category_name']) && $query_vars['lang'] != pll_default_language()) {
        $parts = explode('/', $query_vars['category_name']);
        $new_parts = [];

        foreach ($parts as $part) {
            $term = pror_find_term_by('slug', $part, 'category', $query_vars['lang'], pll_default_language());
            if (!$term) {
                $new_parts = $parts;
                break;
            }

            $new_parts[] = $term->original_slug;
        }

        $query_vars['category_name'] = implode('/', $new_parts);
    }

    return $query_vars;
});

function pror_find_term_by($field, $value, $taxonomy, $from_lang, $to_lang) {
    if (!in_array($field, ['id', 'slug', 'name'])) {
        return false;
    }

    if ($field == 'id') {
        $args = [
            'number' => 1,
            'suppress_filter' => true,
            'include' => (array) $value,
        ];
    } else if ($from_lang == pll_default_language()) {
        $args = [
            'taxonomy' => $taxonomy,
            'number' => 1,
            'suppress_filter' => true,
            "{$field}" => $value,
        ];
    } else {
        $args = [
            'taxonomy' => $taxonomy,
            'number' => 1,
            'suppress_filter' => true,
            'meta_query' => [
                [
                    'key' => "{$field}_{$from_lang}",
                    'value' => $value,
                ]
            ],
        ];
    }

    $terms = get_terms($args);
    if (!$terms || !isset($terms[0])) {
        return false;
    }

    return pror_localize_term($terms[0], $to_lang);
}


add_filter('term_link', function($termlink, $term, $taxonomy) {
    if (is_admin()) {
        return $termlink;
    }

    if (in_array($taxonomy, ['category', 'catalog_master'])) {
        if (pll_default_language() != pll_current_language() && strpos('/' . pll_current_language() . '/', $termlink) === false) {
            $path = parse_url($termlink, PHP_URL_PATH);
            $termlink = str_replace($path, '/' . pll_current_language() . $path, $termlink);
        }
    }
    return $termlink;
}, 100, 3);

add_filter('get_term', function($term, $taxonomy) {
    if (is_admin()) {
        return $term;
    }
    $taxonomy = $taxonomy ? $taxonomy : $term->taxonomy;

    if (in_array($taxonomy, ['category', 'catalog_master'])) {
        return pror_localize_term($term);
    }

    return $term;
}, 10, 2);

add_filter('get_terms', function($terms, $taxonomy, $query_vars, $term_query) {
    if (is_admin()) {
        return $terms;
    }

    if (in_array('catalog_master', $taxonomy)) {
        foreach ($terms as &$term) {
            if ($term instanceof WP_Term) {
                $term = pror_localize_term($term);
            }
        }
        unset($term);
    }

    return $terms;
}, 10, 4);

function pror_localize_term($term, $to_lang = null) {
    if (!$to_lang) {
        $to_lang = pll_current_language();
    }

    if (!$term->original_name) {
        $term->original_name = $term->name;
        $term->original_slug = $term->slug;
        $term->original_description = $term->description;
    }

    if ($to_lang != pll_default_language()) {
        $term->name = get_field("name_{$to_lang}", "term_{$term->term_id}");
        $term->slug = get_field("slug_{$to_lang}", "term_{$term->term_id}");
        $term->description = get_field("description_{$to_lang}", "term_{$term->term_id}");
    } else {
        if ($term->original_name) {
            $term->name = $term->original_name;
            $term->slug = $term->original_slug;
            $term->description = $term->original_description;
        }
    }

    return $term;
}

add_filter('pll_translation_url', function($url, $lang) {
    $taxonomy = false;
    if (is_tax('catalog_master')) {
        $taxonomy = 'catalog_master';
    }
    if (is_category()) {
        $taxonomy = 'category';
    }

    if (!$taxonomy) {
        return $url;
    }

    $taxonomy = 'catalog_master';
    $term = get_queried_object();

    $ancestors = get_ancestors( $term->term_id, $taxonomy, 'taxonomy' );
    foreach ( (array)$ancestors as $ancestor ) {
        $ancestor_term = pror_find_term_by('id', $ancestor, $taxonomy, pll_current_language(), pll_current_language());
        $ancestor_new = pror_find_term_by('id', $ancestor, $taxonomy, pll_current_language(), $lang);
        $url = str_replace('/' . $ancestor_term->slug . '/', '/' . $ancestor_new->slug . '/', $url);
    }

    $main_term = pror_find_term_by('id', $term->term_id, $taxonomy, pll_current_language(), $lang);
    $url = str_replace('/' . $term->slug . '/', '/' . $main_term->slug . '/', $url);

    return $url;
}, 10, 2);
