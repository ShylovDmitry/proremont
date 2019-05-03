<?php get_header(); ?>

<div class="jumbotron jumbotron-fluid header">
    <div class="container">
        <div class="text-block">
            <h1 class="mb-3"><?php _e('ДЕЛАЕШЬ <span>РЕМОНТ</span>?', 'common'); ?></h1>
            <span><?php _e('Найди мастеров, дизайнеров, строителей в один клик.', 'common'); ?></span>
        </div>

        <div class="mt-5">
            <?php module_template('searchbox/form', ['short_form' => true]); ?>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row">

        <div class="col">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="colored-box p-3">
                        <?php module_template('catalog_master/frontpage-list'); ?>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <?php module_template('master/front-list', array('container_class' => 'colored-box p-3')); ?>
                </div>

                <div class="col-12 mb-3">
		            <?php module_template('partner/front-list', array('container_class' => 'colored-box p-3')); ?>
                </div>

                <div class="col-12 mb-3">
                    <?php module_template('blog/latest-posts', array('container_class' => 'colored-box p-3')); ?>
                </div>

                <?php wp_reset_query(); ?>
                <?php if (get_the_content()): ?>
                    <div class="col-12">
                        <div class="colored-box p-3 homepage-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php module_template('prom/sidebar-col'); ?>

    </div>
</div>
<?php get_footer(); ?>
