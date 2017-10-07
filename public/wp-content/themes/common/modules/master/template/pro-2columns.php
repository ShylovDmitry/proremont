<?php
$query = new WP_Query(array(
    'post_type' => 'master',
    'posts_per_page' => 12,
    'orderby' => 'rand',
    'tax_query' => array(
        array(
            'taxonomy' => 'location',
            'terms' => get_field('locations', pror_get_section()),
            'include_children' => false,
            'operator' => 'IN',
        ),
    ),
    'meta_query' => array(
        array(
            'key' => 'master_is_pro',
            'value' => 1,
        ),
    ),
));
?>

<?php if ($query->have_posts()): ?>
<div class="master-2columns">
    <div class="row">
        <div class="col-12">
            <h3>PRO мастера</h3>
        </div>
    </div>

    <div class="row">
        <?php $pos = 0; ?>
        <?php while ($query->have_posts()): $query->the_post(); $pos++;?>
            <div class="col-6 my-2">
                <?php module_template('master/item'); ?>
            </div>

            <?php if ($pos % 2 == 0): ?><div class="w-100"></div><?php endif; ?>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>
