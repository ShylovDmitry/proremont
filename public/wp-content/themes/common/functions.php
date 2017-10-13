<?php

require_once(__DIR__ . '/module_functions.php');


define('DLV_THEME_MODULES_DIR', __DIR__ . '/modules');

dlv_include_php_files_from_dir(__DIR__ . '/plugins', true);

if (is_admin()) {
    foreach (glob(DLV_THEME_MODULES_DIR . '/*/admin', GLOB_ONLYDIR) as $folder) {
        dlv_include_php_files_from_dir($folder);
    }
}

foreach (glob(DLV_THEME_MODULES_DIR . '/*/front', GLOB_ONLYDIR) as $folder) {
    dlv_include_php_files_from_dir($folder);
}

foreach (glob(DLV_THEME_MODULES_DIR . '/*/widgets', GLOB_ONLYDIR) as $folder) {
    dlv_register_widgets_from_dir($folder);
}


function dlv_get_ver() {
    $rev_file = APP_PATH . 'rev.txt';
    return file_exists($rev_file) ? trim(file_get_contents($rev_file)) : time();
}
