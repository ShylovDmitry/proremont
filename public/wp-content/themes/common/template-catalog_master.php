<?php /* Template Name: Catalog Master */ ?>

<?php get_header(); ?>

<?php module_template('banner/top'); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<?php if (have_posts()): the_post(); ?>
    <div class="container colored-box py-3">
        <div class="row">
            <div class="col">
                <?php module_template('catalog_master/1column'); ?>
            </div>

            <div class="col col-300">
                <?php module_template('banner/sidebar'); ?>
            </div>

        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>
