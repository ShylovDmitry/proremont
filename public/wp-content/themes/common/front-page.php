<?php get_header(); ?>

<div class="jumbotron jumbotron-fluid header">
    <div class="container">
        <div class="frontpage-block">
            <div class="text-block">
                <?php _e('<div class="first">Всеукраинский бесплатный</div>
                <h1>ОНЛАЙН-КАТАЛОГ<span class="highlighted">МАСТЕРОВ</span></h1>
                <div class="last">для ремонта квартир, домов<br />и офисных помещений</div>', 'common'); ?>
            </div>

            <div class="buttons">
                <div class="find-master">
                    <a class="btn btn-primary btn-lg" href="<?php echo pror_get_permalink_by_slug('catalog'); ?>" role="button"><?php _e('Ищу исполнителя', 'common'); ?></a>
                    <div class="help"><?php _e('Каталог №1 в Украине', 'common'); ?></div>
                </div>

                <div class="iam-master">
                    <a class="btn btn-primary btn-lg" href="<?php echo pror_get_permalink_by_slug('informacia-dlya-masterov'); ?>" role="button"><?php _e('Я исполнитель', 'common'); ?></a>
                    <div class="help"><?php _e('Бесплатное размещение', 'common'); ?></div>
                </div>
            </div>

            <div class="mt-5">
                <a href="<?php echo pror_get_permalink_by_slug('reklama'); ?>" class="reklama-link"><?php _e('Реклама на сайте', 'common'); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="container my-4 frontpage-cons">
    <div class="row">
        <div class="col-4 text-align">
            <div class="item">
                <div class="circle">
                    <?php module_svg('theme/icon_master.svg'); ?>
                    <?php echo sprintf(__('<strong>%s</strong> мастеров', 'common'), '3 421'); ?>
                </div>
            </div>
        </div>
        <div class="col-4 text-center">
            <div class="item">
                <div class="circle">
                    <?php module_svg('theme/icon_rating.svg'); ?>
                    <?php _e('<strong>рейтинг</strong> и отзывы', 'common'); ?>
                </div>
            </div>
        </div>
        <div class="col-4 text-center">
            <div class="item">
                <div class="circle">
                    <?php module_svg('theme/icon_free.svg'); ?>
                    <?php _e('<strong>бесплатный</strong> каталог', 'common'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">

        <div class="col">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="colored-box p-3">
                        <?php module_template('catalog_master/list'); ?>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <?php module_template('partner/front-list', array('container_class' => 'colored-box p-3')); ?>
                </div>

                <div class="col-12 mb-3">
                    <?php module_template('master/front-list', array('container_class' => 'colored-box p-3')); ?>
                </div>

                <div class="col-12 mb-3">
                    <?php module_template('blog/latest-posts', array('container_class' => 'colored-box p-3')); ?>
                </div>

                <div class="col-12 mb-3">
                    <div class="colored-box p-3">
                        <?php module_template('theme/gallery'); ?>
                    </div>
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
