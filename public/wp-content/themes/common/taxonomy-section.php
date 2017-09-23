<?php get_header(); ?>

<?php module_template('banner/top'); ?>

<div class="jumbotron jumbotron-fluid pt-5 pb-5">
    <div class="container text-center frontpage-title">
        <h1 class="display-3">Все <strong>про ремонт</strong> тут</h1>
        <p class="lead mt-3">Тут ви найдете всю необходимую информацию для создания своего уютного уголока.</p>
    </div>
</div>

<div class="container colored-box py-3">
    <?php module_template('master/pro-3columns'); ?>

    <hr class="my-5"/>

    <?php module_template('catalog_master/3columns'); ?>

    <div class="row">
        <div class="col-12">
            <hr />
        </div>
        <div class="col-12 mx-auto mt-3">
            <h6>Вибери свой город</h6>
            <div class="row">
                <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'section',
                        'hide_empty' => false,
                        'meta_key' => 'sort',
                        'orderby' => 'meta_value',
                        'meta_query' => array(
                            'relation' => 'OR',
                            array(
                                'key' => 'hidden',
                                'value' => 1,
                                'compare' => '!=',
                            ),
                            array(
                                'key' => 'hidden',
                                'compare' => 'NOT EXISTS',
                            )
                        )
                    ));
                ?>
                <?php $halved = array_chunk($terms, ceil(count($terms)/4));?>
                <?php foreach ($halved as $half): ?>
                    <div class="col-3">
                        <?php foreach ($half as $term): ?>
                            <div><a href="<?php echo home_url("{$term->slug}/"); ?>">Ремонт <?php echo $term->name; ?></a></div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


</div>

<?php get_footer(); ?>
