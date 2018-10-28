<div class="master-item<?php if (get_field('master_is_pro', "user_" . get_the_author_meta('ID'))): ?> pro<?php endif; ?>"
     onclick="javascript:window.location='<?php echo esc_url( get_permalink() ); ?>';">
    <?php if (has_post_thumbnail()): ?>
        <div class="thumbnail">
            <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                <div class="avatar">
                    <?php the_post_thumbnail('pror-medium', array(
                            'alt' => pror_get_master_img_alt(),
                            'pror_no_scrset' => true,
                    )); ?>
                </div>
            </a>
        </div>
    <?php endif; ?>

    <div class="master-body">
        <h4 class="mt-0 mb-1">
            <a class="title" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a>
            <?php if (get_field('master_is_confirmed', "user_" . get_the_author_meta('ID'))): ?>
                <span class="oi oi-circle-check is-confirmed" data-toggle="tooltip" data-placement="top" title="Проверено"></span>
            <?php endif; ?>
        </h4>
        <div class="subtitle">
            <?php if (get_field('master_is_pro', "user_" . get_the_author_meta('ID'))): ?><span class="pro-label">PRO</span><?php endif; ?>
            <span class="type"><?php _e(get_field('master_type', "user_" . get_the_author_meta('ID')), 'common'); ?>,</span>
            <span class="location"><?php echo pror_get_section_name(pror_get_master_section()); ?></span>
        </div>
        <div class="rating d-none d-sm-block">
            <?php module_template('rating/total-inline'); ?>
        </div>

        <div class="catalog"><?php module_template('catalog_master/small-list'); ?></div>
    </div>
    <div class="clearfix"></div>
</div>
