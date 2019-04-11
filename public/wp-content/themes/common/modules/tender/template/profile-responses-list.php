<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key(null, 'section');
$cache_group = 'pror:tender:list:profile-responses';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="tender-list">
    <?php
    $a = new WP_Query([
        'post_type' => 'tender_response',
	    'post_status' => 'publish',
	    'posts_per_page' => 24,
	    'paged' => get_query_var('paged', 1),
	    'meta_query' => array(
		    array(
			    'key' => 'author',
			    'value' => get_current_user_id(),
		    ),
	    ),
    ]);
    $ids = array_map(function($tender_response) {
        return get_field('tender', $tender_response->ID);
    }, $a->posts);

    $params = array(
        'post_type' => 'tender',
        'post_status' => 'publish',
        'post__in' => $ids,
        'orderby' => 'post__in',
	    'posts_per_page' => -1,
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
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
