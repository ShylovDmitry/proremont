<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key('block', 'section,lang');
$cache_group = 'pror:catalog_master:list';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="catalog-mater-3col" id="catalogMenu" data-pror-children=".item">
    <?php foreach(array_chunk(pror_get_catalog(), 3) as $catalogs_part): ?>
        <div class="row mt-3 mb-1">
            <?php foreach($catalogs_part as $main_catalog): ?>
                <?php $lang_term_slug = get_term(pll_get_term($main_catalog->term_id, pll_default_language()))->slug; ?>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="catalog-title">
                        <a class="pror-collapse" title="<?php echo esc_attr($main_catalog->name); ?>" href="#catalogSubcategory_<?php echo $main_catalog->term_id; ?>" data-pror-target="#catalogSubcategory_<?php echo $main_catalog->term_id; ?>" data-pror-parent="#catalogMenu">
                            <span class="icon"><?php module_svg("catalog_master/{$lang_term_slug}.svg"); ?></span>
                            <span class="text"><span><?php echo $main_catalog->name; ?></span> <?php echo pror_catalog_get_count($main_catalog); ?></span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php foreach($catalogs_part as $p => $main_catalog): ?>
            <div class="item item-<?php echo $p%3 + 1; ?> py-3 px-3 mt-4 d-none" id="catalogSubcategory_<?php echo $main_catalog->term_id; ?>">
                <div class="arrow"></div>

                <a class="all" title="<?php echo esc_attr($main_catalog->name); ?>" href="<?php echo esc_url( get_term_link($main_catalog) ); ?>"><?php _e('Смотреть все', 'common'); ?></a> <span class="help-text"><?php _e('из раздела', 'common'); ?> <?php echo $main_catalog->name; ?></span>
                <hr />

                <div class="row">
                    <?php foreach (pror_get_catalog($main_catalog->term_id) as $pos => $sub_catalog): ?>
                        <div class="col-12 col-md-6 my-1">
                            <a href="<?php echo esc_url( get_term_link($sub_catalog) ); ?>" class="subcategory-link" title="<?php echo esc_attr($sub_catalog->name); ?>"><span><?php echo $sub_catalog->name; ?></span> <?php echo pror_catalog_get_count($sub_catalog); ?></a>
                        </div>
                        <?php if (($pos+1) % 2 == 0): ?><div class="w-100"></div><?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
