<?php $pos = 0; ?>
<?php while (have_posts()): the_post(); $pos++; ?>
    <div class="colored-box p-3 mb-3">
        <article>
            <div class="post-image mb-3">
                <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                    <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                </a>
            </div>
            <h3><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></h3>
            <div class="excerpt">
                <?php the_excerpt(); ?>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="post-date"><?php echo get_the_date(); ?></div>
                </div>
                <div class="col-6 text-right">
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(get_the_title()); ?>" class="post-more-link">Подробнее &raquo;</a>
                </div>
            </div>
        </article>
    </div>

    <?php if ($pos == 1): ?>
        <div class="mb-3 d-lg-none">
            <?php module_template('banner/mobile'); ?>
        </div>
    <?php endif; ?>
<?php endwhile; ?>

<?php module_template('theme/pagination', array('container_class' => 'colored-box p-3')); ?>
