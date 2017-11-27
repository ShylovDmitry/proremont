<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col colored-box py-3">
            <?php module_template('master/detailed'); ?>
        </div>

        <div class="col col-md-12 col-300">
            <?php module_template('banner/sidebar'); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
