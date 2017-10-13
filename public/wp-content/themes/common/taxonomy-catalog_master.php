<?php get_header(); ?>

<?php module_template('banner/top'); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container colored-box py-3">
    <div class="row switch-catalog-block">
        <div class="col-12">
            <a class="button" data-toggle="collapse" href="#catalogBlock" aria-expanded="false" aria-controls="catalogBlock"><span class="oi oi-grid-two-up"></span> Другие услуги</a>

            <div class="collapse" id="catalogBlock">
                <?php module_template('catalog_master/3columns'); ?>
            </div>

            <hr />
        </div>
    </div>
    <div class="row master-list-block">
        <div class="col">
            <h1 class="d-inline-block"><?php single_term_title() ?> - <?php echo pror_get_section()->name; ?></h1>

            <div class="row">
                <div class="col">
                    <?php wp_nav_menu(array(
                            'container' => false,
                            'menu_class' => 'list-unstyled list-inline my-0 text-right',
                            'theme_location' => 'master_filter_page',
                    )); ?>
                </div>
            </div>

            <?php module_template('master/list'); ?>
        </div>

        <div class="col col-md-12 col-300">
            <?php module_template('banner/sidebar'); ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
