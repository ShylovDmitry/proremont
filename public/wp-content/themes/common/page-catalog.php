<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <?php if (have_posts()): the_post(); ?>
                <div class="colored-box p-3">
                    <h1 class="page-title header-underlined"><?php the_title(); ?></h1>

                    <?php module_template('catalog_master/page'); ?>
                </div>

                <div class="colored-box mt-3 p-3">
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <?php module_template('banner/sidebar-col'); ?>
    </div>
</div>

<?php get_footer(); ?>
