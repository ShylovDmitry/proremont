<div class="partner-slide slick-slide">
    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
        <div class="avatar">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('pror-medium', array(
                        'alt' => get_the_title(),
                        'pror_no_scrset' => true,
                )); ?>
            <?php else: ?>
                <img src="<?php module_img('master/no-avatar.png'); ?>" />
            <?php endif; ?>
        </div>
    </a>
</div>
