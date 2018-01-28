<?php

add_action('wp_update_nav_menu_item', function() {
    pror_cache_delete_wildcard('pror:theme:header');
    pror_cache_delete_wildcard('pror:theme:footer');
});

add_action('created_section', function() {
    pror_cache_delete_wildcard('pror:theme:header');
});
add_action('edited_section', function() {
    pror_cache_delete_wildcard('pror:theme:header');
});
add_action('delete_section', function() {
    pror_cache_delete_wildcard('pror:theme:header');
});

add_action('acf/update_value', function($value, $post_id, $field) {
    if ($field['name'] == 'frontpage_main_gallery') {
        pror_cache_delete_wildcard('pror:theme:gallery');
    }

    return $value;
}, 10, 3);
