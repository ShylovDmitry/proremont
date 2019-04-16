<?php
$cache_obj = pror_cache_obj(0, '', 'pror:blog:list', 'main');
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<?php $pos = 0; ?>
<?php while (have_posts()): the_post(); $pos++; ?>
    <div class="colored-box px-3 pb-3 mb-3">
        <article>
            <?php if (has_post_thumbnail()): ?>
                <div class="post-image">
                    <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                        <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                    </a>
                </div>
            <?php endif; ?>
            <h3 class="pt-3"><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></h3>

            <div class="header-underlined mb-3">
                <div class="post-date"><?php echo get_the_date(); ?></div>
                <div class="post-categories"><?php module_template('blog/categories'); ?></div>
            </div>

            <div class="excerpt">
                <?php the_excerpt(); ?>
            </div>
            <div class="row">
                <div class="col-7 col-md-9">
                    <div class="post-catalogs">
                        <?php module_template('blog/catalog_master'); ?>
                    </div>
                </div>
                <div class="col-5 col-md-3 text-right">
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(get_the_title()); ?>" class="post-more-link"><?php _e('Подробнее', 'common'); ?> &raquo;</a>
                </div>
            </div>
        </article>
    </div>

    <?php if ($pos == 1): ?>
        <div class="mb-3 d-lg-none">
            <?php module_template('prom/mobile1'); ?>
        </div>
    <?php endif; ?>
<?php endwhile; ?>

<?php module_template('theme/pagination', array('container_class' => 'colored-box p-3')); ?>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
