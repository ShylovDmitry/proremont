<?php

require_once(ABSPATH . 'wp-admin/includes/plugin.php');

function dlv_is_plugin_active($file) {
    $plugin = sprintf('%s/%s', basename(dirname($file)), basename($file));
    return is_plugin_active($plugin);
}

function dlv_plugins_url($path, $file) {
    $plugin = sprintf('%s/%s', basename(dirname($file)), basename($file));
    return plugins_url($path, $plugin);
}

function dlv_include_php_files_from_dir($path, $recursive = false) {
    if (is_dir($path)) {
        $dir = new \DirectoryIterator($path);

        foreach ($dir as $file) {
            if ($file->isDot()) continue; // Skip . and ..

            if ($recursive && $file->isDir()) {
                dlv_include_php_files_from_dir($file->getPath().'/'.$file->getFilename(), $recursive);
            }

            if ($file->isFile()) {
                $file_extension = pathinfo($file->getFilename(), PATHINFO_EXTENSION);

                if ($file_extension === 'php') {
                    include_once $file->getPath().'/'.$file->getBasename();
                }
            }
        }
    }
}

function dlv_register_widgets_from_dir($path) {
    if (is_dir($path)) {
        $dir = new \DirectoryIterator($path);

        foreach ($dir as $file) {
            if ($file->isDot()) continue; // Skip . and ..

            if ($file->isFile()) {
                $file_extension = pathinfo($file->getFilename(), PATHINFO_EXTENSION);

                if ($file_extension === 'php') {
                    include_once $file->getPath().'/'.$file->getBasename();
                    $widget_class = sprintf('%s_Widget', $file->getBasename('.' . $file_extension));

                    add_action('widgets_init', function() use ($widget_class) {
                        register_widget($widget_class);
                    });
                }
            }
        }
    }
}

/*
 * CSS helper
 */

function get_module_css($name) {
    list($module, $file) = explode('/', $name, 2);

    return sprintf('%s/assets/css/%s',
        get_stylesheet_directory_uri() . '/modules/' . $module,
        $file
    );
}

function module_css($name) {
    echo get_module_css($name);
}


/*
 * JS helper
 */

function get_module_js($name) {
    list($module, $file) = explode('/', $name, 2);

    return sprintf('%s/assets/js/%s',
        get_stylesheet_directory_uri() . '/modules/' . $module,
        $file
    );
}

function module_js($name) {
    echo get_module_js($name);
}


/*
 * IMG helper
 */

function get_module_img($name) {
    list($module, $file) = explode('/', $name, 2);

    return sprintf('%s/assets/img/%s',
        get_stylesheet_directory_uri() . '/modules/' . $module,
        $file
    );
}

function module_img($name) {
    echo get_module_img($name);
}

/*
 * SVG helper
 */

function get_module_svg($name) {
    list($module, $file) = explode('/', $name, 2);

    return file_get_contents(sprintf('%s/assets/img/%s',
        get_stylesheet_directory() . '/modules/' . $module,
        $file
    ));
}

function module_svg($name) {
    echo get_module_svg($name);
}


/*
 * Template helper
 */
function module_template($path, $data = array(), $require_once = false) {
    list($module, $file) = explode('/', $path, 2);

    $located = locate_template($file);
    if ($located == '') {
        $located = sprintf('%s/template/%s.php',
            get_stylesheet_directory() . '/modules/' . $module,
            $file
        );
        if (!file_exists($located)) {
            throw new Exception("Template '$located' does not exist.");
        }
    }

    set_query_var('__data', $data);
    load_template($located, $require_once);
}

/**
 * @deprecated
 */
function get_module_template($path, $data = array(), $require_once = false) {
    ob_start();
    module_template($path, $data, $require_once);
    return ob_get_clean();
}
