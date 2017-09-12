<?php get_header(); ?>

<div class="jumbotron jumbotron-fluid pt-5 pb-5">
    <div class="container text-center frontpage-title">
        <h1 class="display-3">Все <strong>про ремонт</strong> тут</h1>
        <p class="lead mt-3">Тут ви найдете всю необходимую информацию для создания своего уютного уголока.</p>
    </div>
</div>

<?php ?>
<div class="container colored-box py-3">

    <div class="row">
        <div class="col-12 mx-auto mt-3">
            <ul class="list-inline list-unstyled text-center mb-0">
                <li class="list-inline-item">Вибери свой город:</li>
                <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'section',
                        'hide_empty' => false,
                    ));
                ?>
                <?php foreach ($terms as $term): ?>
                    <li class="list-inline-item"><a href="<?php echo home_url("{$term->slug}/"); ?>"><?php echo $term->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-2 mx-auto mb-3">
            <hr />
        </div>
    </div>



    <?php $current_section_id = pror_get_section()->term_id; ?>
    <?php foreach (get_field('frontpage_vips', 'option') as $vip): ?>
        <?php if (in_array($current_section_id, $vip['section'])): ?>

            <?php foreach ($vip['lists'] as $pos => $list): ?>
                <div class="col-6">
                    <h4 class="text-center"><?php echo $list['title']; ?></h4>

                    <ul class="list-unstyled mb-0">
                    <?php foreach ($list['masters'] as $master_id): ?>
                        <li class="media mt-4">
                            <a href="<?php echo esc_url( get_permalink($master_id) ); ?>">
                                <img class="d-flex mr-3" src="http://via.placeholder.com/64" alt="" width="64" />
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



    <?php $catalog_master_page = get_page_by_template_name('template-catalog_master.php'); ?>
    <hr class="my-5"/>
    <div class="row">
        <div class="col-12">
            <h3 class="text-center mb-4"><a href="<?php echo esc_url( get_permalink($catalog_master_page) ); ?>"><?php echo get_the_title($catalog_master_page) ?> - <?php echo pror_get_section()->name; ?></a></h3>
        </div>
    <?php
    $main_catalogs = get_terms(array(
        'parent' => 0,
        'hierarchical' => false,
        'taxonomy' => 'catalog_master',
        'hide_empty' => false,
    ));
    ?>
    <?php foreach ($main_catalogs as $pos => $main_catalog): ?>
        <div class="col-4">
            <h6><a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>"><?php echo $main_catalog->name; ?></a></h6>

            <?php
            $sub_catalogs = get_terms(array(
                'parent' => $main_catalog->term_id,
                'hierarchical' => false,
                'taxonomy' => 'catalog_master',
                'hide_empty' => false,
            ));
            ?>
            <ul class="list-unstyled">
            <?php foreach ($sub_catalogs as $sub_catalog): ?>
                <li><a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>"><?php echo $sub_catalog->name; ?></a></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php if (($pos+1) % 3 == 0): ?><div class="w-100"></div><?php endif; ?>
    <?php endforeach; ?>
    </div>

</div>

<?php get_footer(); ?>
