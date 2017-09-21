<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('banner-common', get_module_css('banner/common.css'), array(), dlv_get_ver());
});

function pror_adrotate_group_by_name($name) {
    global $wpdb;

    $section_name = sprintf('%s_%s', pror_get_section()->slug, $name);
    $group_id = $wpdb->get_var("SELECT id FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` = '{$section_name}';");
    if ($group_id) {
        $group_output = adrotate_group($group_id);
        $group_output = str_replace("g g-", "g g-{$name} g-{$section_name} g-", $group_output);
        return $group_output;
    }

    $group_id = $wpdb->get_var("SELECT id FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` = '{$name}';");
    if ($group_id) {
        $group_output = adrotate_group($group_id);
        $group_output = str_replace("g g-", "g g-{$name} g-", $group_output);
        return $group_output;
    }

    return '';
}
