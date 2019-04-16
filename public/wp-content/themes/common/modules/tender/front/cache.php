<?php

add_action('save_post_tender', function($post_ID, $post, $update) {
    pror_tender_clear_cache($post_ID);
}, 10, 3);

add_action('created_catalog_master', 'pror_tender_clear_cache');
add_action('edited_catalog_master', 'pror_tender_clear_cache');
add_action('delete_catalog_master', 'pror_tender_clear_cache');

add_action('created_section', 'pror_tender_clear_cache');
add_action('edited_section', 'pror_tender_clear_cache');
add_action('delete_section', 'pror_tender_clear_cache');


function pror_tender_clear_cache($post_ID = null) {
    if ($post_ID) {
	    wp_cache_delete($post_ID, 'pror:tender:post');
    } else {
        pror_cache_delete_wildcard('pror:tender:post');
    }
    pror_cache_delete_wildcard('pror:tender:list');
}




add_action('save_post_tender_response', function($post_ID, $post, $update) {
	$tender_id = get_field('tender_id', $post_ID);

	pror_tender_responses_clear_cache($tender_id);
}, 10, 3);

function pror_tender_responses_clear_cache($post_ID = null) {
	wp_cache_delete($post_ID, 'pror:tender:responses');
}



