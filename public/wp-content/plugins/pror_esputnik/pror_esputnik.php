<?php
/**
 * ProRemont eSputnik Integration
 *
 * Plugin Name: ProRemont eSputnik Integration
 * Description: eSputnik Integration.
 * Version:     0.1
 */

defined( 'ABSPATH' ) or die();

require(__DIR__ . '/includes/eSputnikApi.php');

global $eSputnikApi;
$eSputnikApi = new eSputnikApi();
$eSputnikApi->auth(get_option('esputnik_login'), get_option('esputnik_password'));

remove_action('register_new_user', 'wp_send_new_user_notifications');
add_action('register_new_user', function($user_id) {
    wp_send_new_user_notifications($user_id, 'admin');
});


register_activation_hook(__FILE__, 'pror_esputnik_install');
register_deactivation_hook(__FILE__, 'pror_esputnik_uninstall');

function pror_esputnik_install() {
    global $wpdb;

	$table_name = $wpdb->prefix . 'pror_esputnik';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		create_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		action varchar(255) NOT NULL,
		data text NOT NULL,
		in_progress tinyint DEFAULT 0,
		done_time datetime DEFAULT NULL,
		PRIMARY KEY (id)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);


//	if (!wp_next_scheduled('pror_esputnik_sync')) {
//        wp_schedule_event( time(), '5min', 'pror_esputnik_sync' );
//    }
}

function pror_esputnik_uninstall() {
    wp_clear_scheduled_hook('pror_esputnik_sync');

    // Do nothing
}

add_filter('cron_schedules', function ( $schedules ) {
	$schedules['5min'] = array('interval' => 5*60, 'display' => __('5 Minutes'));
	return $schedules;
});

add_filter('init', function ( $schedules ) {
	$schedules['5min'] = array('interval' => 5*60, 'display' => __('5 Minutes'));
	return $schedules;
});


add_action('admin_menu', function() {
    add_options_page('eSputnik Setup', 'eSputnik Setup', 'administrator', __FILE__, 'pror_esputnik_display_admin_page');
});

add_action('admin_init', function() {
    register_setting('esputnik-group', 'esputnik_login');
    register_setting('esputnik-group', 'esputnik_password');
});

function pror_esputnik_display_admin_page() {
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    do_action('pror_esputnik_sync');



	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
<div class="wrap">
    <h1>eSputnik Setup</h1>

    <form method="post" action="options.php">

        <?php settings_fields('esputnik-group'); ?>
        <?php do_settings_sections('esputnik-group'); ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">eSputnik Login</th>
                <td><input type="text" name="esputnik_login" value="<?php echo esc_attr( get_option('esputnik_login') ); ?>" /></td>
            </tr>

            <tr valign="top">
                <th scope="row">eSputnik Password</th>
                <td><input type="password" name="esputnik_password" value="<?php echo esc_attr( get_option('esputnik_password') ); ?>" /></td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>

    <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'pror_esputnik';
        $res = $wpdb->get_results("SELECT * FROM $table_name ORDER BY create_time DESC LIMIT 100");
    ?>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <td class="manage-column">Create Time</td>
                <td class="manage-column">Action</td>
                <td class="manage-column">Data</td>
                <td class="manage-column">Done Time</td>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($res as $task): ?>
            <tr>
                <td class="manage-column"><?php echo $task->create_time; ?></td>
                <td class="manage-column"><?php echo $task->action; ?></td>
                <td class="manage-column"><?php echo $task->data; ?></td>
                <td class="manage-column"><?php echo $task->done_time; ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>

<?php
}

add_action('profile_update', function($user_id, $old_user_data) {
    $old_user = $old_user_data;
    $old_email = ($old_user) ? $old_user->data->user_email : null;

    $user = get_userdata($user_id);
    $email = $user->data->user_email;

    $data = [
        'contact' => pror_esputnik_create_user($user_id),
        'groups' => pror_user_has_role('master', $user_id) ? eSputnikApi::GROUP_MASTERS : eSputnikApi::GROUP_SUBSCRIBERS,
        'new_email' => ($old_email != $email) ? $old_email : null,
    ];
    pror_esputnik_queue_action('CONTACT_POST', $data);


    if ($old_email != $email && strpos($old_email, 'ProRemont.Catalog+') === 0) {
        $tel = '';
        foreach (pror_get_master_phones($user_id) as $phone) {
            $tel = $phone['tel'];
            break;
        }

        $data = [
            'event' => [
                'eventTypeKey' => 'master_change_email',
                'keyValue' => $email,
                'params' => [
                    ['name' => 'EmailAddress', 'value' => $email],
                    ['name' => 'PhoneNumber', 'value' => $tel],
                ]
            ],
        ];
        pror_esputnik_queue_action('EVENT_POST', $data);
    }
}, 11, 2);

add_action('user_register', function($user_id) {
    if (!pror_user_has_role('master', $user_id)) {
        return;
    }

    $data = [
        'contact' => pror_esputnik_create_user($user_id),
        'groups' => pror_user_has_role('master', $user_id) ? eSputnikApi::GROUP_MASTERS : eSputnikApi::GROUP_SUBSCRIBERS,
    ];
    pror_esputnik_queue_action('CONTACT_POST', $data);


    $user = get_userdata($user_id);
    if (!$user->user_url) {
        $adt_rp_key = get_password_reset_key($user);
        $user_login = $user->user_login;
        $email = $user->data->user_email;

        $data = [
            'event' => [
                'eventTypeKey' => 'master_init_registration',
                'keyValue' => $email,
                'params' => [
                    ['name' => 'EmailAddress', 'value' => $email],
                    ['name' => 'ResetPasswordLink', 'value' => network_site_url("wp-login.php?action=rp&key=$adt_rp_key&login=" . rawurlencode($user_login), 'login')],
                ]
            ],
        ];
        pror_esputnik_queue_action('EVENT_POST', $data);
    }
}, 11);

add_action('wp_login', function($user_login, $user) {
    if (!pror_user_has_role('master', $user->ID)) {
        return;
    }

    $email = $user->data->user_email;
    $data = [
        'event' => [
            'eventTypeKey' => 'master_registered',
            'keyValue' => $email,
            'params' => [
                ['name' => 'EmailAddress', 'value' => $email],
            ]
        ],
    ];
    pror_esputnik_queue_action('EVENT_POST', $data);
}, 11, 2);

add_action('pror_update_master_info_published', function($user_id, $master_post_id) {
    $user = get_userdata($user_id);
    $email = $user->data->user_email;

    $data = [
        'event' => [
            'eventTypeKey' => 'master_published',
            'keyValue' => $email,
            'params' => [
                ['name' => 'EmailAddress', 'value' => $email],
                ['name' => 'MasterLink', 'value' => get_permalink($master_post_id)],
            ]
        ],
    ];
    pror_esputnik_queue_action('EVENT_POST', $data);
}, 11, 2);

add_action('delete_user', function($user_id, $reassign) {
    $data = [
        'contact' => pror_esputnik_create_user($user_id),
        'groups' => [],
    ];
    pror_esputnik_queue_action('CONTACT_POST', $data);
}, 11, 2);



function pror_esputnik_create_user($user_id) {
    $user = get_userdata($user_id);
    $email = $user->data->user_email;

    $contact = [
        'firstName' => pror_user_has_role('master', $user_id) ? get_field('master_title', "user_{$user_id}") : '',
        'channels' => [['type' => 'email', 'value' => $email]],
    ];

    foreach (pror_get_master_phones($user_id) as $phone) {
        $contact['channels'][] = ['type' => 'sms', 'value' => $phone['tel']];
    }

    $posts = get_posts(array(
        'author' => $user_id,
        'posts_per_page' => 1,
        'post_type' => 'master',
        'post_status' => 'any',
    ));
    $post_id = isset($posts, $posts[0], $posts[0]->ID) ? $posts[0]->ID : false;
    if ($post_id) {
        $loc = pror_get_master_location($post_id);
        if ($loc) {
            $contact['address'] = ['region' => $loc[0], 'town' => $loc[1]];
        }
    }

    return $contact;
}

function pror_esputnik_queue_action($action, $data) {
    global $wpdb;

	$table_name = $wpdb->prefix . 'pror_esputnik';
    $wpdb->insert($table_name,
        array(
            'create_time' => current_time('mysql', true),
            'action' => $action,
            'data' => json_encode($data),
        ),
        array(
            '%s',
            '%s',
            '%s',
        )
    );

    do_action('pror_esputnik_sync');
}

add_action('pror_esputnik_sync', function() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'pror_esputnik';

    for ($i = 0; $i < 5; $i++) {
        $record = $wpdb->get_row("SELECT * FROM $table_name WHERE done_time IS NULL AND in_progress = 0 ORDER BY create_time LIMIT 1");

        $wpdb->query($wpdb->prepare("UPDATE $table_name SET in_progress = 1 WHERE id = {$record->id}"));

        $res = pror_esputnik_process_action($record->action, json_decode($record->data, true));
        if ($res) {
            $wpdb->query($wpdb->prepare("UPDATE $table_name SET done_time = %s WHERE id = {$record->id}", [current_time('mysql', true)]));
        }

        $wpdb->query($wpdb->prepare("UPDATE $table_name SET in_progress = 0 WHERE id = {$record->id}"));
    }
});

function pror_esputnik_process_action($action, $data) {
    global $eSputnikApi;

    switch ($action) {
        case 'CONTACT_POST':
            return $eSputnikApi->postContact((object)$data['contact'], $data['groups']);

        case 'EVENT_POST':
            return $eSputnikApi->postEvent((object)$data['event']);
    }

    return false;
}
