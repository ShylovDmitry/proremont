<?php
$container_class = isset($__data['container_class']) ? $__data['container_class'] : '';
$main_post_id = isset($__data['main_post_id']) ? $__data['main_post_id'] : 0;
$limit = isset($__data['limit']) ? $__data['limit'] : 6;

$query = new WP_Query(array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $limit,
    'post__not_in' => array($main_post_id),
    'tax_query' => array(
        array(
            'taxonomy' => 'catalog_master',
            'terms'    => array_map(function($el) {
                                return $el->term_id;
                            }, get_the_terms($main_post_id, 'catalog_master')),
        ),
    ),
));
?>

<?php if ($query->have_posts()): ?>
    <div class="<?php echo $container_class; ?>">
        <div class="related-posts">
            <h3 class="header-underlined">Похожие статии</h3>

            <div class="row">
            <?php $pos = 0; ?>
            <?php while ($query->have_posts()): $query->the_post(); $pos++; ?>
                <div class="col-6">
                    <?php module_template('blog/small'); ?>

                    <?php if ($pos % 2 == 0): ?><div class="w-100"></div><?php endif; ?>
                </div>
            <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

