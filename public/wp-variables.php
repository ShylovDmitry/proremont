<?php

#defined('WP_CACHE') or define('WP_CACHE', true);

define('APP_PATH', dirname(__FILE__));

//require_once(__DIR__ . '/../vendor/autoload.php');

#define('AWS_ACCESS_KEY_ID', 'xx');
#define('AWS_SECRET_ACCESS_KEY', 'xx');

/**
 * ENVIRONMENT
 */
defined('WP_ENV') or define('WP_ENV', getenv('WP_ENV')); // local | stage | prod
defined('WP_ENV_LOCAL') or define('WP_ENV_LOCAL', WP_ENV == 'local');
defined('WP_ENV_STAGE') or define('WP_ENV_STAGE', WP_ENV == 'stage');
defined('WP_ENV_PROD') or define('WP_ENV_PROD', WP_ENV == 'prod');


/**
 * URLs
 */
defined('WP_HOME') or define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']);
defined('WP_SITEURL') or define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wp');


/**
 * Custom Content Directory
 */
defined('CONTENT_DIR') or define('CONTENT_DIR', '/wp-content');
defined('WP_CONTENT_DIR') or define('WP_CONTENT_DIR', APP_PATH . CONTENT_DIR);
defined('WP_CONTENT_URL') or define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);


/**
 * DB settings
 */
$table_prefix = 'wp_';

defined('DB_NAME') or define('DB_NAME', 'remont');
defined('DB_USER') or define('DB_USER', 'root');
defined('DB_PASSWORD') or define('DB_PASSWORD', 'admin');
defined('DB_HOST') or define('DB_HOST', 'localhost');

defined('DB_CHARSET') or define('DB_CHARSET', 'utf8');
defined('DB_COLLATE') or define('DB_COLLATE', '');


/**
 * Consistently update via composer and disallow file edit via browser
 */
defined('AUTOMATIC_UPDATER_DISABLED') or define('AUTOMATIC_UPDATER_DISABLED', true);
defined('DISALLOW_FILE_EDIT') or define('DISALLOW_FILE_EDIT', WP_ENV_PROD);
defined('DISALLOW_FILE_MODS') or define('DISALLOW_FILE_MODS', WP_ENV_PROD);


/**
 * In most cases you want to run a true cron task
 */
defined('DISABLE_WP_CRON') or define('DISABLE_WP_CRON', true);


/**
 * Increase memory
 */
//defined('WP_MEMORY_LIMIT') or define( 'WP_MEMORY_LIMIT', '128M' );
//defined('WP_MAX_MEMORY_LIMIT') or define( 'WP_MAX_MEMORY_LIMIT', '256M' );


// Optional debug config
if ( WP_ENV_LOCAL ) {
    defined('WP_DEBUG') or define('WP_DEBUG', true);
    defined('WP_DEBUG_DISPLAY') or define('WP_DEBUG_DISPLAY', true); // display_errors

    ini_set('display_startup_errors', 'On');
    ini_set('opcache.enable', '0');
} else {
    defined('WP_DEBUG') or define('WP_DEBUG', false);
    defined('WP_DEBUG_DISPLAY') or define('WP_DEBUG_DISPLAY', false); // display_errors
}


defined('CONCATENATE_SCRIPTS') or define('CONCATENATE_SCRIPTS', false);


/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', APP_PATH . '/wp/');
}
