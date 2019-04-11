<?php

add_filter('posts_clauses', function($clauses, $query) {
    if (is_admin() || (!$query->is_main_query() && $query->query['post_type'] != 'master')) {
        return $clauses;
    }

    global $wpdb;

    if ($query->is_tax('catalog_master') && isset($_GET['mtype']) && $_GET['mtype']) {
        $join = &$clauses['join'];
        if (!empty($join)) $join .= ' ';
        $join .= "JOIN {$wpdb->prefix}usermeta custom_um ON custom_um.user_id = {$wpdb->posts}.post_author AND custom_um.meta_key = 'master_type'";

        $where = &$clauses['where'];
        $where .= " AND custom_um.meta_value = '" . esc_sql($_GET['mtype']) . "'";
    }

    if (isset($query->query['custom_query'])) {
        if ($query->query['custom_query'] == 'with_logo') {
            $join = &$clauses['join'];
            if (!empty($join)) $join .= ' ';
            $join .= "JOIN {$wpdb->prefix}usermeta custom_um_logo ON custom_um_logo.user_id = {$wpdb->posts}.post_author AND custom_um_logo.meta_key = 'master_logo'";

            $where = &$clauses['where'];
            $where .= " AND custom_um_logo.meta_value != ''";
        }
    }

    return $clauses;
}, 10, 2);

add_action('pre_get_posts', function($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_tax('catalog_master')) {
        $query->set('tax_query', array(
            array(
                'taxonomy' => 'location',
                'terms' => get_field('locations', pror_detect_section()),
                'include_children' => false,
                'operator' => 'IN',
            )
        ));
    }
});
