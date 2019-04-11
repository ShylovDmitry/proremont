<?php
$id = isset($__data['id']) ? $__data['id'] : false;
$excerpt = isset($__data['excerpt']) ? $__data['excerpt'] : '';
$datetime = isset($__data['datetime']) ? $__data['datetime'] : false;

if ($id) {
	query_posts(['p' => $id, 'post_type' => 'master']);
	the_post();
}
?>
<div class="master-item<?php if (get_field('master_is_pro', "user_" . get_the_author_meta('ID'))): ?> pro<?php endif; ?>"
     onclick="javascript:window.open('<?php echo esc_url( get_permalink() ); ?>', '_blank');">
    <?php if (has_post_thumbnail()): ?>
        <div class="thumbnail">
            <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(get_the_title()); ?>" target="_blank">
                <div class="avatar">
                    <?php the_post_thumbnail('pror-medium', array(
                            'alt' => pror_get_master_img_alt(),
                            'pror_no_scrset' => true,
                    )); ?>
                </div>
            </a>
        </div>
    <?php endif; ?>

    <div class="master-body">
        <h4 class="mt-0 mb-1">
            <a class="title" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(get_the_title()); ?>" target="_blank"><?php the_title(); ?></a>
            <?php if (get_field('master_is_confirmed', "user_" . get_the_author_meta('ID'))): ?>
                <span class="oi oi-circle-check is-confirmed" data-toggle="tooltip" data-placement="top" title="Проверено"></span>
            <?php endif; ?>
        </h4>
        <div class="subtitle">
            <?php if (get_field('master_is_pro', "user_" . get_the_author_meta('ID'))): ?><span class="pro-label">PRO</span><?php endif; ?>
            <span class="type"><?php _e(get_field('master_type', "user_" . get_the_author_meta('ID')), 'common'); ?>,</span>
            <span class="location"><?php echo pror_get_section_localized_name(pror_get_master_section()); ?></span>
        </div>
        <div class="rating d-none d-sm-block">
            <?php module_template('rating/total-inline'); ?>
        </div>

        <div class="catalog">
            <?php if ($excerpt): ?>
                <?php echo $excerpt; ?>
            <?php else: ?>
                <?php module_template('catalog_master/small-list'); ?>
            <?php endif; ?>
        </div>
        <?php if ($datetime): ?>
            <div class="datetime"><?php echo $datetime; ?></div>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>
</div>

<?php
if ($id) {
	wp_reset_query();
}
?>
