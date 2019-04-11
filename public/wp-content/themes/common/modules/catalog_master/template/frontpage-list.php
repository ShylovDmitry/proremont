<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key('block', 'lang');
$cache_group = 'pror:catalog_master:frontpage';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<?php
$catalog_ids = get_field('frontpage_catalog', 'option', false);
if (!$catalog_ids) {
    $catalog_ids = array(-1);
}

$terms = get_terms(array(
    'hierarchical' => false,
    'taxonomy' => 'catalog_master',
    'hide_empty' => false,
    'include' => $catalog_ids,
));
?>

<?php if ($terms): ?>
<div class="frontpage-catalog">
    <div class="row">
        <div class="col-12">
            <h4 class="header-underlined"><?php _e('Популярные категории', 'common'); ?></h4>
        </div>
    </div>

    <div class="row">
        <?php $pos = 0; ?>
        <?php foreach ($terms as $main_catalog): $pos++; ?>
            <div class="col-12 col-md-6">
                <a href="<?php echo esc_url( get_term_link($main_catalog) ); ?>" title="<?php echo esc_attr($main_catalog->name); ?>" class="subcategory-link">
                    <?php echo $main_catalog->name; ?><i> <?php echo pror_catalog_get_count($main_catalog); ?></i>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
