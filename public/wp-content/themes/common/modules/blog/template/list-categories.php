<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key('categories', 'section,lang');
$cache_group = 'pror:blog:list:categories';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<ul class="list-unstyled">
    <?php wp_list_categories([
        'title_li' => false,
    ]); ?>
</ul>

<i><a href="<?php echo pror_get_permalink_by_slug('blog'); ?>"><?php _e('Смотреть все статьи', 'common'); ?> &raquo;</a></i>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
