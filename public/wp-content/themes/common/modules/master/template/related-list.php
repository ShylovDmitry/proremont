<?php
$exclude_master_id = isset($__data['exclude_master_id']) ? $__data['exclude_master_id'] : '';
$catalog_ids = isset($__data['catalog_ids']) ? $__data['catalog_ids'] : '';
$container_class = isset($__data['container_class']) ? $__data['container_class'] : '';
?>

<?php
$cache_expire = pror_cache_expire(10*60);
$cache_key = pror_cache_key(sprintf('block-%s-%s-%s', $container_class, implode(',', $catalog_ids), $exclude_master_id) , 'section');
$cache_group = 'pror:master:list:related';

$cache = wp_cache_get($cache_key, $cache_group);
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
            'terms' => get_field('locations', pror_get_section()),
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
                'terms' => get_field('locations', pror_get_section()),
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
                    'terms' => get_field('locations', pror_get_section()),
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
                    <h4 class="header-underlined">Похожие мастера</h4>
                </div>
            </div>

            <div class="row">
                <?php while ($pro_masters_query->have_posts()): $pro_masters_query->the_post(); ?>
                    <div class="col-12">
                        <?php module_template('master/item'); ?>
                    </div>
                <?php endwhile; ?>

                <?php $pos = 0; ?>
                <?php if ($rated_masters_query): ?>
                    <?php while ($rated_masters_query->have_posts()): $rated_masters_query->the_post(); $pos++; ?>
                        <div class="col-12">
                            <?php module_template('master/item'); ?>
                        </div>

                        <?php if ($pos == 1): ?>
                            <div class="col-12 d-lg-none">
                                <div class="master-item">
                                    <?php module_template('prom/mobile1'); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>

                <?php if ($masters_query): ?>
                    <?php while ($masters_query->have_posts()): $masters_query->the_post(); $pos++; ?>
                        <div class="col-12">
                            <?php module_template('master/item'); ?>
                        </div>

                        <?php if ($pos == 1): ?>
                            <div class="col-12 d-lg-none">
                                <div class="master-item">
                                    <?php module_template('prom/mobile1'); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-1">
            <?php $m_number = pror_catalog_get_count(); ?>
            <a href="<?php echo home_url('/catalog/'); ?>" class="btn masters-see-all">Смотреть <strong><?php echo $m_number; ?></strong> <?php echo pror_declension_words($m_number, ['мастера', 'мастеров', 'мастеров']); ?></a>
        </div>
    </div>
<?php endif; ?>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
