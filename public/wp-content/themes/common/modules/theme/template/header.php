<nav class="navbar navbar-expand">
    <div class="container">
        <a class="navbar-brand" href="<?php echo home_url(pror_get_section()->slug . '/'); ?>">
            <img src="<?php module_img('theme/proremont-co-logo-white.png'); ?>" height="40px" alt="ProRemont logo" />
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo pror_get_section()->name; ?>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <?php
                        $menu_name = 'header_dropdown';
                        $locations = get_nav_menu_locations();
                        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
                        $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
                    ?>
                    <?php foreach ($menuitems as $menuitem): $menu_post = wp_get_nav_menu_object($menuitem->object_id); ?>
                        <a class="dropdown-item py-0" href="<?php echo home_url( $wp->request . '/' ); ?>?f_switch_section=<?php echo $menu_post->term_id; ?>"><?php echo $menu_post->name; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <form class="form-inline my-2 my-lg-0 ml-5 mr-auto d-none d-md-block">
<!--                <div class="input-group">-->
<!--                    <input type="text" size="40" class="form-control form-control-sm" placeholder="Ремонт санузла">-->
<!--                    <span class="input-group-btn">-->
<!--                        <button class="btn btn-sm btn-outline-success" type="button">Поиск</button>-->
<!--                    </span>-->
<!--                </div>-->
            </form>

            <?php wp_nav_menu(array(
                    'container' => false,
                    'menu_class' => 'navbar-nav d-none d-md-block',
                    'theme_location' => 'header_main',
            )); ?>

            <?php module_template('master/menu/top'); ?>
        </div>
    </div>
</nav>
