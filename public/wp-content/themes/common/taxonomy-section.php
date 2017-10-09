<?php get_header(); ?>

<div class="jumbotron jumbotron-fluid header">
    <div class="container text-center frontpage-title">
        <h1 class="display-3">Каталог <span>мастеров</span></h1>
        <p class="lead mt-3">Найдите своего мастера по <strong>отзывам</strong> и <strong>портфолио</strong></p>
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
                    <strong>бесплатний</strong>
                    каталог
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container colored-box py-3">
    <?php module_template('catalog_master/3columns'); ?>

    <div class="my-5"></div>

    <?php module_template('master/pro-2columns'); ?>


<!--    <div class="row">-->
<!--        <div class="col-12">-->
<!--            <hr />-->
<!--        </div>-->
<!--        <div class="col-12 mx-auto mt-3">-->
<!--            <h6>Вибери свой город</h6>-->
<!--            <div class="row">-->
<!--                --><?php
//                    $terms = get_terms(array(
//                        'taxonomy' => 'section',
//                        'hide_empty' => false,
//                        'meta_key' => 'sort',
//                        'orderby' => 'meta_value',
//                        'meta_query' => array(
//                            'relation' => 'OR',
//                            array(
//                                'key' => 'hidden',
//                                'value' => 1,
//                                'compare' => '!=',
//                            ),
//                            array(
//                                'key' => 'hidden',
//                                'compare' => 'NOT EXISTS',
//                            )
//                        )
//                    ));
//                ?>
<!--                --><?php //$halved = array_chunk($terms, ceil(count($terms)/4));?>
<!--                --><?php //foreach ($halved as $half): ?>
<!--                    <div class="col-3">-->
<!--                        --><?php //foreach ($half as $term): ?>
<!--                            <div><a href="--><?php //echo home_url("{$term->slug}/"); ?><!--">Ремонт --><?php //echo $term->name; ?><!--</a></div>-->
<!--                        --><?php //endforeach; ?>
<!--                    </div>-->
<!--                --><?php //endforeach; ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->


</div>

<?php get_footer(); ?>
