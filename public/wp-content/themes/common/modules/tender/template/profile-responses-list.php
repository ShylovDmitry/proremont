<?php
$cache_obj = pror_cache_obj(0, 'lang,user', 'pror:tender:list', 'profile-responses');
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="tender-list">
    <?php
    $tender_response_query = new WP_Query([
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
    }, $tender_response_query->posts);

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
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
