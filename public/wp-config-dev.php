<?php

/** Enable Cache by WP Rocket */
define( 'WP_CACHE', true );

if (!isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = 'dev1.proremont.ua';
}

defined('WP_DEBUG') or define('WP_DEBUG', false);
defined('WP_DEBUG_DISPLAY') or define('WP_DEBUG_DISPLAY', false);

define('WP_ENV', 'dev');

define('FS_METHOD', 'direct');

defined('DB_NAME') or define('DB_NAME', 'proremont');
defined('DB_USER') or define('DB_USER', 'root4');
defined('DB_PASSWORD') or define('DB_PASSWORD', 'RXYU2BTuXVmn');
defined('DB_HOST') or define('DB_HOST', 'proremont.cesjuvqkj6et.eu-central-1.rds.amazonaws.com');

/**
 * Authentication Unique Keys and Salts
 * https://api.wordpress.org/secret-key/1.1/salt/
 */
define('AUTH_KEY',         'R%w=6;VX%k6qelmDX<%LNm+]<9`}j/g_yQ[e}CjE!k$A5l[)3tS]{i>?+g2= 6wr');
define('SECURE_AUTH_KEY',  '^TP6k|6|aCT_;Q?itaqZ%K/^<P?$)z2CdUegCT,=W-FKzX=K;>B`4xMPYo{$:Tw`');
define('LOGGED_IN_KEY',    'g=StQHE*{r5ON&byrFuX[FGLJ582zxT$ZRg&Qp6qy0VF-fC;d(xI$O;T8-<c{3|S');
define('NONCE_KEY',        'CdUEn;C rQ[@(6|-f$v=>006B84d<Qrd^/i4R4xNm2k|+UigldCxN,2{]cqH]|Tv');
define('AUTH_SALT',        'a2TI*jHS*}@P?aYm-<9u5Z5VkRGY3s,>ErS89O|C:LW/`>!ymtM-K%-~[7CY@`iM');
define('SECURE_AUTH_SALT', 'oimBW&Q^ymLmDLFYYVpDgL-y-?-U@8=J7j:|@L|klE);u.vQ,-muLcm*OGR47+xd');
define('LOGGED_IN_SALT',   '?3t}Io6rI%Osd=gUQ|298G94[_4D$_vC2ogpkQY+Z{JGS;bmVY/qV~&s9GWz7ASM');
define('NONCE_SALT',       'k+|Kn!xM&j9EWQMig(bTtZ`KKUU,[&<8|mL?GV>J]}l^MX1|x^&-&j-agn%-=ste');

require_once(__DIR__ . '/wp-variables.php');
require_once(ABSPATH . 'wp-settings.php');
