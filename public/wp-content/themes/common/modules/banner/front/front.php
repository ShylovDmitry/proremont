<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('banner-common', get_module_css('banner/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('banner-common', get_module_js('banner/common.js'), array('jquery', 'sticky-kit'), dlv_get_ver(), true);
});

function pror_adrotate_group_by_name($name, $section, $catalog) {
    global $wpdb;

    $section_name = sprintf('%s_%s', $name, $section);
    $group_id = $wpdb->get_var("SELECT id FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` = '{$section_name}';");

    if ($group_id) {
        $catalog_str = implode('|', $catalog);

        $group_output = adrotate_group("$group_id,ad_catalog($catalog_str)");
        if (preg_replace('/<!--(.|\s)*?-->/', '', $group_output . $group_output) != '') {
            $group_output = str_replace("g g-", "g g-{$name} g-{$section_name} g-", $group_output);
            return $group_output;
        }
    }

    $group_id = $wpdb->get_var("SELECT id FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` = '{$name}';");
    if ($group_id) {
//        $catalog_str = implode('|', $catalog);

//        $group_output = adrotate_group("$group_id,ad_catalog($catalog_str)");
        $group_output = adrotate_group($group_id);
        $group_output = str_replace("g g-", "g g-{$name} g-{$section_name} g-", $group_output);
        return $group_output;
    }

    return '';
}

add_filter('query', function($query) {
    global $wpdb;

    if (strpos($query, " OR `{$wpdb->prefix}adrotate_linkmeta`.`group` = ad_catalog") > 0) {

        preg_match("/ `{$wpdb->prefix}adrotate_linkmeta`\.`group` = ad_catalog\(([^\)]*)\)/i", $query, $matches);
        if (isset($matches[1])) {
            $catalog = explode('|', $matches[1]);
            $group_ids = $wpdb->get_col(
                sprintf("SELECT id FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` IN (%s);",
                    '"' . implode('", "', $catalog) . '"')
            );

            if ($group_ids) {
                $group_ids_str = implode(',', $group_ids);
                $query = preg_replace(
                    "/ OR `{$wpdb->prefix}adrotate_linkmeta`.`group` = ad_catalog\(([^\)]*)\)/i",
                    " AND `pror_adrotate_linkmeta`.`group` IN ({$group_ids_str})",
                    $query
                );
            } else {
                $query = preg_replace(
                    "/ OR `{$wpdb->prefix}adrotate_linkmeta`.`group` = ad_catalog\(([^\)]*)\)/i",
                    " ",
                    $query
                );
            }

            $query = preg_replace(
                "/`wp_adrotate_linkmeta`[\s]+WHERE/i",
                " `wp_adrotate_linkmeta`, `wp_adrotate_linkmeta` `pror_adrotate_linkmeta` WHERE `wp_adrotate`.`id` = `pror_adrotate_linkmeta`.`ad` AND ",
                $query
            );
        }
    }

    return $query;
});

function pror_banner_get_catalog() {
    if (is_tax('catalog_master')) {
        $tax = get_queried_object();

        if ($tax->parent == 0) {
            return array($tax->slug);
        } else {
            $parent_tax = get_term_by('id', $tax->parent, 'catalog_master');
            if ($parent_tax) {
                return array($parent_tax->slug);
            }
        }
    } else if (is_singular('master')) {
        $master = get_queried_object();

        return array_map(function($el) {
            return $el->slug;
        }, pror_get_master_catalogs($master->ID));
    } else {
        return get_terms(array(
            'parent' => 0,
            'hierarchical' => false,
            'taxonomy' => 'catalog_master',
            'hide_empty' => false,
            'fields' => 'slugs',
        ));
    }
}
