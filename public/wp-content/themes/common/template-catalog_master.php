<?php /* Template Name: Catalog Master */ ?>

<?php get_header(); ?>

<?php get_template_part('breadcrumb'); ?>

<div class="container colored-box py-3">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <h3 class="mb-4"><?php the_title() ?> - <?php echo pror_get_section()->name; ?></h3>
                </div>

                <?php
                $main_catalogs = get_terms(array(
                    'parent' => 0,
                    'hierarchical' => false,
                    'taxonomy' => 'catalog_master',
                    'hide_empty' => false,
                ));
                ?>
                <?php foreach ($main_catalogs as $main_catalog): ?>
                    <div class="col-12">
                        <hr />
                        <h6><a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>"><?php echo $main_catalog->name; ?></a></h6>

                        <?php
                        $sub_catalogs = get_terms(array(
                            'parent' => $main_catalog->term_id,
                            'hierarchical' => false,
                            'taxonomy' => 'catalog_master',
                            'hide_empty' => false,
                        ));
                        ?>
                        <div class="row">
                            <?php $halved = array_chunk($sub_catalogs, ceil(count($sub_catalogs)/2));?>
                            <?php foreach ($halved as $half): ?>
                                <div class="col-6">
                                    <?php foreach ($half as $sub_catalog): ?>
                                        <div>
                                            <a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>"><?php echo $sub_catalog->name; ?></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <?php get_sidebar('banner-right'); ?>
    </div>
</div>

<?php get_footer(); ?>
