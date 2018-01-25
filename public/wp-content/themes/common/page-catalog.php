<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="colored-box p-3">

            <?php if (have_posts()): the_post(); ?>
                <h1 class="page-title header-underlined"><?php the_title(); ?></h1>

                <?php module_template('catalog_master/page'); ?>

                <div class="content">
                    <div class="header-underlined mb-4">&nbsp;</div>
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

            </div>
        </div>

        <?php module_template('banner/sidebar-col'); ?>
    </div>
</div>

<?php get_footer(); ?>
