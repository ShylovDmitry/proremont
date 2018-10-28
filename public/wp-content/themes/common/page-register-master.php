<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="colored-box p-3">
                <?php module_template('profile/register-master'); ?>
            </div>
        </div>

        <?php module_template('prom/sidebar-col'); ?>
    </div>
</div>

<?php get_footer(); ?>
