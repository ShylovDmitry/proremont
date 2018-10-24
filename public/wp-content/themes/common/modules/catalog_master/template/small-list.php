<?php
    $terms = get_the_terms(null, 'catalog_master');
    $terms_count = count($terms);
    $i = 0;
?>
<div class="catalog-mater-small-list">
    <?php foreach ($terms as $term): $i++ ?>
        <span><a href="<?php echo esc_url( get_term_link($term) ); ?>" title="<?php echo esc_attr($term->name); ?>" ><?php echo $term->name; ?></a><?php if ($terms_count != $i): ?>, <?php endif; ?></span>
    <?php endforeach; ?>
</div>
