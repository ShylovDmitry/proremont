<?php

//add_action('save_post_master', function($post_ID, $post, $update) {
//    pror_master_clear_cache($post_ID);
//}, 10, 3);
//
//add_action('created_catalog_master', 'pror_master_clear_cache');
//add_action('edited_catalog_master', 'pror_master_clear_cache');
//add_action('delete_catalog_master', 'pror_master_clear_cache');
//
//add_action('created_location', 'pror_master_clear_cache');
//add_action('edited_location', 'pror_master_clear_cache');
//add_action('delete_location', 'pror_master_clear_cache');
//
//add_action('created_section', 'pror_master_clear_cache');
//add_action('edited_section', 'pror_master_clear_cache');
//add_action('delete_section', 'pror_master_clear_cache');
//
//
//add_action('wp_insert_comment', function($comment_ID, $comment) {
//    if (get_post_type($comment->comment_post_ID) == 'master') {
//        pror_master_clear_cache($comment->comment_post_ID);
//    }
//}, 10, 2);
//
//add_action('edit_comment', function($comment_ID, $comment) {
//    if (get_post_type($comment['comment_post_ID']) == 'master') {
//        pror_master_clear_cache($comment['comment_post_ID']);
//    }
//}, 10, 2);
//
//add_action('deleted_comment', function($comment_ID, $comment) {
//    if (get_post_type($comment->comment_post_ID) == 'master') {
//        pror_master_clear_cache($comment->comment_post_ID);
//    }
//}, 10, 2);
//
//add_action('wp_set_comment_status', function($comment_ID, $comment_status) {
//    $comment = get_comment($comment_ID);
//    if (get_post_type($comment->comment_post_ID) == 'master') {
//        pror_master_clear_cache($comment->comment_post_ID);
//    }
//}, 10, 2);
//
//
//function pror_master_clear_cache($post_ID = null) {
//    if ($post_ID) {
//        pror_cache_delete_wildcard('pror:master:post:id-' . $post_ID);
//        pror_cache_delete_wildcard('pror:comments:post:id-' . $post_ID);
//    } else {
//        pror_cache_delete_wildcard('pror:master:post');
//        pror_cache_delete_wildcard('pror:comments:post');
//    }
//    pror_cache_delete_wildcard('pror:master:list:front');
//    pror_cache_delete_wildcard('pror:master:list:main');
//    pror_cache_delete_wildcard('pror:master:list:related');
//}
