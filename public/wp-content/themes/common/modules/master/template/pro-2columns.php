<?php
$query = new WP_Query(array(
    'post_type' => 'master',
    'posts_per_page' => 12,
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
?>

<?php if ($query->have_posts()): ?>
<div class="master-2columns pro">
    <div class="row">
        <div class="col-12">
            <h3>PRO мастера</h3>
        </div>
    </div>

    <div class="row">
        <?php $pos = 0; ?>
        <?php while ($query->have_posts()): $query->the_post(); $pos++;?>
            <div class="col-12 col-md-6 my-2">
                <?php module_template('master/item'); ?>
            </div>

            <?php if ($pos % 2 == 0): ?><div class="w-100"></div><?php endif; ?>
        <?php endwhile; ?>
    </div>
</div>
<?php else: ?>

    <?php
    $query = new WP_Query(array(
        'post_type' => 'master',
        'posts_per_page' => 12,
        'orderby' => 'rand',
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
//        'meta_query' => array(array('key' => '_thumbnail_id')),
    ));
    ?>
    <div class="master-2columns">
        <div class="row">
            <div class="col-12">
                <h3>Мастера</h3>
            </div>
        </div>

        <div class="row">
            <?php $pos = 0; ?>
            <?php while ($query->have_posts()): $query->the_post(); $pos++;?>
                <div class="col-12 col-lg-6 my-2">
                    <?php module_template('master/item'); ?>
                </div>

                <?php if ($pos % 2 == 0): ?><div class="w-100"></div><?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>
