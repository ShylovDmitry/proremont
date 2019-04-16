<?php
$limit = isset($__data['limit']) ? $__data['limit'] : 6;
?>

<?php
$cache_obj = pror_cache_obj(0, 'lang', 'pror:blog:list', 'latest-list', $limit);
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
));
?>

<?php if ($query->have_posts()): ?>
    <ul class="latest-posts-list">
        <?php while ($query->have_posts()): $query->the_post();; ?>
            <li><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
    </ul>

    <i><a href="<?php echo pror_get_permalink_by_slug('blog'); ?>"><?php _e('Смотреть все статьи', 'common'); ?> &raquo;</a></i>
<?php endif; ?>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
