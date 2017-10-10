<?php get_header(); ?>

<?php module_template('banner/top'); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container colored-box py-3">
    <div class="row">
        <div class="col">
            <?php module_template('master/detailed'); ?>
        </div>

        <div class="col-300">
            <?php module_template('banner/sidebar'); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
