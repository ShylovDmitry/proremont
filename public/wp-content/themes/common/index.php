<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="colored-box p-3">

                <?php while (have_posts()): the_post(); ?>
                    <article>
                        <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                        <div class="excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <?php echo get_the_date(); ?>
                            </div>
                            <div class="col-6 text-right">
                                <a href="<?php echo esc_url(get_permalink()); ?>">Читати</a>
                            </div>
                        </div>
                    </article>
                    <hr />
                <?php endwhile; ?>

                <?php get_template_part('pagination'); ?>
            </div>
        </div>

        <?php module_template('banner/sidebar-col'); ?>
    </div>
</div>

<?php get_footer(); ?>
