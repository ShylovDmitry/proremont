<?php

add_action('created_section', 'pror_searchbox_clear_cache');
add_action('edited_section', 'pror_searchbox_clear_cache');
add_action('delete_section', 'pror_searchbox_clear_cache');

add_action('created_catalog_master', 'pror_searchbox_clear_cache');
add_action('edited_catalog_master', 'pror_searchbox_clear_cache');
add_action('delete_catalog_master', 'pror_searchbox_clear_cache');


function pror_searchbox_clear_cache() {
    pror_cache_delete_wildcard('pror:searchbox:form');
    pror_cache_delete_wildcard('pror:searchbox:data');
}
