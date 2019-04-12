<?php
$cache_obj = pror_cache_obj(0, 'section,lang', 'pror:catalog_master:page', 'block');
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="catalog-master-page">
    <?php $pos = 0; ?>
    <?php foreach(pror_get_catalog() as $main_catalog): $pos++; ?>
        <?php $lang_term_slug = get_term(pll_get_term($main_catalog->term_id, pll_default_language()))->slug; ?>
        <div class="catalog-mater-item mb-4">
            <div class="catalog-title">
                <a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>" title="<?php echo esc_attr($main_catalog->name); ?>">
                    <span class="icon"><?php module_svg("catalog_master/{$lang_term_slug}.svg"); ?></span>
                    <span class="link"><span><?php echo $main_catalog->name; ?></span> <?php echo pror_catalog_get_count($main_catalog); ?></span>
                </a>
            </div>

            <div class="catalog-subs row">
                <?php foreach (pror_get_catalog($main_catalog->term_id) as $sub_catalog): ?>
                    <div class="col-12"><a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>" title="<?php echo esc_attr($sub_catalog->name); ?>"><span><?php echo $sub_catalog->name; ?></span> <?php echo pror_catalog_get_count($sub_catalog); ?></a></div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($pos == 1): ?>
            <div class="mb-4 d-lg-none">
                <?php module_template('prom/mobile1'); ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
