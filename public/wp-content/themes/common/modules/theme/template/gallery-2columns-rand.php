<?php
$query_masters = new WP_Query(array(
    'post_type' => 'master',
    'fields' => 'ids',
    'posts_per_page' => 20,
    'orderby' => 'rand',
    'meta_query' => array(
        array(
            'key' => 'master_gallery',
            'value' => '',
            'compare' => '!=',
        ),
    ),
));

$query = new WP_Query(array(
    'post_status' => 'inherit',
    'post_type'=> 'attachment',
    'post_parent__in' => $query_masters->posts,
    'posts_per_page' => 20,
));
?>

<?php if ($query->have_posts()): ?>
<div class="gallery-2columns">
    <div class="row">
        <div class="col-12">
            <h3>Галерея робот разных мастеров</h3>
        </div>
    </div>

        <div class="gallery-2columns-carousel">
    <div class="row">
            <?php $pos = 0; ?>
            <?php while ($query->have_posts()): $query->the_post(); $pos++;?>
                <div class="col-6 col-md-3 my-2">
                    <a href="<?php echo wp_get_attachment_image_url(get_the_ID(), 'full'); ?>">
                        <?php echo wp_get_attachment_image(get_the_ID(), 'pror-medium', false,  array('class' => 'img-fluid w-100')); ?>
                    </a>
                </div>

                <?php if ($pos % 4 == 0): ?><div class="w-100"></div><?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?>
