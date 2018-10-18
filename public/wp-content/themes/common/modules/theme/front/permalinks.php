<?php

add_filter('request', function($query_vars) {
    if (is_admin()) {
        return $query_vars;
    }



    if (isset($query_vars['catalog_master']) && $query_vars['lang'] != pll_default_language()) {
        $parts = explode('/', $query_vars['catalog_master']);
        $new_parts = [];

        foreach ($parts as $part) {
            $term = pror_find_term_by('slug', $part, $query_vars['lang'], pll_default_language());
            if (!$term) {
                $new_parts = $parts;
                break;
            }

            $new_parts[] = $term->slug;
        }

        $query_vars['catalog_master'] = implode('/', $new_parts);
    }



    $p_url = parse_url($_SERVER['REQUEST_URI']);
    $p_url['query'] = isset($p_url['query']) ? $p_url['query'] : '';
    parse_str($p_url['query'], $q_url);

    if (isset($_GET['f_master_type']) && empty($_GET['f_master_type'])) {
        unset($q_url['f_master_type']);
    }

    $new_url = $p_url['path'] . (empty($q_url) ? '' : '?' . http_build_query($q_url));
    if ($new_url != $_SERVER['REQUEST_URI']) {
        wp_redirect($new_url);
        exit;
    }

    return $query_vars;
});


function pror_find_term_by($field, $value, $from_lang, $to_lang) {
    if (!in_array($field, ['id', 'slug', 'name'])) {
        return false;
    }

    if ($field == 'id') {
        $args = [
            'number' => 1,
            'suppress_filter' => true,
            'include' => [$value],
        ];
    } else if ($from_lang == pll_default_language()) {
        $args = [
            'taxonomy' => 'catalog_master',
            'number' => 1,
            'suppress_filter' => true,
            "{$field}" => $value,
        ];
    } else {
        $args = [
            'taxonomy' => 'catalog_master',
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

    return pror_catalog_localize_term($terms[0], $to_lang);
}
