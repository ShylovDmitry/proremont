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
            'post_id' => $post_id,
        ),
        array(
            '%s',
            '%s',
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

    return $wpdb->get_results(
        $wpdb->prepare("SELECT post_id, COUNT(id) page_view_count FROM $table_name WHERE time >= %s AND name = %s GROUP BY post_id ORDER BY page_view_count DESC LIMIT 100", array(
            date_i18n('Y-m-d H:i:s', strtotime("-{$period_in_days} days"), true),
            $type
        ))
    );
}


add_action('admin_menu', function() {
    add_submenu_page('edit.php?post_type=master', 'Master Top', 'Top', 'manage_options', 'master-top', 'pror_stats_display_admin_page' );
});

function pror_stats_display_admin_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	$period = 30;
    $res = pror_stats_get_top_period('master_page_view', $period);

	echo <<<"EOF"
<div class="wrap">
<h1>Master Top</h1>
<table class="wp-list-table widefat fixed striped posts">
    <thead>
        <tr>
            <td class="manage-column">Name</td>
            <td class="manage-column">Page View</td>
            <td class="manage-column">Show Phone</td>
            <td class="manage-column">Conversion</td>
        </tr>
    </thead>
    <tbody>
EOF;
    foreach ($res as $r) {
        $name = get_the_title($r->post_id);
        $link = get_edit_post_link($r->post_id);
        $show_phone_count = pror_stats_get_period('master_show_phone', $r->post_id, $period);
        $c = round(100*$show_phone_count/$r->page_view_count, 2);
        echo <<<"EOF"
            <tr>
                <td class="manage-column"><a href="{$link}">{$name}</a></td>
                <td class="manage-column">{$r->page_view_count}</td>
                <td class="manage-column">{$show_phone_count}</td>
                <td class="manage-column">{$c}%</td>
            </tr>
EOF;
    }

    echo <<<"EOF"
    </tbody>
</table>
</div>
EOF;
}
