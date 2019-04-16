<?php
$container_class = isset($__data['container_class']) ? $__data['container_class'] : '';
?>

<?php
$cache_obj = pror_cache_obj(5*60, 'lang', 'pror:partner:list', 'front', $container_class);
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<?php
$partners_ids = get_field('frontpage_partners', 'option', false);
if (!$partners_ids) {
    $partners_ids = array(-1);
}

$query = new WP_Query(array(
    'post_type' => 'partner',
    'post__in' => $partners_ids,
    'orderby' => 'post__in',
    'posts_per_page' => 20,
));
?>

<?php if ($query->have_posts()): ?>
    <div class="<?php echo $container_class; ?>">
        <div class="list">
            <div class="row">
                <div class="col-12 mb-1">
                    <h4 class="header-underlined"><?php _e('Партнеры', 'common'); ?></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="partner-wrapper mb-3">
<!--                        <div class="partner-carousel">-->
<!--                            --><?php //while ($query->have_posts()): $query->the_post(); ?>
<!--                                --><?php //module_template('partner/slide'); ?>
<!--                            --><?php //endwhile; ?>
<!--                        </div>-->
                        <div class="partner-list-simple row">
                            <?php while ($query->have_posts()): $query->the_post(); ?>
                                <?php module_template('partner/item'); ?>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-1">
            <a href="<?php echo pror_get_permalink_by_slug('partners'); ?>" class="btn partners-see-all"><?php _e('Смотреть всех партнеров', 'common'); ?></a>
        </div>
    </div>
<?php endif; ?>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
