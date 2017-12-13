<?php get_header(); ?>

<div class="jumbotron jumbotron-fluid header">
    <div class="container frontpage-title">
        <h1>КАТАЛОГ МАСТЕРОВ</h1>
        <p class="lead mt-1">Найдите своего мастера по <strong>отзывам</strong></p>

        <div class="row">
            <div class="col-3 find-master">
                <a class="btn btn-primary btn-lg" href="#" role="button">Ищу специалиста</a>
                <div class="help">Каталог №1 в Украине</div>
            </div>
            <div class="col-3 iam-master">
                <a class="btn btn-primary btn-lg" href="#" role="button">Я исполнитель</a>
                <div class="help">Бесплатное размешенее</div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-3 mb-4 frontpage-cons">
    <div class="row">
        <div class="col-4 text-align">
            <div class="item">
                <div class="circle">
                    <strong>1 329</strong>
                    мастеров
                </div>
            </div>
        </div>
        <div class="col-4 text-center">
            <div class="item">
                <div class="circle">
                    <strong>рейтинг</strong>
                    и отзывы
                </div>
            </div>
        </div>
        <div class="col-4 text-center">
            <div class="item">
                <div class="circle">
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
                        <?php module_template('catalog_master/3columns'); ?>
                    </div>
                </div>

                <div class="col-12 mb-3 d-lg-none">
                    <?php module_template('banner/mobile'); ?>
                </div>

                <div class="col-12 mb-3">
                    <div class="colored-box p-3">
                        <?php module_template('master/pro-2columns'); ?>
                    </div>
                </div>

                <div class="col-12">
                    <div class="colored-box p-3">
                        <?php module_template('theme/gallery-2columns'); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php module_template('banner/sidebar-col'); ?>

    </div>
</div>
<?php get_footer(); ?>
