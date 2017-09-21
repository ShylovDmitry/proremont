<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php wp_title('&ndash;', true, 'right'); ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link href="<?php echo get_template_directory_uri(); ?>/css/open-iconic/css/open-iconic-bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css">
    <link href="<?php echo get_template_directory_uri(); ?>/css/slick-lightbox.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/common.css">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
    <div class="container">
        <a class="navbar-brand" href="<?php echo home_url(pror_get_section()->slug . '/'); ?>">ProRemont.UA</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="dropdown">
                <a class="nav-link text-success dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a class="dropdown-item py-0" href="<?php echo home_url( $wp->request . '/' ); ?>?change_section=<?php echo $menu_post->slug; ?>"><?php echo $menu_post->name; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <form class="form-inline my-2 my-lg-0 ml-5 mr-auto">
<!--                <div class="input-group">-->
<!--                    <input type="text" size="40" class="form-control form-control-sm" placeholder="Ремонт санузла">-->
<!--                    <span class="input-group-btn">-->
<!--                        <button class="btn btn-sm btn-outline-success" type="button">Поиск</button>-->
<!--                    </span>-->
<!--                </div>-->
            </form>

            <?php wp_nav_menu(array(
                    'container' => false,
                    'menu_class' => 'navbar-nav',
                    'theme_location' => 'header_main',
            )); ?>
        </div>
    </div>
</nav>
