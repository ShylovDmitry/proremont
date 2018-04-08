<?php
$cache_expire = pror_cache_expire(24*60*60);
$cache_key = pror_cache_key(null, 'section');
$cache_group = 'pror:master:list:main';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="master-list">
    <?php
        $master_types = pror_get_master_types();
        $selected_type = isset($_GET['f_master_type']) ? $_GET['f_master_type'] : key($master_types);

        global $wp;
        $current_url =  home_url($wp->request . '/');
        $page_pos = strpos($current_url , '/page');
        if ($page_pos) {
            $current_url = substr($current_url, 0, $page_pos + 1);
        }
    ?>
    <ul class="nav nav-tabs mb-4">
        <?php foreach ($master_types as $type_key => $type_value): ?>
            <li class="nav-item">
                <a class="nav-link<?php if ($selected_type == $type_key): ?> active<?php endif; ?>" href="<?php echo $current_url; ?>?f_master_type=<?php echo $type_key; ?>">
                    <?php echo $type_value; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>


    <?php
    $query = new WP_Query(array(
        'post_type' => 'master',
        'posts_per_page' => 4,
        'orderby' => 'rand',
        'author__in' => pror_get_query_pro_master_ids(),
        'tax_query' => array(
            array(
                'taxonomy' => 'location',
                'terms' => get_field('locations', pror_get_section()),
                'include_children' => false,
                'operator' => 'IN',
            ),
            array(
                'taxonomy' => 'catalog_master',
                'field' => 'slug',
                'terms' => get_query_var('catalog_master'),
            ),
        ),
    ));
    ?>

    <div class="master-list-simple">
        <?php if ($query->have_posts() || have_posts()): ?>
            <?php $pos = 0; ?>

            <?php while ($query->have_posts()): $query->the_post(); $pos++; ?>
                <?php module_template('master/item'); ?>

                <?php if ($pos == 1): ?>
                    <?php module_template('banner/native1'); ?>
                <?php endif; ?>
                <?php if ($pos == 2): ?>
                    <div class="master-item d-lg-none">
                        <?php module_template('banner/mobile1'); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>

            <?php while (have_posts()): the_post(); $pos++; ?>
                <?php module_template('master/item'); ?>

                <?php if ($pos == 1): ?>
                    <?php module_template('banner/native1'); ?>
                <?php endif; ?>
                <?php if ($pos == 2): ?>
                    <div class="master-item d-lg-none">
                        <?php module_template('banner/mobile1'); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>

            <?php module_template('theme/pagination'); ?>
        <?php else: ?>
            <i>Ничего не найдено. Проверьте этот раздел позже.</i>
        <?php endif; ?>
    </div>
</div>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>
