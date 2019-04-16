<?php

add_action('save_post_partner', function($post_ID, $post, $update) {
    pror_partner_clear_cache($post_ID);
}, 10, 3);

add_action('created_catalog_master', 'pror_partner_clear_cache');
add_action('edited_catalog_master', 'pror_partner_clear_cache');
add_action('delete_catalog_master', 'pror_partner_clear_cache');

function pror_partner_clear_cache($post_ID = null) {
    if ($post_ID) {
	    wp_cache_delete($post_ID, 'pror:partner:post');
    } else {
        pror_cache_delete_wildcard('pror:partner:post');
    }
    pror_cache_delete_wildcard('pror:partner:list');
}

add_action('acf/update_value', function($value, $post_id, $field) {
    if ($field['name'] == 'frontpage_partners') {
        pror_cache_delete_wildcard('pror:partner:list');
    }

    return $value;
}, 10, 3);
