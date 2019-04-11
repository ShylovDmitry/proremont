<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="colored-box p-3 content">

                <?php if (have_posts()): the_post(); ?>
                    <h1 class="page-title header-underlined"><?php the_title(); ?></h1>
                    <?php the_content(); ?>

                    <div class="d-flex justify-content-center mb-3 mt-4">
                        <?php echo do_shortcode('[oa_social_sharing_icons]'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php module_template('prom/sidebar-col'); ?>
    </div>
</div>

<?php get_footer(); ?>
