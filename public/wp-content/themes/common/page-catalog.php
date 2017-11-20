<?php get_header(); ?>

<?php module_template('banner/top'); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col colored-box py-3">

            <?php if (have_posts()): the_post(); ?>
                <h1><?php the_title(); ?> - <?php echo pror_get_section()->name; ?></h1>

                <?php module_template('catalog_master/page'); ?>
            <?php endif; ?>
        </div>

        <div class="col col-md-12 col-300">
            <?php module_template('banner/sidebar'); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
