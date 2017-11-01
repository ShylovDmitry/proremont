<?php get_header(); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">


            <?php module_template('breadcrumbs/breadcrumbs'); ?>

            <div class="row">
                <div class="col colored-box py-3 content">

                    <?php if (have_posts()): the_post(); ?>
                        <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    <?php endif; ?>

                </div>
            </div>




        </div>
    </div>
</div>

<?php get_footer(); ?>
