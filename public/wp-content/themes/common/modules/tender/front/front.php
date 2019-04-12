<?php

add_action('init', function() {
    add_rewrite_rule('(uk)/(tenders)/([^/]+)/(.+?)/page/?([0-9]{1,})/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]&section=$matches[3]&catalog_master=$matches[4]&paged=$matches[5]', 'top');
    add_rewrite_rule('(tenders)/([^/]+)/(.+?)/page/?([0-9]{1,})/?$', 'index.php?lang=ru&pagename=$matches[1]&section=$matches[2]&catalog_master=$matches[3]&paged=$matches[4]', 'top');
    add_rewrite_rule('(uk)/(tenders)/([^/]+)/(.+?)/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]&section=$matches[3]&catalog_master=$matches[4]', 'top');
    add_rewrite_rule('(tenders)/([^/]+)/(.+?)/?$', 'index.php?lang=ru&pagename=$matches[1]&section=$matches[2]&catalog_master=$matches[3]', 'top');
    add_rewrite_rule('(uk)/(tenders)/([^/]+)/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]&section=$matches[3]', 'top');
    add_rewrite_rule('(tenders)/([^/]+)/?$', 'index.php?lang=ru&pagename=$matches[1]&section=$matches[2]', 'top');

    add_rewrite_rule('(uk)/(tenders)/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]&__tender_redirect=1', 'top');
    add_rewrite_rule('(tenders)/?$', 'index.php?lang=ru&pagename=$matches[1]&__tender_redirect=1', 'top');
});

add_filter('query_vars', function($query_vars) {
    $query_vars[] = '__tender_redirect';
    return $query_vars;
});

add_action('template_redirect', function () {
    if (get_query_var('__tender_redirect')) {
        $url = [];
        if (pll_default_language() != get_query_var('lang')) {
            $url[] = get_query_var('lang');
        }

        $url[] = get_query_var('pagename');
        $url[] = pror_detect_section()->slug;
        wp_redirect('/' . implode('/', $url), 301);
        exit;
    }
});




add_action('wp_print_styles', function () {
    wp_enqueue_style('tender-common', get_module_css('tender/common.css'), array(), dlv_get_ver());
});

add_action('wp_enqueue_scripts', function () {
    if (get_post_type() == 'tender') {
        wp_enqueue_script('tender-common', get_module_js('tender/common.js'), array('jquery'), dlv_get_ver(), true);
    }
});


function pror_get_tender_section($tender_id = null) {
    $term = get_the_terms($tender_id, 'location');
    if (!is_wp_error($term) && isset($term, $term[0])) {
        return pror_get_section_by_location_id($term[0]->term_id);
    }

    return '';
}

function pror_tender_get_budgets() {
    return [
        '3000' => __('до 3,000 грн', 'common'),
        '7000' => __('до 7,000 грн', 'common'),
        '15000' => __('до 15,000 грн', 'common'),
        '30000' => __('до 30,000 грн', 'common'),
        '70000' => __('до 70,000 грн', 'common'),
        '150000' => __('до 150,000 грн', 'common'),
        '300000' => __('до 300,000 грн', 'common'),
        'max' => __('более 300,000 грн', 'common'),
    ];
}

function pror_tender_get_expires() {
    return [
        '1w' => __('1 неделя', 'common'),
        '2w' => __('2 недели', 'common'),
        '3w' => __('3 недели', 'common'),
        '4w' => __('4 недели', 'common'),
    ];
}

function pror_tender_convert_expires_to_date($expires) {
	$data = [
		'1w' => '+1week +1day midnight',
		'2w' => '+2weeks +1day midnight',
		'3w' => '+3weeks +1day midnight',
		'4w' => '+4weeks +1day midnight',
	];
	return strtotime($data[$expires]);
}

function pror_tender_is_expired() {
	$expires = get_field('expires_date', false, false);
	return date('Ymd') > $expires;
}




add_filter('posts_fields', function($fields, $query) {
	if ($query->is_admin() || $query->is_main_query()) {
		return $fields;
	}

	if ($query->query['orderby'] == 'pror_tender_order') {
		$fields .= ', IF(DATE_FORMAT(wp_posts.post_date, "%Y%m%d") > wp_pm_tender_order.meta_value, 0, 1) as pror_tender_order';
	}
	return $fields;
}, 10, 2);

add_filter('posts_join', function($join, $query) {
	if ($query->is_admin() || $query->is_main_query()) {
		return $join;
	}

	if ($query->query['orderby'] == 'pror_tender_order') {
		$join .= " INNER JOIN wp_postmeta wp_pm_tender_order ON ( wp_posts.ID = wp_pm_tender_order.post_id AND wp_pm_tender_order.meta_key = 'expires_date')";
	}
	return $join;
}, 10, 2);

add_filter('posts_orderby', function($orderby, $query) {
	if ($query->is_admin() || $query->is_main_query()) {
		return $orderby;
	}

	if ($query->query['orderby'] == 'pror_tender_order') {
		$orderby = 'pror_tender_order DESC, ' . $orderby;
	}
	return $orderby;
}, 10, 2);



//function pror_get_tender_permalink($lang = null, $section = null, $catalog = null) {
////    '/:lang/tenders/:section/:catalog/';
//
//    $url = [];
//    if ($lang && $url != pll_default_language()) {
//        $url[] = $lang;
//    }
//    $url[] = ' tenders';
//
//
//
////    var_dump($url);exit;
//    return $url;
//}

//add_filter('rewrite_rules_array', 'kill_feed_rewrites');
//function kill_feed_rewrites($rules){
//    print_r($rules);exit;
//}



add_action('wp_ajax_pror_tender_action', 'pror_ajax_tender_action');

function pror_ajax_tender_action() {
    switch ($_POST['type']) {
        case 'create_tender_response':
        	$res = pror_tender_create_response($_POST);
        	if ($res instanceof WP_Error) {
		        wp_send_json_error($res);
	        }

            wp_send_json_success($res);
            break;
        default:
            wp_send_json_error(new WP_Error('wrong_param', 'Wrong "type" parameter.'));
            break;
    }
}

function pror_tender_create_response($data) {
	$user = wp_get_current_user();
	$master_post_id = pror_get_master_post_id($user->ID);
	if (!$master_post_id) {
		return new WP_Error('not_master', 'You are not master');
	}

	$tender = get_post($data['tender_id']);
	if (!$tender) {
		return new WP_Error('tender_not_exist', 'Tender does not exist.');
	}

	if (pror_tender_is_tender_assigned_to_user($data['tender_id'])) {
		return new WP_Error('duplicated', 'Duplicated record.');
	}

	$id = wp_insert_post([
		'post_title' => sprintf('%s - %s', get_the_title($tender), $user->display_name),
		'post_type' => 'tender_response',
		'post_status' => 'publish',

	]);

	update_field('_tender', 'field_5cab62cc28550', $id);
	update_field('tender', $data['tender_id'], $id);

	update_field('_author', 'field_5cab63ea254ea', $id);
	update_field('author', get_current_user_id(), $id);

	update_field('_comment', 'field_5cab62f121f1c', $id);
	update_field('comment', $data['comment'], $id);

	update_field('_comment_visibility', 'field_5cae11f10b687', $id);
	update_field('comment_visibility', $data['comment_visibility'], $id);

	return $id;
}

function pror_tender_is_tender_assigned_to_user($tender_id, $user_id = null) {
	if (!$user_id) {
		$user_id = get_current_user_id();
	}
	return pror_tender_query_tender_responses($tender_id, $user_id)->have_posts();
}

function pror_tender_query_tender_responses($tender_id = null, $author_id = null) {
	$meta_query = [];
	if ($tender_id) {
		$meta_query[] = [
			'key' => 'tender',
			'value' => $tender_id,
		];
	}
	if ($author_id) {
		$meta_query[] = [
			'key' => 'author',
			'value' => $author_id,
		];
	}

	return new WP_Query([
		'post_type' => 'tender_response',
		'post_status' => 'any',
		'meta_query' => empty($meta_query) ? false : $meta_query,
	]);
}
