<div class="master-item<?php if (get_field('master_is_pro')): ?> master-item-pro<?php endif; ?>">
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
                <?php module_template('rating/total'); ?>
            </div>

            <h5 class="mt-0 mb-1">
                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                <?php if (get_field('master_is_confirmed')): ?>
                    <small><span class="oi oi-circle-check ml-2 text-secondary" data-toggle="tooltip" title="Документи мастера подтверджени <br />Телефон подтвержден"></span></small>
                <?php endif; ?>
            </h5>
            <div class="type"><?php the_field('master_type'); ?></div>
            <div class="location"><?php echo pror_get_master_location(); ?></div>
            <div class="catalog"><?php module_template('catalog_master/icons'); ?></div>
        </div>
    </div>
    <div class="excerpt">
        <?php the_excerpt(); ?>
    </div>
</div>