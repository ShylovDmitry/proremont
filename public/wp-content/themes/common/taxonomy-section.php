<?php get_header(); ?>

<div class="jumbotron jumbotron-fluid header">
    <div class="container text-center frontpage-title">
        <h2><?php echo pror_get_section()->name; ?></h2>
        <h1>Каталог <span>Мастеров</span></h1>
        <p class="lead mt-3">Найдите своего мастера быстро и легко по <strong>отзывам</strong> и <strong>портфолио</strong></p>
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

        <div class="col col-md-12 col-ad">
            <?php module_template('banner/sidebar'); ?>
        </div>

    </div>
</div>
<?php get_footer(); ?>
