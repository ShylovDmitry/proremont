<?php get_header(); ?>

<div class="jumbotron jumbotron-fluid header">
    <div class="container frontpage-title">
        <h1>КАТАЛОГ МАСТЕРОВ</h1>
        <p class="lead mt-1">Найдите своего мастера по <strong>отзывам</strong></p>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 find-master">
                <a class="btn btn-primary btn-lg" href="<?php echo home_url('/catalog/'); ?>" role="button">Ищу специалиста</a>
                <div class="help">Каталог №1 в Украине</div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 iam-master">
                <a class="btn btn-primary btn-lg" href="<?php echo home_url('/informacia-dlya-masterov/'); ?>" role="button">Я исполнитель</a>
                <div class="help">Бесплатное размещение</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-5">
                <a href="<?php echo home_url('/reklama/'); ?>" class="reklama-link">Реклама на сайте</a>
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
                    <strong>3 269</strong>
                    мастеров
                </div>
            </div>
        </div>
        <div class="col-4 text-center">
            <div class="item">
                <div class="circle">
                    <?php module_svg('theme/icon_rating.svg'); ?>
                    <strong>рейтинг</strong>
                    и отзывы
                </div>
            </div>
        </div>
        <div class="col-4 text-center">
            <div class="item">
                <div class="circle">
                    <?php module_svg('theme/icon_free.svg'); ?>
                    <strong>бесплатный</strong>
                    каталог
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
                    <div class="colored-box p-3">
                        <?php module_template('master/front-list'); ?>
                    </div>
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

        <?php module_template('banner/sidebar-col'); ?>

    </div>
</div>
<?php get_footer(); ?>
