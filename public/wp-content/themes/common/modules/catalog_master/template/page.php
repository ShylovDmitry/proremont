<div class="catalog-master-page">
    <?php $pos = 0; ?>
    <?php foreach(pror_get_catalog() as $main_catalog): $pos++; ?>
        <div class="catalog-mater-item mb-4">
            <div class="catalog-title">
                <a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>">
                    <span class="icon"><?php module_svg("catalog_master/{$main_catalog->slug}.svg"); ?></span>
                    <span class="link"><span><?php echo $main_catalog->name; ?></span></span>
                </a>
            </div>

            <div class="catalog-subs row">
                <?php foreach (pror_get_catalog($main_catalog->term_id) as $index => $sub_catalog): ?>
                    <div class="col-12 col-md-6 my-1"><a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>"><?php echo $sub_catalog->name; ?></a></div>
                    <?php if (($index+1) % 2 == 0): ?><div class="w-100 d-lg-none"></div><?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($pos == 2): ?>
            <div class="mb-4 d-lg-none">
                <?php module_template('banner/mobile'); ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
