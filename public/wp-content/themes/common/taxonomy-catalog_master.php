<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row master-list-block">
        <div class="col">
            <div class="colored-box p-3">
                <?php module_template('searchbox/form'); ?>

                <hr class="row my-4" />

                <?php module_template('master/list'); ?>
            </div>

            <?php if (term_description() && get_query_var('paged') <= 1): ?>
                <div class="colored-box mt-3 p-3">
                    <div class="term-description"><?php echo term_description(); ?></div>
                </div>
            <?php endif; ?>
        </div>

        <?php module_template('prom/sidebar-col'); ?>

    </div>
</div>

<?php get_footer(); ?>
