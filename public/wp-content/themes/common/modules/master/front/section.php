<?php

function pror_get_section() {
    $section = pror_get_section_by_slug(get_query_var('section'));
    if ($section) {
        return $section;
    }

    $section = pror_get_section_by_slug(pror_get_section_cookie());
    if ($section) {
        return $section;
    }

    $section = pror_get_section_by_slug(pror_detect_section_by_ip());
    if ($section) {
        return $section;
    }

    return pror_get_section_by_slug('kiev');
}

function pror_get_section_by_slug($slug) {
    return get_term_by('slug', $slug, 'section');
}

function pror_get_section_by_location_id($location_id) {
    $sections = get_terms(array(
        'taxonomy' => 'section',
        'hide_empty' => false,
    ));

    foreach ($sections as $section) {
        if (in_array($location_id, get_field('locations', $section))) {
            return $section;
        }
    }

    return null;
}

function pror_detect_section_by_ip() {
//    $_SERVER['REMOTE_ADDR'] = '93.77.137.79';

    $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    $geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));

    if ($geo) {
        return pror_convert_location_to_slug($geo['geoplugin_region'], $geo['geoplugin_city']);
    }
    return false;
}

function pror_convert_location_to_slug($region, $city) {
    $region = htmlspecialchars_decode($region, ENT_QUOTES);
    $city = htmlspecialchars_decode($city, ENT_QUOTES);

    $data = array(
        "Cherkasy/Cherkas'ka Oblast'" => 'cherkassy',
        "Cherkas'ka Oblast'" => 'chk',
        "Chernihiv/Chernihiv" => 'chernigov',
        "Chernihiv" => 'chn',
        "Chernivtsi/Chernivtsi" => 'chernovtsy',
        "Chernivtsi" => 'chv',
        "Dnipro/Dnipro" => 'dnepr',
        "Dnipro" => 'dnp',
        "Donetsk/Donets'ka Oblast'" => 'donetsk',
        "Donets'ka Oblast'" => 'don',
        "Ivano-Frankivs'k/Ivano-Frankivs'ka Oblast'" => 'ivano-frankovsk',
        "Ivano-Frankivs'ka Oblast'" => 'if',
        "Kharkiv/Kharkivs'ka Oblast'" => 'kharkov',
        "Kharkivs'ka Oblast'" => 'kha',
        "Kherson/Khersons'ka Oblast'" => 'kherson',
        "Khersons'ka Oblast'" => 'khe',
        "Khmelnytskyi/Khmel'nyts'ka Oblast'" => 'khmelnitskiy',
        "Khmel'nyts'ka Oblast'" => 'khm',
        "Kropyvnytskyi/Kropyvnytskyi" => 'kropivnitskiy',
        "Kropyvnytskyi" => 'kir',
        "Kiev/Kyiv" => 'kiev',
        "Kyiv" => 'ko',
        "Kyiv City" => 'kiev',
        "Lviv/L'vivs'ka Oblast'" => 'lvov',
        "L'vivs'ka Oblast'" => 'lv',
        "Luhansk/Luhans'ka Oblast'" => 'lugansk',
        "Luhans'ka Oblast'" => 'lug',
        "Mykolayiv/Mykolayivs'ka Oblast'" => 'nikolaev',
        "Mykolayivs'ka Oblast'" => 'nik',
        "Odesa/Odessa" => 'odessa',
        "Odessa" => 'od',
        "Poltava/Poltavs'ka Oblast'" => 'poltava',
        "Poltavs'ka Oblast'" => 'pol',
        "Rivne/Rivnens'ka Oblast'" => 'rovno',
        "Rivnens'ka Oblast'" => 'rov',
        "Sumy/Sums'ka Oblast'" => 'sumy',
        "Sums'ka Oblast'" => 'sum',
        "Ternopil/Ternopil's'ka Oblast'" => 'ternopol',
        "Ternopil's'ka Oblast'" => 'ter',
        "Vinnytsia/Vinnyts'ka Oblast'" => 'vinnitsa',
        "Vinnyts'ka Oblast'" => 'vin',
        "Lutsk/Volyns'ka Oblast'" => 'lutsk',
        "Volyns'ka Oblast'" => 'vol',
        "Uzhhorod/Transcarpathia" => 'uzhgorod',
        "Transcarpathia" => 'zak',
        "Zaporizhia/Zaporizhia" => 'zaporozhe',
        "Zaporizhia" => 'zap',
        "Zhytomyr/Zhytomyrs'ka Oblast'" => 'zhitomir',
        "Zhytomyrs'ka Oblast'" => 'zht',
    );

    if (isset($data[$city . '/' . $region])) {
        return $data[$city . '/' . $region];
    } else if (isset($data[$region])) {
        return $data[$region];
    } else {
        return false;
    }
}
