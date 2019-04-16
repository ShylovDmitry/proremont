<?php
$cache_obj = pror_cache_obj(0, 'lang,user', 'pror:tender:list', 'profile');
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="tender-list">
    <?php
    $params = array(
        'post_type' => 'tender',
        'post_status' => 'publish',
        'posts_per_page' => 24,
        'paged' => get_query_var('paged', 1),
        'meta_query' => array(
            array(
                'key' => 'customer',
                'value' => get_current_user_id(),
            ),
        ),
    );

    global $wp_query;
    $wp_query = new WP_Query($params);
    ?>

    <?php if ($wp_query->have_posts()): ?>
        <div class="tender-list-simple">
            <?php while ($wp_query->have_posts()): $wp_query->the_post();?>
                <?php module_template('tender/item'); ?>
            <?php endwhile; ?>
        </div>

        <?php module_template('theme/pagination'); ?>
    <?php else: ?>
        <i><?php _e('Ничего не найдено. Проверьте этот раздел позже.', 'common'); ?></i>
    <?php endif; ?>
</div>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
