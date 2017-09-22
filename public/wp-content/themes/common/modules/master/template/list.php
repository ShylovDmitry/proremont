<h1><?php single_term_title() ?> - <?php echo pror_get_section()->name; ?></h1>

<?php module_template('master/searchbox'); ?>



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
    <h3 class="mt-5 mb-4"><ins>PRO мастера</ins></h3>

    <?php $pos = 0; ?>
    <?php while ($query->have_posts()): $query->the_post(); $pos++;?>
        <div class="media">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('pror-medium', array( 'class' => 'd-flex mr-3' )); ?>
                <?php else: ?>
                    <img src="http://via.placeholder.com/100" class="wp-post-image d-flex mr-3" />
                <?php endif; ?>
            </a>
            <div class="media-body">
                <h5 class="mt-0 mb-1">
                    <?php if (get_field('master_is_pro')): ?>[PRO]<?php endif; ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_field('master_type'); ?> - <?php the_title(); ?></a>
                </h5>
                <?php the_excerpt(); ?>
            </div>
        </div>

        <hr class="my-4" />
    <?php endwhile; ?>
<?php endif; ?>





<?php if (have_posts()): ?>
    <h3 class="mt-5 mb-4"><ins>Мастера</ins></h3>

    <?php while (have_posts()): the_post(); ?>
        <div class="media">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('pror-medium', array( 'class' => 'd-flex mr-3' )); ?>
            <?php else: ?>
                <img src="http://via.placeholder.com/100" class="wp-post-image d-flex mr-3" />
            <?php endif; ?>

            <div class="media-body">
                <h5 class="mt-0 mb-1">
                    <?php if (get_field('master_is_pro')): ?>[PRO]<?php endif; ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_field('master_type'); ?> - <?php the_title(); ?></a>
                    <?php if (get_field('master_is_confirmed')): ?>
                        <small><span class="oi oi-circle-check ml-2 text-secondary" data-toggle="tooltip" title="Документи мастера подтверджени <br />Телефон подтвержден"></span></small>
                    <?php endif; ?>
                </h5>

                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <?php
                            $term = get_the_terms(null, 'location');
                            if (isset($term, $term[0])) {
                                echo trim(get_term_parents_list($term[0]->term_id, 'location', array(
                                    'separator' => ', ',
                                    'link' => false
                                )), ', ');
                            }
                        ?>
                    </li>
                    <li>
                        Телефон:
                            <?php $master_phones = pror_format_phones(get_field('master_phones')); ?>
                            <?php foreach ($master_phones as $phone): ?>
                                <a href="#"><?php echo $phone; ?></a>
                            <?php endforeach; ?>
                     </li>
                </ul>
            </div>
        </div>

        <hr class="my-4" />
    <?php endwhile; ?>

    <?php get_template_part('pagination'); ?>
<?php else: ?>
    <i>Перевірте цей розділ пізнійше. Скоро ми додамо майстрів і компанії.</i>
<?php endif; ?>
