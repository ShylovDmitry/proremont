<?php /* Template Name: Catalog Master */ ?>

<?php get_header(); ?>

<?php get_template_part('breadcrumb'); ?>

<div class="container colored-box py-3">
    <?php $catalog_master_page = get_page_by_template_name('template-catalog_master.php'); ?>
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4"><?php echo get_the_title($catalog_master_page) ?></h3>
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
            <h6><a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>"><?php echo $main_catalog->name; ?></a> (<?php echo $main_catalog->count; ?>)</h6>

            <?php
            $sub_catalogs = get_terms(array(
                'parent' => $main_catalog->term_id,
                'hierarchical' => false,
                'taxonomy' => 'catalog_master',
                'hide_empty' => false,
            ));
            ?>
            <div class="row">
            <?php foreach ($sub_catalogs as $sub_pos => $sub_catalog): ?>
                <div class="col-4"><a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>"><?php echo $sub_catalog->name; ?></a></div>
                <?php if (($sub_pos+1) % 3 == 0): ?><div class="w-100"></div><?php endif; ?>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>
