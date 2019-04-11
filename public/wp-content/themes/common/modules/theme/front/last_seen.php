<?php

add_action('wp_footer', function() {
    if ( is_user_logged_in() ) {
        update_user_meta( get_current_user_id(), 'last_seen', time() );
    } else {
        return;
    }
});

function pror_user_get_lastseen($user_id = false) {
    $last_seen = get_the_author_meta('last_seen', $user_id);
    $the_last_seen_date = human_time_diff($last_seen);
    return $the_last_seen_date;
}
