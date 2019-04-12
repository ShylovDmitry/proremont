<?php
$exclude_master_id = isset($__data['exclude_master_id']) ? $__data['exclude_master_id'] : '';
$catalog_ids = isset($__data['catalog_ids']) ? $__data['catalog_ids'] : '';
$container_class = isset($__data['container_class']) ? $__data['container_class'] : '';
$display_native = isset($__data['display_native']) ? $__data['display_native'] : 1;
$display_mobile = isset($__data['display_mobile']) ? $__data['display_mobile'] : 1;
?>

<?php
$cache_obj = pror_cache_obj(10*60, 'section,lang', 'pror:master:list:related', 'block', $container_class, implode(',', $catalog_ids), $exclude_master_id, $display_native, $display_mobile);
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<?php
$number_of_masters = 6;
$unique_ids = [$exclude_master_id];

$pro_masters_query = new WP_Query(array(
    'post__not_in' => $unique_ids,
    'post_type' => 'master',
    'posts_per_page' => min(2, $number_of_masters),
    'orderby' => 'rand',
    'author__in' => pror_get_query_pro_master_ids(),
    'tax_query' => array(
        array(
            'taxonomy' => 'location',
            'terms' => get_field('locations', pror_detect_section()),
            'include_children' => false,
            'operator' => 'IN',
        ),
        array(
            'taxonomy' => 'catalog_master',
            'terms' => $catalog_ids,
            'include_children' => false,
            'operator' => 'IN',
        ),
    ),
));
while ($pro_masters_query->have_posts()) {
    $pro_masters_query->the_post();
    $unique_ids[] = get_the_ID();
}

$rated_masters_query = null;
if (count($unique_ids) < $number_of_masters) {
    $rated_masters_query = new WP_Query(array(
        'post__not_in' => $unique_ids,
        'post_type' => 'master',
        'posts_per_page' => $number_of_masters - count($unique_ids) + 1,
        'meta_key' => 'pror-crfp-lower-bound',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'catalog_master',
                'terms' => $catalog_ids,
                'include_children' => false,
                'operator' => 'IN',
            ),
            array(
                'taxonomy' => 'location',
                'terms' => get_field('locations', pror_detect_section()),
                'include_children' => false,
                'operator' => 'IN',
            ),
        ),
    ));

    while ($rated_masters_query->have_posts()) {
        $rated_masters_query->the_post();
        $unique_ids[] = get_the_ID();
    }
}

$masters_query = null;
if ($rated_masters_query) {
    if (count($unique_ids) < $number_of_masters) {
        $masters_query = new WP_Query(array(
            'post__not_in' => $unique_ids,
            'post_type' => 'master',
            'posts_per_page' => $number_of_masters - count($unique_ids) + 1,
            'orderby' => 'rand',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'catalog_master',
                    'terms' => $catalog_ids,
                    'include_children' => false,
                    'operator' => 'IN',
                ),
                array(
                    'taxonomy' => 'location',
                    'terms' => get_field('locations', pror_detect_section()),
                    'include_children' => false,
                    'operator' => 'IN',
                ),
            ),
            'custom_query' => 'with_logo',
        ));
    }
}
?>

<?php if ($pro_masters_query->have_posts() || $rated_masters_query->have_posts() || $masters_query->have_posts()): ?>
    <div class="<?php echo $container_class; ?>">
        <div class="master-2columns">
            <div class="row">
                <div class="col-12 mb-1">
                    <h4 class="header-underlined"><?php _e('Похожие мастера', 'common'); ?></h4>
                </div>
            </div>

            <div class="row">
                <?php $pos = 0; ?>
                <?php while ($pro_masters_query->have_posts()): $pro_masters_query->the_post(); $pos++; ?>
                    <div class="col-12">
                        <?php module_template('master/item'); ?>
                    </div>

                    <?php if ($pos == 1 && $display_native): ?>
                        <div class="col-12">
                            <?php module_template('prom/native1'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($pos == 2 && $display_mobile): ?>
                        <div class="col-12 d-lg-none">
                            <?php module_template('prom/mobile1'); ?>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>

                <?php if ($rated_masters_query): ?>
                    <?php while ($rated_masters_query->have_posts()): $rated_masters_query->the_post(); $pos++; ?>
                        <div class="col-12">
                            <?php module_template('master/item'); ?>
                        </div>

                        <?php if ($pos == 1 && $display_native): ?>
                            <div class="col-12">
                                <?php module_template('prom/native1'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($pos == 2 && $display_mobile): ?>
                            <div class="col-12 d-lg-none">
                                <?php module_template('prom/mobile1'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>

                <?php if ($masters_query): ?>
                    <?php while ($masters_query->have_posts()): $masters_query->the_post(); $pos++; ?>
                        <div class="col-12">
                            <?php module_template('master/item'); ?>
                        </div>

                        <?php if ($pos == 1 && $display_native): ?>
                            <div class="col-12">
                                <?php module_template('prom/native1'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($pos == 2 && $display_mobile): ?>
                            <div class="col-12 d-lg-none">
                                <?php module_template('prom/mobile1'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-1">
            <a href="<?php echo pror_get_permalink_by_slug('catalog'); ?>" class="btn masters-see-all"><?php _e('Смотреть всех мастеров', 'common'); ?></a>
        </div>
    </div>
<?php endif; ?>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
