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
//        $bad_tax = array( 643, 607, 648, 635, 630, 611, 618 );
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
//        $section = get_term_by('slug', 'chernovtsy', 'section');
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
//                <td>' . str_replace('http://proremont.local', 'https://proremont.co', get_edit_user_link($post->post_author)) . '</td>
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
