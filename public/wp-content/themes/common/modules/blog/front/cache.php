<?php

add_action('save_post_post', function($post_ID, $post, $update) {
    pror_blog_clear_cache($post_ID);
}, 10, 3);

add_action('created_category', 'pror_blog_clear_cache');
add_action('edited_category', 'pror_blog_clear_cache');
add_action('delete_category', 'pror_blog_clear_cache');

add_action('created_post_tag', 'pror_blog_clear_cache');
add_action('edited_post_tag', 'pror_blog_clear_cache');
add_action('delete_post_tag', 'pror_blog_clear_cache');

add_action('created_catalog_master', 'pror_blog_clear_cache');
add_action('edited_catalog_master', 'pror_blog_clear_cache');
add_action('delete_catalog_master', 'pror_blog_clear_cache');


add_action('wp_insert_comment', function($comment_ID, $comment) {
    if (get_post_type($comment->comment_post_ID) == 'post') {
        pror_blog_clear_cache($comment->comment_post_ID);
    }
}, 10, 2);

add_action('edit_comment', function($comment_ID, $comment) {
    if (get_post_type($comment['comment_post_ID']) == 'post') {
        pror_blog_clear_cache($comment['comment_post_ID']);
    }
}, 10, 2);

add_action('deleted_comment', function($comment_ID, $comment) {
    if (get_post_type($comment->comment_post_ID) == 'post') {
        pror_blog_clear_cache($comment->comment_post_ID);
    }
}, 10, 2);

add_action('wp_set_comment_status', function($comment_ID, $comment_status) {
    $comment = get_comment($comment_ID);
    if (get_post_type($comment->comment_post_ID) == 'post') {
        pror_blog_clear_cache($comment->comment_post_ID);
    }
}, 10, 2);


function pror_blog_clear_cache($post_ID = null) {
    if ($post_ID) {
        pror_cache_delete_wildcard('pror:blog:post:id-' . $post_ID);
        pror_cache_delete_wildcard('pror:comments:post:id-' . $post_ID);
    } else {
        pror_cache_delete_wildcard('pror:blog:post');
        pror_cache_delete_wildcard('pror:comments:post');
    }
    pror_cache_delete_wildcard('pror:blog:list:related');
    pror_cache_delete_wildcard('pror:blog:list:latest');
    pror_cache_delete_wildcard('pror:blog:list:latest-list');
    pror_cache_delete_wildcard('pror:blog:list:main');
}
