<?php
$master_type = $_GET['mtype'];
?>

<?php
$cache_obj = pror_cache_obj(24*60*60, '', 'pror:master:list');
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<?php module_template('tender/alert-line'); ?>

<div class="master-list">
    <?php
    $query = new WP_Query(array(
        'post_type' => 'master',
        'posts_per_page' => 4,
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
                'field' => 'slug',
                'terms' => get_query_var('catalog_master'),
            ),
        ),
    ));
    ?>

    <div class="master-list-simple">
        <?php if ($query->have_posts() || have_posts()): ?>
            <?php $pos = 0; ?>

            <?php while ($query->have_posts()): $query->the_post(); $pos++; ?>
                <?php module_template('master/item'); ?>

                <?php if ($pos == 1): ?>
                    <?php module_template('prom/native1'); ?>
                <?php endif; ?>
                <?php if ($pos == 2): ?>
                    <div class="d-lg-none">
                        <?php module_template('prom/mobile1'); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>


            <?php while (have_posts()): the_post(); $pos++; ?>
                <?php module_template('master/item'); ?>

                <?php if ($pos == 1): ?>
                    <?php module_template('prom/native1'); ?>
                <?php endif; ?>
                <?php if ($pos == 2): ?>
                    <div class="d-lg-none">
                        <?php module_template('prom/mobile1'); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>

            <?php module_template('theme/pagination'); ?>
        <?php else: ?>
            <i><?php _e('Ничего не найдено. Проверьте этот раздел позже.', 'common'); ?></i>
        <?php endif; ?>
    </div>
</div>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
