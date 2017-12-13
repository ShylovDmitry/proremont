<div class="master-item<?php if (get_field('master_is_pro', "user_" . get_the_author_meta('ID'))): ?> master-item-pro<?php endif; ?>">
    <div class="media mb-2">
        <div class="left">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('pror-medium'); ?>
                <?php else: ?>
                    <img src="<?php module_img('master/no-avatar.png'); ?>" />
                <?php endif; ?>
            </a>
            <div class="rating d-sm-none">
                <?php module_template('rating/total'); ?>
            </div>
        </div>

        <div class="media-body">
            <div class="rating d-none d-sm-block">
                <?php module_template('rating/total'); ?>
            </div>

            <h5 class="mt-0 mb-1">
                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                <?php if (get_field('master_is_confirmed', "user_" . get_the_author_meta('ID'))): ?>
                    <span class="oi oi-circle-check is-confirmed" data-toggle="tooltip" data-placement="top" title="Проверено"></span>
                <?php endif; ?>
            </h5>
            <div class="type"><?php the_field('master_type', "user_" . get_the_author_meta('ID')); ?></div>
            <div class="location"><?php echo pror_get_master_location(); ?></div>
            <div class="catalog"><?php module_template('catalog_master/icons'); ?></div>
        </div>
    </div>
    <div class="excerpt">
        <?php the_excerpt(); ?>

        <div class="more">
            <a href="<?php echo esc_url( get_permalink() ); ?>">Переглянути &raquo;</a>
        </div>
    </div>
</div>
