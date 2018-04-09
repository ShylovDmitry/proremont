<?php

if (strpos(__DIR__, 'prod') !== false) {
    $host = 'proremont.co';
} elseif (strpos(__DIR__, 'dev') !== false) {
    $host = 'dev.proremont.co';
} else {
    $host = 'proremont.local';
}

$_SERVER['HTTP_HOST'] = $host;
