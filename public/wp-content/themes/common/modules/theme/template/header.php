<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo home_url(pror_get_section()->slug . '/'); ?>">
            <img src="<?php module_img('theme/proremont-co-logo-white.png'); ?>" height="40px" alt="ProRemont logo" />
        </a>

        <div class="dropdown section-list invisible">
            <a class="nav-link dropdown-toggle" href="#" data-slug="<?php echo pror_get_section()->slug; ?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php module_svg('theme/ic_location_on_black_18px.svg'); ?> <span><?php echo pror_get_section()->name; ?></span>
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <?php
                    global $wp;
                    $locations = get_nav_menu_locations();
                    $menu = wp_get_nav_menu_object( $locations['header_dropdown'] );
                    $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
                ?>
                <?php foreach ($menuitems as $menuitem): $menu_post = get_term($menuitem->object_id); ?>
                    <a class="dropdown-item py-0" data-slug="<?php echo $menu_post->slug; ?>" href="<?php echo home_url( $wp->request . '/' ); ?>?f_switch_section=<?php echo $menu_post->slug; ?>"><?php echo $menu_post->name; ?></a>
                <?php endforeach; ?>
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
                <li>
                    <a href="#" class="btn find-master">Найти мастера</a>
                    <a href="#" class="btn iam-master">Стать исполнителем</a>
                </li>
            </ul>

            <?php module_template('master/menu/top'); ?>
        </div>
    </div>
</nav>
