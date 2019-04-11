<?php
$is_short_form = isset($__data['short_form']) ? $__data['short_form'] : false;

$catalog = '';
if (is_tax('catalog_master')) {
    $catalog = get_queried_object()->name;
}
?>

<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key(sprintf('%s-%s', $is_short_form, $catalog) , 'section,lang');
$cache_group = 'pror:searchbox:form';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div id="master-searchbox" class="master-searchbox">
    <form action="#" method="GET" class="mb-3">
        <div class="form-row justify-content-center">
            <div class="col-md-6">
                <input type="text" name="catalog" class="catalog-search-input form-control" value="<?php echo $catalog; ?>" placeholder="<?php _e('Начните вводить вид работы', 'common'); ?>" />
                <small class="form-text"><?php _e('Например: Ремонт под ключ, Отделка полов и тд.', 'common'); ?></small>
            </div>
            <div class="col-md-4">
                <input type="text" name="section" class="section-search-input form-control" value="<?php echo pror_get_section_localized_name(pror_detect_section()); ?>" />
            </div>
            <div class="col-md-2 mt-2 mt-md-0">
                <input type="submit" class="btn btn-pror-primary btn-block" value="<?php _e('Найти', 'common'); ?>" />
            </div>
            <?php if (!$is_short_form): ?>
                <div class="col-12 mt-2 mt-md-0 text-right advanced-options">
                    <a href="#searchboxOptions" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="searchboxOptions"><?php _e('Расширенный поиск', 'common'); ?></a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!$is_short_form): ?>
            <?php
                $is_collapsed = !isset($_GET['mtype']) || empty($_GET['mtype']);
            ?>
            <div class="mt-2 collapse<?php if (!$is_collapsed): ?> show<?php endif; ?>" id="searchboxOptions">
                <div class="row">
                    <div class="col-md-4">
                        <?php _e('Тип исполнителя', 'common'); ?>:
                    </div>
                    <div class="col-auto">
                    <?php foreach (pror_get_master_types() as $type_value => $type_name): ?>
                        <div class="form-check form-check-inline d-block d-md-inline-flex">
                            <label><input type="radio" name="mtype" class="mtype-input form-check-input" value="<?php echo $type_value; ?>"<?php if ($_GET['mtype'] == $type_value): ?> checked="checked"<?php endif;?> />
                                <?php echo $type_name; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </form>
</div>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
