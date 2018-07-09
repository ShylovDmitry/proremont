<?php
$terms = get_terms(array(
    'taxonomy' => 'category',
    'object_ids' => get_the_ID(),
    'lang' => '',
    'fields' => 'ids',
));
$i = count($terms);
?>
<?php foreach ($terms as $term_id): $i--; ?>
    <?php
        $pll_term_id = null;
        if (pll_get_term_language($term_id) != pll_current_language()) {
            $pll_term_id = pll_get_term($term_id, pll_current_language());
        }
        $term = get_term($pll_term_id ? $pll_term_id : $term_id);
    ?>
    <a href="<?php echo get_term_link($term, 'category'); ?>" rel="tag"><?php echo $term->name; ?></a><?php if ($i > 0): ?>, <?php endif; ?>
<?php endforeach; ?>
