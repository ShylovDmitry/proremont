<?php
$limit = isset($__data['limit']) ? $__data['limit'] : 6;
?>

<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key(sprintf('posts-%s', $limit) , 'section,lang');
$cache_group = 'pror:blog:list:latest-list';

$cache = wp_cache_get($cache_key, $cache_group);
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

    <i><a href="<?php echo pror_get_permalink_by_slug('blog'); ?>"><?php _e('Смотреть все статьи &raquo;', 'common'); ?></a></i>
<?php endif; ?>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
