<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

define( 'WP_ROCKET_ADVANCED_CACHE', true );
$rocket_cache_path = APP_PATH . '/wp-content/cache/wp-rocket/';
$rocket_config_path = APP_PATH . '/wp-content/wp-rocket-config/';

if ( file_exists( APP_PATH . '/wp-content/plugins/wp-rocket/inc/front/process.php' ) ) {
	include( APP_PATH . '/wp-content/plugins/wp-rocket/inc/front/process.php' );
} else {
	define( 'WP_ROCKET_ADVANCED_CACHE_PROBLEM', true );
}