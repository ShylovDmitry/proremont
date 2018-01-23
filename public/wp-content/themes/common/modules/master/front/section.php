<?php

global $global_section;
function pror_get_section() {
    global $global_section;

    if ($global_section) {
        return $global_section;
    }

    $section = pror_get_section_by_slug(get_query_var('section'));
    if (!$section) {

        $section = pror_get_section_by_slug(pror_get_section_cookie());
        if (!$section) {

            $section = pror_get_section_by_slug(pror_detect_section_by_ip());
            if (!$section) {

                $section = pror_get_section_by_slug('kiev');
            }
        }
    }

    $global_section = $section;
    return $section;
}

function pror_get_section_by_slug($slug) {
    $term = get_term_by('slug', $slug, 'section');

    if ($term && get_field('hidden', $term) == false) {
        return $term;
    }
    return false;
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
    $botRegexPattern = "(googlebot\/|Googlebot\-Mobile|Googlebot\-Image|Google favicon|Mediapartners\-Google|bingbot|slurp|java|wget|curl|Commons\-HttpClient|Python\-urllib|libwww|httpunit|nutch|phpcrawl|msnbot|jyxobot|FAST\-WebCrawler|FAST Enterprise Crawler|biglotron|teoma|convera|seekbot|gigablast|exabot|ngbot|ia_archiver|GingerCrawler|webmon |httrack|webcrawler|grub\.org|UsineNouvelleCrawler|antibot|netresearchserver|speedy|fluffy|bibnum\.bnf|findlink|msrbot|panscient|yacybot|AISearchBot|IOI|ips\-agent|tagoobot|MJ12bot|dotbot|woriobot|yanga|buzzbot|mlbot|yandexbot|purebot|Linguee Bot|Voyager|CyberPatrol|voilabot|baiduspider|citeseerxbot|spbot|twengabot|postrank|turnitinbot|scribdbot|page2rss|sitebot|linkdex|Adidxbot|blekkobot|ezooms|dotbot|Mail\.RU_Bot|discobot|heritrix|findthatfile|europarchive\.org|NerdByNature\.Bot|sistrix crawler|ahrefsbot|Aboundex|domaincrawler|wbsearchbot|summify|ccbot|edisterbot|seznambot|ec2linkfinder|gslfbot|aihitbot|intelium_bot|facebookexternalhit|yeti|RetrevoPageAnalyzer|lb\-spider|sogou|lssbot|careerbot|wotbox|wocbot|ichiro|DuckDuckBot|lssrocketcrawler|drupact|webcompanycrawler|acoonbot|openindexspider|gnam gnam spider|web\-archive\-net\.com\.bot|backlinkcrawler|coccoc|integromedb|content crawler spider|toplistbot|seokicks\-robot|it2media\-domain\-crawler|ip\-web\-crawler\.com|siteexplorer\.info|elisabot|proximic|changedetection|blexbot|arabot|WeSEE:Search|niki\-bot|CrystalSemanticsBot|rogerbot|360Spider|psbot|InterfaxScanBot|Lipperhey SEO Service|CC Metadata Scaper|g00g1e\.net|GrapeshotCrawler|urlappendbot|brainobot|fr\-crawler|binlar|SimpleCrawler|Livelapbot|Twitterbot|cXensebot|smtbot|bnf\.fr_bot|A6\-Indexer|ADmantX|Facebot|Twitterbot|OrangeBot|memorybot|AdvBot|MegaIndex|SemanticScholarBot|ltx71|nerdybot|xovibot|BUbiNG|Qwantify|archive\.org_bot|Applebot|TweetmemeBot|crawler4j|findxbot|SemrushBot|yoozBot|lipperhey|y!j\-asr|Domain Re\-Animator Bot|AddThis)";
    if (preg_match("/{$botRegexPattern}/", $_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }

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
        "Cherkas'ka Oblast'" => 'cherkassy',
        "Chernihiv/Chernihiv" => 'chernigov',
        "Chernihiv" => 'chernigov',
        "Chernivtsi/Chernivtsi" => 'chernovtsy',
        "Chernivtsi" => 'chernovtsy',
        "Dnipro/Dnipro" => 'dnepr',
        "Dnipro" => 'dnepr',
        "Donetsk/Donets'ka Oblast'" => 'donetsk',
        "Donets'ka Oblast'" => 'donetsk',
        "Ivano-Frankivs'k/Ivano-Frankivs'ka Oblast'" => 'ivano-frankovsk',
        "Ivano-Frankivs'ka Oblast'" => 'ivano-frankovsk',
        "Kharkiv/Kharkivs'ka Oblast'" => 'kharkov',
        "Kharkivs'ka Oblast'" => 'kharkov',
        "Kherson/Khersons'ka Oblast'" => 'kherson',
        "Khersons'ka Oblast'" => 'kherson',
        "Khmelnytskyi/Khmel'nyts'ka Oblast'" => 'khmelnitskiy',
        "Khmel'nyts'ka Oblast'" => 'khmelnitskiy',
        "Kropyvnytskyi/Kropyvnytskyi" => 'kropivnitskiy',
        "Kropyvnytskyi" => 'kropivnitskiy',
        "Kiev/Kyiv" => 'kiev',
        "Kyiv" => 'kiev',
        "Kyiv City" => 'kiev',
        "Lviv/L'vivs'ka Oblast'" => 'lvov',
        "L'vivs'ka Oblast'" => 'lvov',
        "Luhansk/Luhans'ka Oblast'" => 'lugansk',
        "Luhans'ka Oblast'" => 'lugansk',
        "Mykolayiv/Mykolayivs'ka Oblast'" => 'nikolaev',
        "Mykolayivs'ka Oblast'" => 'nikolaev',
        "Odesa/Odessa" => 'odessa',
        "Odessa" => 'odessa',
        "Poltava/Poltavs'ka Oblast'" => 'poltava',
        "Poltavs'ka Oblast'" => 'poltava',
        "Rivne/Rivnens'ka Oblast'" => 'rovno',
        "Rivnens'ka Oblast'" => 'rovno',
        "Sumy/Sums'ka Oblast'" => 'sumy',
        "Sums'ka Oblast'" => 'sumy',
        "Ternopil/Ternopil's'ka Oblast'" => 'ternopol',
        "Ternopil's'ka Oblast'" => 'ternopol',
        "Vinnytsia/Vinnyts'ka Oblast'" => 'vinnitsa',
        "Vinnyts'ka Oblast'" => 'vinnitsa',
        "Lutsk/Volyns'ka Oblast'" => 'lutsk',
        "Volyns'ka Oblast'" => 'lutsk',
        "Uzhhorod/Transcarpathia" => 'uzhgorod',
        "Transcarpathia" => 'uzhgorod',
        "Zaporizhia/Zaporizhia" => 'zaporozhe',
        "Zaporizhia" => 'zaporozhe',
        "Zhytomyr/Zhytomyrs'ka Oblast'" => 'zhitomir',
        "Zhytomyrs'ka Oblast'" => 'zhitomir',
    );

    if (isset($data[$city . '/' . $region])) {
        return $data[$city . '/' . $region];
    } else if (isset($data[$region])) {
        return $data[$region];
    } else {
        return false;
    }
}
