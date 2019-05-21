<?php

add_action('init', function() {
    add_rewrite_rule('(uk)/(tenders-add)/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]', 'top');
    add_rewrite_rule('(tenders-add)/?$', 'index.php?lang=ru&pagename=$matches[1]', 'top');
});

add_action('wp', function() {
    if ('POST' == $_SERVER['REQUEST_METHOD'] && is_page('tenders-add')) {
        $tender_id = wp_insert_post([
            'post_title' => $_POST['title'],
            'post_status' => 'publish',
            'post_type' => 'tender',
        ]);
        if ($tender_id) {
            $section = pror_get_section_by_name($_POST['section']);
            if ($section) {
                update_post_meta($tender_id, '_section', 'field_5c9a1444460ea');
                update_post_meta($tender_id,'section', $section->term_id);
            }

            update_post_meta($tender_id, '_is_customer_registered', 'field_5cbdab93ac99b');
            update_post_meta($tender_id, 'is_customer_registered', '1');

            update_post_meta($tender_id, '_customer', 'field_5c9cef2311417');
            update_post_meta($tender_id, 'customer', get_current_user_id());

            update_post_meta($tender_id, '_budget', 'field_5c9e193041f62');
            update_post_meta($tender_id, 'budget', $_POST['budget']);

            update_post_meta($tender_id,'_description', 'field_5c9e19e48a738');
            update_post_meta($tender_id,'description', pror_theme_add_hide_shortcode($_POST['description']));


            $expires_keys = array_keys(pror_tender_get_expires());
            $expires = in_array($_POST['expires'], $expires_keys) ? $_POST['expires'] : current($expires_keys);
	        $expires_date = pror_tender_convert_expires_to_date($expires);

            update_post_meta($tender_id,'_expires_date', 'field_5cb044ed9cb88');
            update_post_meta($tender_id,'expires_date', date('Ymd', $expires_date));

            do_action('pror_tender_created', $tender_id);

            wp_redirect( get_permalink($tender_id) );
            exit;
        }

        wp_redirect( "?error=1" );
        exit;
    }
});