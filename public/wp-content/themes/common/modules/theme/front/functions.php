<?php

function pror_user_has_role($roles, $user_id = null) {
    $user = $user_id ? get_user_by('id', $user_id) : wp_get_current_user();

    if (!$user) {
        return false;
    }

    foreach (explode(' ', $roles) as $role) {
        if (in_array($role, (array)$user->roles)) {
            return true;
        }
    }
    return false;
}



function pror_set_section_cookie($section_slug) {
    if ($section_slug != pror_get_section_cookie()) {
        setcookie('pror_section', $section_slug, strtotime('+1 year'), '/', $_SERVER['HTTP_HOST'], false, true);
    }
}

function pror_remove_section_cookie() {
    setcookie('pror_section', '', strtotime( '-1 year' ), '/', $_SERVER['HTTP_HOST'], false, true);
}

function pror_get_section_cookie() {
    return isset($_COOKIE, $_COOKIE['pror_section']) ? $_COOKIE['pror_section'] : null;
}




function pror_cache_expire($expire = 0) {
    return $expire ? $expire - time()%$expire : 0;
}

function pror_cache_key($key = null, $depends_str = '') {
    if (empty($key)) {
        $key = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }

    $depends = explode(',', $depends_str);
    if (in_array('section', $depends)) {
        $key .= '-' . pror_detect_section()->slug;
    }
    if (in_array('lang', $depends)) {
        $key .= '-' . pll_current_language();
    }
    if (in_array('user_id', $depends)) {
        $user = wp_get_current_user();
        $key .= '-' . $user->ID;
    }

    foreach ($_COOKIE as $name => $value) {
        if (strpos($name, 'wordpress_logged_in_') === 0) {
            $user = wp_get_current_user();
            $key .= '-loggedin=' . (isset($user->roles[0]) ? $user->roles[0] : '_');

            break;
        }
    }

    return $key;
}

function pror_cache_delete_wildcard($group) {
    global $wp_object_cache;

    if (method_exists($wp_object_cache, 'get_mc')) {
        foreach ($wp_object_cache->get_mc('default')->getAllKeys() as $full_key) {
            if (strpos($full_key, ':' . $group . ':') !== false) {
                $key = end(explode(':', $full_key));

                $correct_group = substr($full_key, strpos($full_key, $group));
                $correct_group = str_replace(':' . $key, '', $correct_group);

                wp_cache_delete($key, $correct_group);
            }
        }
    }
}
