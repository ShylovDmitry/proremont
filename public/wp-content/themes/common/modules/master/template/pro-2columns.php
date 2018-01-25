<?php
$number_of_masters = 12;
$unique_ids = array();

$pro_masters_query = new WP_Query(array(
    'post_type' => 'master',
    'posts_per_page' => $number_of_masters,
    'orderby' => 'rand',
    'author__in' => pror_get_query_pro_master_ids(),
    'tax_query' => array(
        array(
            'taxonomy' => 'location',
            'terms' => get_field('locations', pror_get_section()),
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
        'posts_per_page' => $number_of_masters - count($unique_ids),
        'meta_key' => 'pror-crfp-lower-bound',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'catalog_master',
                'operator' => 'EXISTS',
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
            'posts_per_page' => $number_of_masters - count($unique_ids),
            'orderby' => 'rand',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'catalog_master',
                    'operator' => 'EXISTS',
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

<div class="master-2columns">
    <div class="row">
        <div class="col-12 mb-3">
            <h3 class="header-underlined">Мастера</h3>
        </div>
    </div>

    <div class="row">
        <?php while ($pro_masters_query->have_posts()): $pro_masters_query->the_post(); ?>
            <div class="col-12">
                <?php module_template('master/item'); ?>
            </div>
        <?php endwhile; ?>

        <?php if ($rated_masters_query): ?>
            <?php while ($rated_masters_query->have_posts()): $rated_masters_query->the_post(); ?>
                <div class="col-12">
                    <?php module_template('master/item'); ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

        <?php if ($masters_query): ?>
            <?php while ($masters_query->have_posts()): $masters_query->the_post(); ?>
                <div class="col-12">
                    <?php module_template('master/item'); ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<div class="text-center">
    <a href="<?php echo home_url('/catalog/'); ?>" class="btn masters-see-all">Смотреть всех мастеров</a>
</div>
