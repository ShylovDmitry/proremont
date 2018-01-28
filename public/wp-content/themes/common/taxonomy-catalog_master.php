<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row master-list-block">
        <div class="col">
            <div class="colored-box p-3">
                <div class="switch-catalog-block">
                    <a class="button" data-toggle="collapse" href="#catalogBlock" aria-expanded="false" aria-controls="catalogBlock"><span class="oi oi-grid-two-up"></span> Другие услуги</a>

                    <div class="collapse" id="catalogBlock">
                        <?php module_template('catalog_master/list'); ?>
                    </div>

                    <hr />
                </div>

                <h1 class="mb-3"><?php single_term_title() ?></h1>

                <?php module_template('master/list'); ?>

                <div class="term-description"><?php echo term_description(); ?></div>
            </div>
        </div>

        <?php module_template('banner/sidebar-col'); ?>

    </div>
</div>

<?php get_footer(); ?>
