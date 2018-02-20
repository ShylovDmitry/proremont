<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <?php module_template('blog/detailed'); ?>

            <?php module_template('blog/related-posts', array('main_post_id' => get_the_ID(), 'container_class' => 'colored-box mt-3 p-3')); ?>
        </div>

        <?php module_template('banner/sidebar-col'); ?>
    </div>
</div>

<?php get_footer(); ?>
