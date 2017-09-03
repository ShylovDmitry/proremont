<?php

if (!isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = 'proremont.ua';
}

defined('WP_DEBUG') or define('WP_DEBUG', false);
defined('WP_DEBUG_DISPLAY') or define('WP_DEBUG_DISPLAY', true); // display_errors

define('WP_ENV', 'prod');

defined('DB_NAME') or define('DB_NAME', 'proremont');
defined('DB_USER') or define('DB_USER', 'root4');
defined('DB_PASSWORD') or define('DB_PASSWORD', 'RXYU2BTuXVmn');
defined('DB_HOST') or define('DB_HOST', 'proremont.cesjuvqkj6et.eu-central-1.rds.amazonaws.com');

/**
 * Authentication Unique Keys and Salts
 * https://api.wordpress.org/secret-key/1.1/salt/
 */
define('AUTH_KEY',         ':S`Ta{@,u2ad;M~g:/%A4Z*CU{#g3KRUk-B ^d[-T,!RhMyK4S!y:|.GakkpR(5e');
define('SECURE_AUTH_KEY',  '{N}L+e4873@oXC.KjYXRtBYs=LAU>N=K0cUjh jD!$0f$-k~RG2vw>0QIVVM4.HN');
define('LOGGED_IN_KEY',    't_y | P+`J%ju{5M%L;A`=+wyh|E<4$%9CleuUK.-#c+8d}5(E5-nZki[m52Z]rR');
define('NONCE_KEY',        ' 0:#,h+Sqw|7IzQ-E)S>1s.vr:288`-ZK}kPi?Do3uJBt*h8&YB|`=T4;5+H<Uh!');
define('AUTH_SALT',        '236Q-y818XgiA-MD<Otefu/#)7s;v15`TH01a3N<R+,nG24];(Q0k-+WmU;3F.n:');
define('SECURE_AUTH_SALT', '-,8El)5~[Ed}P^v-fL>D&HnTbSO!qJ+hdY8^]L}OI(TG?458d/MQB~!J:ALKS/ _');
define('LOGGED_IN_SALT',   '-6#+1N$<q-`Hf~tcVW8M`eEY}Y`stDzq/[O0Q~ty|,6@P{5(EjjF]uZ/BzG(:^2.');
define('NONCE_SALT',       'dMja>>}<oqQkHtK^$Vo/U||s?!MOH]Sp;P~lN}x{mxr^*q:lX=O+mB.X yq+ZUPu');

require_once(__DIR__ . '/wp-variables.php');
require_once(ABSPATH . 'wp-settings.php');
