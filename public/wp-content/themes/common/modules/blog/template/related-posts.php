<?php
$main_post_id = isset($__data['main_post_id']) ? $__data['main_post_id'] : 0;
$container_class = isset($__data['container_class']) ? $__data['container_class'] : '';
$limit = isset($__data['limit']) ? $__data['limit'] : 6;
?>

<?php
$cache_obj = pror_cache_obj(0, 'lang', 'pror:blog:list', 'related', $main_post_id, $container_class, $limit);
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<?php
$query = new WP_Query(array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $limit,
    'post__not_in' => array($main_post_id),
    'tax_query' => array(
        array(
            'taxonomy' => 'catalog_master',
            'terms'    => array_map(function($el) {
                                return $el->term_id;
                            }, get_the_terms($main_post_id, 'catalog_master')),
        ),
    ),
));
?>

<?php if ($query->have_posts()): ?>
    <div class="<?php echo $container_class; ?>">
        <div class="related-posts">
            <h4 class="header-underlined"><?php _e('Похожие статьи', 'common'); ?></h4>

            <div class="row">
            <?php $pos = 0; ?>
            <?php while ($query->have_posts()): $query->the_post(); $pos++; ?>
                <div class="col-12 col-md-6">
                    <?php module_template('blog/small'); ?>

                    <?php if ($pos % 2 == 0): ?><div class="w-100"></div><?php endif; ?>
                </div>
            <?php endwhile; ?>
            </div>
        </div>

        <div class="see-blog">
            <a href="<?php echo home_url('/blog/'); ?>" class="btn"><?php _e('Смотреть все статьи', 'common'); ?></a>
        </div>
    </div>
<?php endif; ?>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
