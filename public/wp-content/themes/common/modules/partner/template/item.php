<div class="partner-item col-3 mb-3">
    <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
        <div class="avatar">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium', array(
                        'alt' => get_the_title(),
                        'pror_no_scrset' => true,
                )); ?>
            <?php else: ?>
                <img src="<?php module_img('master/no-avatar.png'); ?>" />
            <?php endif; ?>
        </div>
    </a>
<!--    <a href="--><?php //echo esc_url( get_permalink() ); ?><!--" title="--><?php //echo esc_attr(get_the_title()); ?><!--">-->
<!--        <h5 class="text-center pt-3">--><?php //the_title(); ?><!--</h5>-->
<!--    </a>-->
</div>
