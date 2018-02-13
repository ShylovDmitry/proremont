<?php

add_action('wp_ajax_pror_master_action', 'pror_ajax_master_action');
add_action('wp_ajax_nopriv_pror_master_action', 'pror_ajax_master_action');

function pror_ajax_master_action() {
    $res = pror_stats_track_event('master_' . $_POST['type'], $_POST['post_id']);

    if ($res) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
