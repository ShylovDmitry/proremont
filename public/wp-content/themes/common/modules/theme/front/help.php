<?php

//add_action('init', function() {
//    $str = 'Киевская область>Киев';
//    list($parent, $child) = explode('>', $str);
//    $par = get_term_by('name', $parent, 'location');
//    $term = get_terms('location', [
//        'name' => $child,
//        'parent' => $par->term_id,
//    ]);
//
//    var_dump($term[0]->term_id, $par, $term);exit;
//}, 11);


//function rus2translit($string) {
//    $converter = array(
//        'а' => 'a',   'б' => 'b',   'в' => 'v',
//        'г' => 'g',   'д' => 'd',   'е' => 'e',
//        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
//        'и' => 'i',   'й' => 'y',   'к' => 'k',
//        'л' => 'l',   'м' => 'm',   'н' => 'n',
//        'о' => 'o',   'п' => 'p',   'р' => 'r',
//        'с' => 's',   'т' => 't',   'у' => 'u',
//        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
//        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
//        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
//        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
//        'і' => 'i',   'ї' => 'yi',  'є' => 'e',
//
//
//        'А' => 'A',   'Б' => 'B',   'В' => 'V',
//        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
//        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
//        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
//        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
//        'О' => 'O',   'П' => 'P',   'Р' => 'R',
//        'С' => 'S',   'Т' => 'T',   'У' => 'U',
//        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
//        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
//        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
//        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
//        'І' => 'I',   'Ї' => 'Yi',  'Є' => 'E',
//    );
//    return strtr($string, $converter);
//}
//
//add_action('init', function() {
//    $str = "
//# Строительство
//Строительство под ключ
//-
//Фундаментные работы
//Фасадные работы
//Монтаж и ремонт кровли
//Ремонт и отделка - Демонтажные работы
//Строительство заборов
//Сварочные работы
//Буровые работы
//Кладка печей и каминов
//-
//Возведение домов
//Возведение гаражей
//Возведение бань
//Услуги каменщика
//Бетонные работы
//Кузнечные работы
//Столярные и плотницкие работы
//Изготовление и монтаж металлоконструкций
//Рольставни, роллеты, секционные ворота
//Изготовление и монтаж теплиц
//Быстровозводимые строения
//Изготовление и монтаж ограждений
//Изготовление и монтаж лестниц
//
//# Инженерные работы
//Сантехнические работы
//Канализация и водоснабжение
//Монтаж и ремонт кондиционеров
//Электромонтажные работы
//Монтаж сетей и линий связи
//Системы видеонаблюдения
//Газификация
//Изоляционные работы
//Монтаж и ремонт систем отопления
//Монтаж и ремонт систем вентиляции
//Монтаж теплых полов
//Токарные работы
//Системы пожарной безопасности
//
//# Ремонт и отделка
//Ремонт под ключ и отделка
//Отделка стен
//Монтаж гипсокартона
//Плиточные работы
//Отделка полов
//Отделка потолков
//Ремонт санузла
//
//# Дизайн и оформление
//-
//Дизайн интерьеров
//Декорирование
//Художественная роспись стен
//Текстильный дизайн
//Аэрография
//
//# Двери
//
//# Окна
//Установка окон
//Двери - Установка межкомнатных дверей
//Двери - Установка входных дверей
//Отделка и остекление балконов
//Жалюзи
//
//# Мебель
//Изготовление и установка кухонь
//Сборка мебели
//
//# Благоустройство территории
//Ландшафтный дизайн
//Строительство - Земляные работы
//Уборка территорий
//Строительство бассейнов
//Строительство фонтанов
//
//# Дополнительные услуги
//Мебель - Изготовление мебели
//-
//Грузоперевозки
//Инженерные работы - Промышленный альпинизм
//-
//Составление смет
//Уборка помещения
//";
//    foreach (explode("\n", $str) as $a) {
//        echo str_replace([',', "'"], '', str_replace(' ', '-', strtolower(rus2translit($a)))) . "\n";
//    }
//
//    exit;
//}, 11);

//add_action('init', function() {
//    $str = 'Отделочные работы и ремонт>Комплексный ремонт под ключ|Отделочные работы и ремонт>Малярные и штукатурные работы|Строительные работы>Фундамент и бетонные работы|Строительные работы>Фасадные работы|Строительные работы>Снос зданий, демонтаж|Инженерно-монтажные работы>Сантехнические работы|Инженерно-монтажные работы>Отопление и водоснабжение';
//
//    $ids = [];
//    foreach (explode('|', $str) as $s) {
//        list($parent, $child) = explode('>', $s);
//        $par = get_term_by('name', $parent, 'catalog_master');
//        $term = get_terms('catalog_master', [
//            'name' => $child,
//            'parent' => $par->term_id,
//        ]);
//        if (isset($term[0])) {
//            $ids[] = '' . $term[0]->term_id;
//        }
//    }
//
//    var_dump(serialize($ids));exit;
//}, 11);

//add_action('init', function() {
//    if (isset($_GET['pror_offset'])) {
//        $users = get_users([
//            'role' => 'master',
//            'number' => isset($_GET['pror_limit']) ? $_GET['pror_limit'] : 100,
//            'offset' => $_GET['pror_offset'],
//            'orderby' => 'ID',
//            'fields' => ['ID'],
//        ]);
//        foreach ($users as $user) {
//            var_dump($user->ID);
//            pror_update_master_info($user->ID);
//        }
//        exit;
//    }
//}, 11);

//add_action('init', function() {
//    if (isset($_GET['pror_offset'])) {
//        $bad_tax = array( 643, 607, 648, 635, 630, 611, 618, 620, 650 );
//        $pp = new WP_Query([
//            'post_type' => 'master',
//            'post_status' => 'any',
//            'posts_per_page' => isset($_GET['pror_limit']) ? $_GET['pror_limit'] : 100,
//            'offset' => $_GET['pror_offset'],
//            'orderby' => 'ID',
//            'tax_query' => array(
//                array(
//                    'taxonomy' => 'catalog_master',
//                    'terms' => $bad_tax,
//                    'include_children' => false,
//                    'operator' => 'IN',
//                ),
//            ),
//        ]);
//        $c = 0;
//        while ($pp->have_posts()) {
//            $c++;
//            $pp->the_post();
//
//            global $post;
//            $user_id = $post->post_author;
//            $master_post_id = get_the_ID();
//            $terms = wp_get_post_terms( $master_post_id, 'catalog_master', ['fields'=>'ids']);
//            $catalog_terms = array_diff($terms, $bad_tax);
//
//            update_user_meta( $user_id, 'master_catalog', $catalog_terms );
//
//            wp_set_post_terms($master_post_id, $catalog_terms, 'catalog_master');
//
//            wp_update_post(array(
//                'ID' => $master_post_id,
//                'post_status' => ($catalog_terms) ? 'publish' : 'draft',
//            ));
//
//        }
//        var_dump($c);
//
//        exit;
//    }
//}, 11);

//add_action('init', function() {
//    if (isset($_GET['pror_offset'])) {
//
//        $section = get_term_by('slug', 'kharkov', 'section');
//        $locations = get_field('locations', 'section_' . $section->term_id);
//
//
//        $pp = new WP_Query([
//            'post_type' => 'master',
//            'post_status' => 'any',
//            'posts_per_page' => isset($_GET['pror_limit']) ? $_GET['pror_limit'] : 10000,
//            'offset' => $_GET['pror_offset'],
//            'orderby' => 'ID',
//            'tax_query' => array(
//                array(
//                    'taxonomy' => 'location',
//                    'terms' => $locations,
//                    'include_children' => false,
//                    'operator' => 'IN',
//                ),
//            ),
//        ]);
//
//        echo '<table>';
//        echo '<tr>
//            <th>ID</th>
//            <th>user_login</th>
//            <th>Title</th>
//            <th>Phone</th>
//            <th>Admin Area</th>
//            <th>View Page</th>
//            <th>Comment</th>
//        </tr>';
//
//        $c = 0;
//        while ($pp->have_posts()) {
//            $c++;
//            $pp->the_post();
//
//            global $post;
//            $user_id = $post->post_author;
//            $user = get_user_by('ID', $user_id);
//            $master_post_id = get_the_ID();
//
//            echo '<tr>
//                <td>' . $user_id . '</td>
//                <td>' . $user->user_login . '</td>
//                <td>' . get_field('master_title', 'user_'.$user_id) . '</td>
//                <td>' . implode('<br/>', array_map(function($value) { return $value['text']; }, pror_get_master_phones($user_id))) . '</td>
//                <td>https://proremont.co/wp/wp-admin/user-edit.php?user_id=' . $post->post_author . '</td>
//                <td>' . str_replace('http://proremont.local', 'https://proremont.co', get_the_permalink($master_post_id)) . '</td>
//                <td></td>
//            </tr>';
//
//
//        }
//
//        echo '</table>';
//
//        exit;
//    }
//}, 11);

//add_action('init', function() {
//    if (isset($_GET['pror_offset'])) {
//        $users = get_users([
//            'role' => 'master',
//            'number' => isset($_GET['pror_limit']) ? $_GET['pror_limit'] : 10000,
//            'offset' => $_GET['pror_offset'],
//            'orderby' => 'ID',
//        ]);
//
//
//
//        echo '<table>';
//        echo '<tr>
//            <th>ID</th>
//            <th>Name</th>
//            <th>Email</th>
//            <th>Phone</th>
//            <th>Region</th>
//            <th>Town</th>
//            <th>Link</th>
//            <th>Catalog</th>
//            <th>Confirmed</th>
//            <th>Type</th>
//        </tr>';
//
//        $c = 0;
//        foreach ($users as $user) {
//            if (strpos($user->user_email, 'ProRemont.Catalog+') === 0) {
//                continue;
//            }
//            $c++;
//
//            $user_id = $user->ID;
//
//            $phone = '';
//            foreach (pror_get_master_phones($user_id) as $phone) {
//                $phone = $phone['tel'];
//                if (strpos($phone, '+38044') === 0 || strpos($phone, '+38032') === 0) {
//                    continue;
//                }
//                break;
//            }
//
//            $master_region = '';
//            $master_town = '';
//            $master_link = '';
//            $master_catalog = '';
//
//            $posts = get_posts(array(
//                'author' => $user_id,
//                'posts_per_page' => 1,
//                'post_type' => 'master',
//                'post_status' => 'any',
//            ));
//            $post_id = isset($posts, $posts[0], $posts[0]->ID) ? $posts[0]->ID : false;
//            if ($post_id) {
//                $master_link = get_permalink($post_id);
//
//                $catalogs = [];
//                $catalogs[] = '';
//                foreach (pror_get_master_catalogs($post_id) as $cat) {
//                    $catalogs[] = $cat->name;
//                    foreach ($cat->children as $child) {
//                        $catalogs[] = $child->name;
//                    }
//                }
//                $catalogs[] = '';
//                $master_catalog = implode('|', $catalogs);
//
//
//                $loc = pror_get_master_location($post_id);
//                if ($loc) {
//                    $master_region = $loc[0];
//                    $master_town = $loc[1];
//                }
//            }
//
//
//
//            echo '<tr>
//                <td>' . $user_id . '</td>
//                <td>' . get_field('master_title', "user_{$user_id}") . '</td>
//                <td>' . $user->user_email . '</td>
//                <td>' . $phone . '</td>
//                <td>' . $master_region . '</td>
//                <td>' . $master_town . '</td>
//                <td>' . str_replace('http://proremont.local', 'https://proremont.co', $master_link) . '</td>
//                <td>' . $master_catalog . '</td>
//                <td>' . (get_field('master_is_confirmed', "user_{$user_id}") ? '1' : '') . '</td>
//                <td>' . get_field('master_type', "user_{$user_id}") . '</td>
//                <td></td>
//            </tr>';
//
//
//        }
//
//        echo '</table>';
//
//        exit;
//    }
//}, 11);
