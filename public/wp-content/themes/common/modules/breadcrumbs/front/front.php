<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('breadcrumbs-common', get_module_css('breadcrumbs/common.css'), array(), dlv_get_ver());
});


add_filter( 'wpseo_breadcrumb_links', function( $links ) {
	if (is_singular( 'tender' )) {
		$post = get_page_by_path('tenders');
		$lang_post = pll_get_post($post->ID);

		$breadcrumb[] = array(
			'id' => $lang_post,
		);

		array_splice( $links, 1, -2, $breadcrumb );
	}

	return $links;
});