<?php
/**
 * ProRemont Stats
 *
 * Plugin Name: ProRemont Stats
 * Description: Collect stats.
 * Version:     0.1
 */

defined( 'ABSPATH' ) or die();

register_activation_hook(__FILE__, 'pror_stats_install');
register_deactivation_hook(__FILE__, 'pror_stats_uninstall');

function pror_stats_install() {
    global $wpdb;

	$table_name = $wpdb->prefix . 'pror_stats';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
        id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name varchar(255) NOT NULL,
		user_id int(10) UNSIGNED NOT NULL,
		post_id int(10) UNSIGNED NOT NULL,
		PRIMARY KEY (id)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

function pror_stats_uninstall() {
    // Do nothing
}

function pror_stats_track_event($type, $post_id) {
    global $wpdb;

	$table_name = $wpdb->prefix . 'pror_stats';

    return $wpdb->insert($table_name,
        array(
            'time' => current_time('mysql', true),
            'name' => $type,
            'user_id' => get_current_user_id(),
            'post_id' => $post_id,
        ),
        array(
            '%s',
            '%s',
            '%d',
            '%d',
        )
    );
}

function pror_stats_get_period($type, $post_id, $period_in_days = 30) {
    global $wpdb;

	$table_name = $wpdb->prefix . 'pror_stats';

    return $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(id) FROM $table_name WHERE time >= %s AND name = %s AND post_id = %d", array(
            date_i18n('Y-m-d H:i:s', strtotime("-{$period_in_days} days"), true),
            $type,
            $post_id
        ))
    );
}

function pror_stats_get_top_period($type, $period_in_days = 30) {
    global $wpdb;

	$table_name = $wpdb->prefix . 'pror_stats';

	$where_section = '';
	if ($_GET['section']) {
	    $locations = get_term_meta($_GET['section'], 'locations');
	    if ($locations && $locations[0]) {
	        $locations_str = implode(',', $locations[0]);
            $where_section = " AND um_section.meta_value IN ({$locations_str})";
        }
    }

	$where_catalog = '';
	if ($_GET['catalog']) {
        $catalog_ids = [$_GET['catalog']];

	    $main = get_term($_GET['catalog'], 'catalog_master');
	    if ($main->parent == 0) {
            $catalog_ids += get_terms([
                'taxonomy' => 'catalog_master',
                'hide_empty' => 0,
                'fields' => 'ids',
                'parent' => $_GET['catalog'],
            ]);
        }

        $catalog_conds = [];
        foreach ($catalog_ids as $catalog_id) {
            $catalog_conds[] = "um_catalog.meta_value LIKE '%\"{$catalog_id}\"%'";
        }

        if ($catalog_conds) {
            $where_catalog = " AND (" . implode(' OR ', $catalog_conds) . ")";
        }
    }

    $time = date_i18n('Y-m-d H:i:s', strtotime("-{$period_in_days} days"), true);

    $sql = "SELECT ps.post_id, COUNT(ps.id) page_view_count FROM $table_name ps
        LEFT JOIN wp_posts p ON p.ID = ps.post_id
        LEFT JOIN wp_usermeta um_section ON um_section.user_id = p.post_author AND um_section.meta_key = 'master_location'
        LEFT JOIN wp_usermeta um_catalog ON um_catalog.user_id = p.post_author AND um_catalog.meta_key = 'master_catalog'
        WHERE ps.time >= '{$time}' AND ps.name = '{$type}'{$where_section}{$where_catalog}
        GROUP BY ps.post_id ORDER BY page_view_count DESC LIMIT 100";

    return $wpdb->get_results(
        $sql
    );
}


add_action('admin_menu', function() {
    add_submenu_page('edit.php?post_type=master', 'Master Top', 'Top', 'manage_options', 'master-top', 'pror_stats_display_admin_page' );
});

function pror_stats_display_admin_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}


	if ($_GET['period'] == '7d') {
	    $period = 7;
    } else {
        $period = 30;
    }
    $res = pror_stats_get_top_period('master_page_view', $period);

	$section_dropdown = wp_dropdown_categories([
	    'show_option_all' => 'All',
	    'echo' => 0,
	    'hide_empty' => 0,
        'name' => 'section',
	    'taxonomy' => 'section',
        'selected' => $_GET['section'],
    ]);

	$catalog_dropdown = wp_dropdown_categories([
	    'show_option_all' => 'All',
	    'echo' => 0,
	    'hide_empty' => 0,
        'hierarchical' => true,
        'name' => 'catalog',
	    'taxonomy' => 'catalog_master',
        'selected' => $_GET['catalog'],
    ]);

	$period_selected_7d = ($_GET['period'] == '7d') ? ' selected' : '';
	$period_selected_30d = ($_GET['period'] == '30d') ? ' selected' : '';

	echo <<<"EOF"
<div class="wrap">
<h1>Master Top</h1>

<form id="posts-filter" action="" method="get" style="margin-bottom: 5px;">
    <input type="hidden" name="post_type" value="master" />
    <input type="hidden" name="page" value="master-top" />
    
    {$section_dropdown}
    {$catalog_dropdown}
    
    <select name="period">
        <option value="30d"{$period_selected_30d}>30 дней</option>
        <option value="7d" {$period_selected_7d}>7 дней</option>
    </select>
    
    <input type="submit" value="Фильтр" class="button" />
</form>

<table class="wp-list-table widefat fixed striped posts">
    <thead>
        <tr>
            <td class="manage-column">Name</td>
            <td class="manage-column" width="100">Page View</td>
            <td class="manage-column" width="100">Show Phone</td>
            <td class="manage-column" width="100">Conversion</td>
            <td class="manage-column" width="30">Edit</td>
        </tr>
    </thead>
    <tbody>
EOF;
    foreach ($res as $r) {
        $post = get_post($r->post_id);
        $is_pro = get_field('master_is_pro', 'user_'.$post->post_author);

        $name = get_the_title($r->post_id);
        $link = get_permalink($r->post_id);
        $edit_link = get_edit_post_link($r->post_id);
        $show_phone_count = pror_stats_get_period('master_show_phone', $r->post_id, $period);
        $c = round(100*$show_phone_count/$r->page_view_count, 2);

        $pro_str = $is_pro ? "<span style='background:#E67E22; color:#fff; font-weight:900; font-size:75%; padding:2px 4px; border-radius:2px;'>PRO</span> " : '';
        echo <<<"EOF"
            <tr>
                <td class="manage-column">{$pro_str}<a href="{$link}" target="_blank">{$name}</a></td>
                <td class="manage-column">{$r->page_view_count}</td>
                <td class="manage-column">{$show_phone_count}</td>
                <td class="manage-column">{$c}%</td>
                <td class="manage-column"><a href="{$edit_link}"><span class="dashicons-before dashicons-admin-generic"></span></a></td>
            </tr>
EOF;
    }

    echo <<<"EOF"
    </tbody>
</table>
</div>
EOF;
}
