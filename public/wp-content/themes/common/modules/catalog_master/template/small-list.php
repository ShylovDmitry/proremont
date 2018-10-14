<?php
    $terms = get_the_terms(null, 'catalog_master');
    $terms_count = count($terms);
    $i = 0;
?>
<div class="catalog-mater-small-list">
    <?php foreach (get_the_terms(null, 'catalog_master') as $term): $i++ ?>
        <?php $lang_term_slug = get_term(pll_get_term($term->term_id, pll_default_language()))->slug; ?>
        <a href="<?php echo esc_url( get_term_link($term) ); ?>" title="<?php echo esc_attr($term->name); ?>" ><?php echo $term->name; ?></a><?php if ($terms_count != $i): ?><span class="space">, </span><?php endif; ?>
    <?php endforeach; ?>
</div>
