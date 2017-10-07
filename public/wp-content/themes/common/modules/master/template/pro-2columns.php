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
                <div class="item">
                    <div class="media mb-2">
                        <a href="<?php echo esc_url( get_permalink() ); ?>">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('pror-medium', array( 'class' => 'd-flex mr-3' )); ?>
                            <?php else: ?>
                                <img src="http://via.placeholder.com/100" class="wp-post-image d-flex mr-3" />
                            <?php endif; ?>
                        </a>
                        <div class="media-body">
                            <div class="rating">
                            <?php
                                $instance = array(
                                    'enabled' => 2,
                                    'displaystyle' => 'grey',
                                    'displayaverage' => 1,
                                    'displaytotalratings' => 1,
                                    'filtercomments' => 1,
                                    'totalratingsbefore' => '<a href="' . get_permalink() . '#comments"><span>Отзывы (</span>',
                                    'totalratingsafter' => '<span>)</span></a>',
                                );
                                if ( function_exists( 'display_average_rating' ) ) {
                                    display_average_rating( $instance );
                                }
                            ?>
                            </div>

                            <h5 class="mt-0 mb-1">
                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                            </h5>
                            <div class="type"><?php the_field('master_type'); ?></div>
                            <div class="location"><?php echo pror_get_master_location(); ?></div>
                            <div class="catalog"><?php module_template('catalog_master/icons'); ?></div>
                        </div>
                    </div>
                    <div class="description">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </div>

            <?php if ($pos % 2 == 0): ?><div class="w-100"></div><?php endif; ?>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>
