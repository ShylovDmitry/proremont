<?php

function pror_get_section() {
    $section = pror_get_section_by_slug(get_query_var('section'));
    if ($section) {
        return $section;
    }

    return pror_detect_section_by_ip();
}

function pror_get_section_by_slug($slug) {
    return get_term_by('slug', $slug, 'section');
}

function pror_get_section_by_id($id) {
    return get_term_by('id', $id, 'section');
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
    $section_slug = 'kiev';

    if (!WP_ENV_LOCAL) {
        $ipInfo = new \IpInfoDb\IpInfoDb(IPINFODB_API_KEY);
        $response = $ipInfo->city($_SERVER['REMOTE_ADDR']);

        if ($response->isSuccess()) {
            $section_slug = pror_convert_location_to_slug($response->getRegionName(), $response->getCityName(), $section_slug);
        } else {
//            echo $response->getStatusMessage();
        }
    }

    return pror_get_section_by_slug($section_slug);
}

function pror_convert_location_to_slug($region, $city, $default_slug) {
    $data = array(
        "L'viv/Lvivska oblast" => 'lvov',
        "Lvivska oblast" => 'lv',
        "Kiev/Kyiv" => 'kiev',
        "Kyiv" => 'ko',
        "Kiev/Kyivska oblast" => 'kiev',
        "Kyivska oblast" => 'ko',

        "Cherkasy/Cherkaska oblast" => 'cherkassy',
        "Cherkaska oblast" => 'chk',
        "Chernihiv/Chernihivska oblast" => 'chernigov',
        "Chernihivska oblast" => 'chn',
        "Chernivtsi/Chernivetska oblast" => 'chernovtsy',
        "Chernivetska oblast" => 'chv',
        "Dnipropetrovsk/Dnipropetrovska oblast" => 'dnepr',
        "Dnipropetrovska oblast" => 'dnp',
        "Donets'k/Donetska oblast" => 'donetsk',
        "Donetska oblast" => 'don',
        "Ivano-Frankivs'k/Ivano-Frankivska oblast" => 'ivano-frankovsk',
        "Ivano-Frankivska oblast" => 'if',
        "Kharkiv/Kharkivska oblast" => 'kharkov',
        "Kharkivska oblast" => 'kha',
        "Kherson/Khersonska oblast" => 'kherson',
        "Khersonska oblast" => 'khe',
        "Khmel'nyts'kyy/Khmelnytska oblast" => 'khmelnitskiy',
        "Khmelnytska oblast" => 'khm',
        "Kirovohrad/Kirovohradska oblast" => 'kropivnitskiy',
        "Kirovohradska oblast" => 'kir',
        "Luhans'k/Luhanska oblast" => 'lugansk',
        "Luhanska oblast" => 'lug',
        "Mykolayiv/Mykolaivska oblast" => 'nikolaev',
        "Mykolaivska oblast" => 'nik',
        "Odessa/Odeska oblast" => 'odessa',
        "Odeska oblast" => 'od',
        "Poltava/Poltavska oblast" => 'poltava',
        "Poltavska oblast" => 'pol',
        "Rivne/Rivnenska oblast" => 'rovno',
        "Rivnenska oblast" => 'rov',
        "Sumy/Sumska oblast" => 'sumy',
        "Sumska oblast" => 'sum',
        "Ternopil'/Ternopilska oblast" => 'ternopol',
        "Ternopilska oblast" => 'ter',
        "Vinnytsya/Vinnytska oblast" => 'vinnitsa',
        "Vinnytska oblast" => 'vin',
        "Luts'k/Volynska oblast" => 'lutsk',
        "Volynska oblast" => 'vol',
        "Uzhhorod/Zakarpatska oblast" => 'uzhgorod',
        "Zakarpatska oblast" => 'zak',
        "Zaporizhzhya/Zaporizka oblast" => 'zaporozhe',
        "Zaporizka oblast" => 'zap',
        "Zhytomyr/Zhytomyrska oblast" => 'zhitomir',
        "Zhytomyrska oblast" => 'zht',
    );

    if (isset($data[$city . '/' . $region])) {
        return $data[$city . '/' . $region];
    } else if (isset($data[$region])) {
        return $data[$region];
    } else {
        return $default_slug;
    }
}
