<?php
$cache_obj = pror_cache_obj(0, 'lang', 'pror:theme:footer', '');
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="footer mt-5 py-4">
    <div class="container pt-4">
        <div class="row">

            <div class="col-12 col-sm-6 col-lg-4 order-3 order-sm-2 order-lg-1">
                <?php _e('Язык', 'common'); ?>
                <ul class="list-unstyled list-langs">
                    <?php pll_the_languages([
                            'hide_if_no_translation' => 0,
                            'hide_if_empty' => 0,
                            'show_flags' => 1,
                            'show_names' => 0,
                    ]);?>
                </ul>

                <ul class="list-inline social-icons">
                    <li class="list-inline-item"><a href="https://www.facebook.com/ProRemont.Catalog/" target="_blank"><?php module_svg('theme/iconmonstr-facebook-3.svg'); ?></a></li>
                    <li class="list-inline-item"><a href="https://www.instagram.com/proremont.catalog/" target="_blank"><?php module_svg('theme/iconmonstr-instagram-3.svg'); ?></a></li>
                    <li class="list-inline-item"><a href="https://plus.google.com/116406093379791925793" target="_blank"><?php module_svg('theme/iconmonstr-google-plus-3.svg'); ?></a></li>
                    <li class="list-inline-item"><a href="https://vk.com/proremont.catalog" target="_blank"><?php module_svg('theme/iconmonstr-vk-3.svg'); ?></a></li>
                </ul>

                <p><a href="mailto:info@proremont.co" class="email-link">info@proremont.co</a></p>

                <?php wp_nav_menu(array(
                        'container' => false,
                        'menu_class' => 'list-unstyled list-inline footer-menu',
                        'theme_location' => 'footer_main',
                )); ?>

                <p class="copyright"><?php echo date('Y'); ?> <?php _e('&copy; ProRemont. Все права защищены.', 'common'); ?></p>
            </div>

            <div class="col-12 col-lg-4 order-1 order-lg-2 mb-5 mb-lg-0">
                <p><strong><?php _e('Блог', 'common'); ?></strong></p>

                <div class="blog-list">
                    <?php module_template('blog/list-categories'); ?>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 order-2 order-sm-3 mb-5 mb-sm-0">
                <p><strong><?php _e('Для мастеров', 'common'); ?></strong></p>
                <?php wp_nav_menu(array(
                        'container' => false,
                        'menu_class' => 'list-unstyled footer-menu-master',
                        'theme_location' => 'footer_master',
                )); ?>
            </div>
        </div>
    </div>
</div>

<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>
