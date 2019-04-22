<?php
$cache_obj = pror_cache_obj(0, '', 'pror:tender:list');
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<?php module_template('tender/alert-line'); ?>

<div class="tender-list">
    <?php
    $params = array(
        'post_type' => 'tender',
        'post_status' => 'publish',
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => get_query_var('paged', 1),
        'orderby' => 'pror_tender_order',
//        'meta_query' => array(
//            array(
//                'key' => 'section',
//                'value' => pror_detect_section()->term_id,
//            ),
//        ),
    );

//    $path_catalog = get_query_var('catalog_master');
//    if ($path_catalog) {
//        $last_catalog = array_pop(explode('/', $path_catalog));
//        $term = get_term_by('slug', $last_catalog, 'catalog_master');
//
//        $params['tax_query'] = array(
//            array(
//                'taxonomy' => 'catalog_master',
//                'terms' => $term->term_id,
//            ),
//        );
//    }

    global $wp_query;
    $wp_query = new WP_Query($params);
    ?>

    <?php if ($wp_query->have_posts()): ?>
        <div class="tender-list-simple">
            <?php while ($wp_query->have_posts()): $wp_query->the_post();?>
                <?php module_template('tender/item'); ?>
            <?php endwhile; ?>
        </div>

        <?php module_template('theme/pagination'); ?>
    <?php else: ?>
        <i><?php _e('Ничего не найдено. Проверьте этот раздел позже.', 'common'); ?></i>
    <?php endif; ?>
</div>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
