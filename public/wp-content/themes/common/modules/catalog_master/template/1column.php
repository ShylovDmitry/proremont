<div class="row">
    <div class="col-12">
        <h3 class="mb-4"><?php the_title() ?> - <?php echo pror_get_section()->name; ?></h3>
    </div>

    <?php foreach (pror_catalog_get_main() as $main_catalog): ?>
        <div class="col-12">
            <hr />
            <h6><a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>"><?php echo $main_catalog->name; ?></a> (<?php echo pror_catalog_get_count($main_catalog); ?>)</h6>

            <div class="row">
                <?php $sub_catalogs = pror_catalog_get_sub($main_catalog->term_id); ?>
                <?php $halved = array_chunk($sub_catalogs, ceil(count($sub_catalogs)/2));?>
                <?php foreach ($halved as $half): ?>
                    <div class="col-6">
                        <?php foreach ($half as $sub_catalog): ?>
                            <div>
                                <a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>"><?php echo $sub_catalog->name; ?></a> (<?php echo pror_catalog_get_count($sub_catalog); ?>)
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>
