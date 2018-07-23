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
            <h5><?php the_title(); ?></h5>
            <p><?php the_field('family_description'); ?></p>
            <p>
                <span class="text-danger font-weight-bold"><?php the_field('family_discount'); ?></span>
                <br />
                <span class="text-secondary small"><?php the_field('family_address'); ?></span>
            </p>
        </td>
    </tr>
<?php endwhile; ?>
</table>