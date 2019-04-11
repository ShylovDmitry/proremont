<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <div class="colored-box p-3">
                <h1 class="page-title header-underlined"><?php the_title(); ?></h1>

                <?php module_template('tender/list'); ?>
            </div>

            <?php if (get_the_content() && get_query_var('paged') <= 1): ?>
                <div class="colored-box mt-3 p-3">
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <?php module_template('prom/sidebar-col'); ?>
    </div>
</div>

<?php get_footer(); ?>
