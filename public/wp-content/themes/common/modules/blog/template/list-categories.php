<?php
$cache_obj = pror_cache_obj(0, 'lang', 'pror:blog:list:categories', 'block');
$cache = pror_cache_get($cache_obj);
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
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
