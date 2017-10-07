<div class="master-list">
    <?php
        $master_types = array(
                '' => 'Все',
                'master' => 'Мастер',
                'brіgada' => 'Бригада',
                'kompania' => 'Компания',
        );
        $selected_type = isset($_GET['f_master_type']) ? $_GET['f_master_type'] : key($master_types);
    ?>
    <ul class="nav nav-tabs mb-4">
        <?php foreach ($master_types as $type_key => $type_value): ?>
            <li class="nav-item">
                <a class="nav-link<?php if ($selected_type == $type_key): ?> active<?php endif; ?>" href="?f_master_type=<?php echo $type_key; ?>">
                    <?php echo $type_value; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>


    <?php
    $query = new WP_Query(array(
        'post_type' => 'master',
        'posts_per_page' => 4,
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'location',
                'terms' => get_field('locations', pror_get_section()),
                'include_children' => false,
                'operator' => 'IN',
            ),
            array(
                'taxonomy' => 'catalog_master',
                'field' => 'slug',
                'terms' => get_query_var('catalog_master'),
                'include_children' => false,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => 'master_is_pro',
                'value' => 1,
            ),
        ),
    ));
    ?>

    <?php if ($query->have_posts()): ?>
        <div class="master-list-pro">
            <h3 class="mt-5 mb-4">PRO мастера</h3>

            <?php $pos = 0; ?>
            <?php while ($query->have_posts()): $query->the_post(); $pos++;?>
                <?php module_template('master/item'); ?>

                <hr class="my-4" />
            <?php endwhile; ?>
        </div>
    <?php endif; ?>





    <?php if (have_posts()): ?>
        <div class="master-list-simple">
            <h3 class="mt-5 mb-4">Мастера</h3>

            <?php while (have_posts()): the_post(); ?>
                <?php module_template('master/item'); ?>

                <hr class="my-4" />
            <?php endwhile; ?>

            <?php get_template_part('pagination'); ?>
        </div>
    <?php else: ?>
        <i>Перевірте цей розділ пізнійше. Скоро ми додамо майстрів і компанії.</i>
    <?php endif; ?>
</div>
