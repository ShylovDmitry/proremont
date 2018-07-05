<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key(null, 'section');
$cache_group = 'pror:partner:list:main';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="partner-list">
    <?php
    $query = new WP_Query(array(
        'post_type' => 'partner',
        'post_status' => 'publish',
        'posts_per_page' => 24,
        'paged' => get_query_var('paged', 1),
    ));

    global $wp_query;
    $wp_query = $query;
    ?>

    <?php if ($query->have_posts()): ?>
        <div class="partner-list-simple row">
            <?php while ($query->have_posts()): $query->the_post();?>
                <?php module_template('partner/item'); ?>
            <?php endwhile; ?>
        </div>

        <?php module_template('theme/pagination'); ?>
    <?php else: ?>
        <i><?php _e('Ничего не найдено. Проверьте этот раздел позже.', 'common'); ?></i>
    <?php endif; ?>
</div>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
