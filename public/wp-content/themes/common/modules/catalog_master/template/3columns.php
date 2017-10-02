<div class="row">
    <div class="col-12">
        <h3 class="text-center mb-4">Каталог Мастеров - <?php echo pror_get_section()->name; ?></h3>
    </div>

    <?php foreach (pror_catalog_get_main() as $pos => $main_catalog): ?>
        <div class="col-4">
            <h6><a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>"><?php echo $main_catalog->name; ?></a> (<?php echo pror_catalog_get_count($main_catalog); ?>)</h6>

            <ul class="list-unstyled">
            <?php foreach (pror_catalog_get_sub($main_catalog->term_id) as $sub_catalog): ?>
                <li><a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>"><?php echo $sub_catalog->name; ?></a> (<?php echo pror_catalog_get_count($sub_catalog); ?>)</li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php if (($pos+1) % 3 == 0): ?><div class="w-100"></div><?php endif; ?>
    <?php endforeach; ?>
</div>
