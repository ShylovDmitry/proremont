<?php
$list = new WP_Query([
    'post_type' => 'family',
    'nopaging' => true,
    'post__in' => get_field('family_list'),
    'orderby' => 'post__in',
]);
?>
<table class="table table-bordered family-list">
<?php while($list->have_posts()): $list->the_post(); ?>
    <tr>
        <td>
            <h5><?php the_title(); ?> <small class="text-danger font-weight-normal">/ <?php _e('скидка', 'common'); ?> <?php the_field('family_discount'); ?></small></h5>
            <?php if(get_field('family_description')): ?>
                <p><?php the_field('family_description'); ?></p>
            <?php endif; ?>
            <div class="text-secondary small"><?php the_field('family_address'); ?></div>
        </td>
    </tr>
<?php endwhile; ?>
</table>