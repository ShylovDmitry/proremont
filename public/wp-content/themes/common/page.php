<?php get_header(); ?>

<?php get_template_part('breadcrumb'); ?>

<div class="container colored-box py-3">
    <div class="row">
        <div class="col">

            <?php if (have_posts()): the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>
