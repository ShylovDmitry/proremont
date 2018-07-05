<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key('block', 'section,lang');
$cache_group = 'pror:theme:header';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo home_url('/'); ?>">
            <img src="<?php module_img('theme/logo-proremont.png'); ?>" height="40px" alt="ProRemont logo" />
        </a>

        <div class="dropdown section-list">
            <a class="nav-link dropdown-toggle" href="#" data-slug="<?php echo pror_get_section()->slug; ?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php module_svg('theme/ic_location_on_black_18px.svg'); ?> <span><?php echo pror_get_section_name(pror_get_section()); ?></span>
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <?php
                    global $wp;
                    $locations = get_nav_menu_locations();
                    $menu = wp_get_nav_menu_object( $locations['header_dropdown'] );
                    $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

                    $half = ceil(count($menuitems) / 2);
                    $one = array_slice($menuitems, 0, $half);
                    $two = array_slice($menuitems, $half);
                ?>
                <div class="left">
                    <?php foreach ($one as $menuitem): $menu_post = get_term($menuitem->object_id); ?>
                        <a class="dropdown-item py-0" data-slug="<?php echo $menu_post->slug; ?>" href="#<?php echo $menu_post->slug; ?>"><?php echo pror_get_section_name($menu_post); ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="right">
                    <?php foreach ($two as $menuitem): $menu_post = get_term($menuitem->object_id); ?>
                        <a class="dropdown-item py-0" data-slug="<?php echo $menu_post->slug; ?>" href="#<?php echo $menu_post->slug; ?>"><?php echo pror_get_section_name($menu_post); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form class="form-inline my-2 my-lg-0 ml-5 mr-auto d-none d-md-block">
<!--                <div class="input-group">-->
<!--                    <input type="text" size="40" class="form-control form-control-sm" placeholder="Ремонт санузла">-->
<!--                    <span class="input-group-btn">-->
<!--                        <button class="btn btn-sm btn-outline-success" type="button">Поиск</button>-->
<!--                    </span>-->
<!--                </div>-->
            </form>

            <ul class="navbar-nav">
                <?php pll_the_languages([
                        'hide_if_no_translation' => 0,
                        'hide_if_empty' => 0,
                        'show_flags' => 1,
                        'show_names' => 0,
                ]);?>
                    <li class="nav-item"><a href="<?php echo home_url('/blog/'); ?>" class="nav-link"><?php _e('Блог', 'common'); ?></a></li>
                <li class="nav-item"><a href="<?php echo home_url('/catalog/'); ?>" class="nav-link find-master"><?php _e('Найти мастера', 'common'); ?></a></li>
                <li class="nav-item"><a href="<?php echo home_url('/informacia-dlya-masterov/'); ?>" class="nav-link iam-master"><?php _e('Стать исполнителем', 'common'); ?></a></li>
            </ul>

            <?php module_template('master/menu/top'); ?>
        </div>
    </div>
</nav>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>

