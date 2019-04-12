<?php
$cache_obj = pror_cache_obj(0, 'lang', 'pror:theme:gallery', 'block');
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<?php
$gallery_ids = get_field('frontpage_main_gallery', 'option', false);
if (!$gallery_ids) {
    $gallery_ids = array(-1);
}

$query = new WP_Query(array(
    'post_status' => 'inherit',
    'post_type' => 'attachment',
    'post__in' => $gallery_ids,
    'orderby' => 'post__in',
    'posts_per_page' => 20,
));
?>

<?php if ($query->have_posts()): ?>
<div class="gallery-2columns">
    <div class="row">
        <div class="col-12">
            <h4 class="header-underlined"><?php _e('Недавно добавленные фотографии', 'common'); ?></h4>
        </div>
    </div>

    <div class="gallery-2columns-carousel">
        <div class="row">
            <?php $pos = 0; ?>
            <?php while ($query->have_posts()): $query->the_post(); $pos++; ?>
                <div class="col-6 col-md-3 my-3">
                    <a href="<?php echo wp_get_attachment_image_url(get_the_ID(), 'full'); ?>">
                        <?php echo wp_get_attachment_image(get_the_ID(), 'pror-medium', false,  array('class' => 'img-fluid w-100', 'pror_no_scrset' => true)); ?>
                    </a>
                </div>

                <?php if ($pos % 2 == 0): ?><div class="w-100 d-md-none"></div><?php endif; ?>
                <?php if ($pos % 4 == 0): ?><div class="w-100 d-none d-md-block"></div><?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
