<?php
$terms = get_terms(array(
    'taxonomy' => 'catalog_master',
    'object_ids' => get_the_ID(),
));
$i = count($terms);
?>
<?php foreach ($terms as $term): $i--; ?>
    <a href="<?php echo get_term_link($term, 'category'); ?>" rel="tag" target="_blank"><?php echo $term->name; ?></a><?php if ($i > 0): ?> &bull; <?php endif; ?>
<?php endforeach; ?>
