<?php
$terms = get_terms(array(
    'taxonomy' => 'category',
    'object_ids' => get_the_ID(),
));
$i = count($terms);
?>
<?php foreach ($terms as $term): $i--; ?>
    <a href="<?php echo get_term_link($term, 'category'); ?>" rel="tag"><?php echo $term->name; ?></a><?php if ($i > 0): ?>, <?php endif; ?>
<?php endforeach; ?>
