<?php

add_action('wp_update_nav_menu_item', function() {
    pror_cache_delete_wildcard('pror:theme:header');
    pror_cache_delete_wildcard('pror:theme:footer');
});

add_action('profile_update', function() {
    pror_cache_delete_wildcard('pror:theme:header');
});
