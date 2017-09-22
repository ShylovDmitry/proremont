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
    <div class="row">
        <div class="col-12">
            <h3>PRO мастера</h3>
        </div>
    </div>

    <div class="row">
        <?php $pos = 0; ?>
        <?php while ($query->have_posts()): $query->the_post(); $pos++;?>
            <div class="col-4">
                <div class="media">
                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('pror-medium', array( 'class' => 'd-flex mr-3' )); ?>
                        <?php else: ?>
                            <img src="http://via.placeholder.com/100" class="wp-post-image d-flex mr-3" />
                        <?php endif; ?>
                    </a>
                    <div class="media-body">
                        <h5 class="mt-0 mb-1">
                            <?php if (get_field('master_is_pro')): ?>[PRO]<?php endif; ?>
                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_field('master_type'); ?> - <?php the_title(); ?></a>
                        </h5>
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </div>

            <?php if ($pos % 3 == 0): ?><div class="w-100 my-3"></div><?php endif; ?>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
