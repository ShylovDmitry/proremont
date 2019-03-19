<?php

add_action('save_post_page', function($post_ID, $post, $update) {
    if ($post->post_name == 'catalog') {
        pror_cache_delete_wildcard('pror:catalog_master:page');
    }
}, 10, 3);

add_action('created_catalog_master', 'pror_catalog_master_clear_cache');
add_action('edited_catalog_master', 'pror_catalog_master_clear_cache');
add_action('delete_catalog_master', 'pror_catalog_master_clear_cache');

add_action('acf/update_value', function($value, $post_id, $field) {
    if ($field['name'] == 'frontpage_catalogs') {
        pror_cache_delete_wildcard('pror:catalog_master:frontpage');
    }

    return $value;
}, 10, 3);


function pror_catalog_master_clear_cache() {
    pror_cache_delete_wildcard('pror:catalog_master:list');
    pror_cache_delete_wildcard('pror:catalog_master:page');
    pror_cache_delete_wildcard('pror:catalog_master:frontpage');
}
