<?php

define('WP_CACHE', false);

if (!isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = 'remont.lh';
}
defined('WP_DEBUG') or define('WP_DEBUG', false);
defined('WP_DEBUG_DISPLAY') or define('WP_DEBUG_DISPLAY', false);

define('WP_ENV', 'local');

define('FS_METHOD', 'direct');

/**
 * Authentication Unique Keys and Salts
 * https://api.wordpress.org/secret-key/1.1/salt/
 */
define('AUTH_KEY',         '>|.@ON+G?q*(2Y1$j1eAR1I-]HHrQxoQ6SWxZ@(@h$t=DhC.zrH.z=<Y[!b4e;`/');
define('SECURE_AUTH_KEY',  '@Xz*<zT<>(8R]!Is^+4lF+/P~$C]M~wK(w$0SJ3>+iEX@5X|OWnPaol7~zT= k/Z');
define('LOGGED_IN_KEY',    '|tiA$sEGCM&4vcR/`]Hm>I:+`dy##kk0/NQbOj*i0uDg6za[/v=-%A]Ivu-[DB[z');
define('NONCE_KEY',        'Ps 6~ U5sj]#?Z:Ve./.35rbIK|w0b+5U&b=v])z+t~:+OB~jbVda1lTMSdLX<y{');
define('AUTH_SALT',        '0&IofKd{oQBUpL:F*jv>Ta4P4ek-6E%G5n0Uvpn&qy8.:`{wE(~<fTEejekQ2*PP');
define('SECURE_AUTH_SALT', 'F:x`+-i0=78ZCWVAddrkI%onMWjb|}+<[J!=>nOT8{<)p+p7I}0df[[FH-/5W/:}');
define('LOGGED_IN_SALT',   '.CwL=$@i44}$:TDL*#eqm|$M9ih*#FR!@-vO@3CNg^de1t-$4g}/[xLl~K0U{5zp');
define('NONCE_SALT',       '@Hi<w|B`b|;w9k!H7G=WLn0(x}E|w%4+u7<11ozb=BbUZ0]K#`hJOXw-U9EA+^t?');

require_once(__DIR__ . '/wp-variables.php');
require_once(ABSPATH . 'wp-settings.php');
