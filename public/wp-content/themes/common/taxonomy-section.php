<?php get_header(); ?>

<?php module_template('banner/top'); ?>

<div class="jumbotron jumbotron-fluid pt-5 pb-5">
    <div class="container text-center frontpage-title">
        <h1 class="display-3">Все <strong>про ремонт</strong> тут</h1>
        <p class="lead mt-3">Тут ви найдете всю необходимую информацию для создания своего уютного уголока.</p>
    </div>
</div>

<div class="container colored-box py-3">

    <?php $current_section_id = pror_get_section()->term_id; ?>
    <?php foreach (get_field('frontpage_vips', 'option') as $vip): ?>
        <?php if (in_array($current_section_id, $vip['section'])): ?>

            <?php foreach ($vip['lists'] as $pos => $list): ?>
                <div class="col-6">
                    <h4 class="text-center"><?php echo $list['title']; ?></h4>

                    <ul class="list-unstyled mb-0">
                        <?php shuffle($list['masters']); ?>
                        <?php foreach ($list['masters'] as $master_id): ?>
                            <li class="media mt-4">
                                <a href="<?php echo esc_url( get_permalink($master_id) ); ?>">
                                    <?php echo get_the_post_thumbnail($master_id, 'pror-medium', array( 'class' => 'd-flex mr-3' )); ?>
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1"><a href="<?php echo esc_url( get_permalink($master_id) ); ?>"><?php the_field('master_type', $master_id); ?> - <?php echo get_the_title($master_id); ?></a></h5>
                                    <?php echo get_the_excerpt($master_id); ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php if (($pos+1) % 2 == 0): ?><div class="w-100 my-3"></div><?php endif; ?>
            <?php endforeach; ?>

        <?php endif; ?>
    <?php endforeach; ?>


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
