<?php get_header(); ?>

<div class="jumbotron jumbotron-fluid header">
    <div class="container">
        <div class="frontpage-block">
            <div class="text-block">
                <div class="first">Всеукраинский бесплатный</div>
                <h1>ОНЛАЙН-КАТАЛОГ<span class="highlighted">МАСТЕРОВ</span></h1>
                <div class="last">для ремонта квартир, домов<br />и офисных помещений</div>
            </div>

            <div class="buttons">
                <div class="find-master">
                    <a class="btn btn-primary btn-lg" href="<?php echo home_url('/catalog/'); ?>" role="button">Ищу специалиста</a>
                    <div class="help">Каталог №1 в Украине</div>
                </div>

                <div class="iam-master">
                    <a class="btn btn-primary btn-lg" href="<?php echo home_url('/informacia-dlya-masterov/'); ?>" role="button">Я исполнитель</a>
                    <div class="help">Бесплатное размещение</div>
                </div>
            </div>

            <div class="mt-5">
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
                    <strong>3 421</strong>
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
