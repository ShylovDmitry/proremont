<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key('block', 'section');
$cache_group = 'pror:catalog_master:page';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="catalog-master-page">
    <?php $pos = 0; ?>
    <?php foreach(pror_get_catalog() as $main_catalog): $pos++; ?>
        <div class="catalog-mater-item mb-4">
            <div class="catalog-title">
                <a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>" title="<?php echo esc_attr($main_catalog->name); ?>">
                    <span class="icon"><?php module_svg("catalog_master/{$main_catalog->slug}.svg"); ?></span>
                    <span class="link"><span><?php echo $main_catalog->name; ?></span> <?php echo pror_catalog_get_count($main_catalog); ?></span>
                </a>
            </div>

            <div class="catalog-subs row">
                <?php foreach (pror_get_catalog($main_catalog->term_id) as $index => $sub_catalog): ?>
                    <div class="col-12 col-md-6 my-1"><a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>" title="<?php echo esc_attr($sub_catalog->name); ?>"><span><?php echo $sub_catalog->name; ?></span> <?php echo pror_catalog_get_count($sub_catalog); ?></a></div>
                    <?php if (($index+1) % 2 == 0): ?><div class="w-100 d-lg-none"></div><?php endif; ?>
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
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
