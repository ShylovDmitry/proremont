<?php
$master_terms = get_the_terms(null, 'catalog_master');

$parents = array();
foreach ($master_terms as $master_term) {
    $parents[] = $master_term->parent ? $master_term->parent : $master_term->term_id;
}

$terms = get_terms(array(
    'term_taxonomy_id' => $parents,
    'hierarchical' => false,
    'taxonomy' => 'catalog_master',
    'hide_empty' => false,
    'meta_key' => 'sort',
    'orderby' => 'meta_value',
));
?>
<ul class="catalog-mater-icons list-inline">
    <?php foreach ($terms as $term): ?>
        <li class="list-inline-item">
            <span class="catalog-icon">
                <?php module_svg("catalog_master/{$term->slug}-white.svg"); ?>
            </span>
        </li>
    <?php endforeach; ?>
</ul>
