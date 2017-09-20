<?php get_header(); ?>

<?php get_sidebar('banner-top'); ?>

<?php get_template_part('breadcrumb'); ?>

<div class="container colored-box py-3">
    <div class="row">
        <div class="col">
            <h1><?php single_term_title() ?> - <?php echo pror_get_section()->name; ?></h1>

            <?php get_template_part('master-search-form'); ?>

            <?php if (have_posts()): ?>

                <?php while (have_posts()): the_post(); ?>
                    <?php $master_phones = pror_format_phones(get_field('master_telephones')); ?>
                    <div class="media">
                        <?php the_post_thumbnail('pror-medium', array( 'class' => 'd-flex mr-3' )); ?>
                        <div class="media-body">
                            <h5 class="mt-0 mb-1"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_field('master_type'); ?> - <?php the_title(); ?></a>
                                <?php if(get_field('master_is_confirmed')): ?>
                                    <small><span class="oi oi-circle-check ml-2 text-secondary" data-toggle="tooltip" title="Документи мастера подтверджени <br />Телефон подтвержден"></span></small>
                                <?php endif; ?>
                            </h5>

                            <ul class="list-unstyled mb-0">
                                <li class="mb-3"><?php the_terms(null, 'location'); ?></li>
                                <li>
                                    Телефон:
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

        </div>

        <?php get_sidebar('banner-right'); ?>
    </div>
</div>

<?php get_footer(); ?>
