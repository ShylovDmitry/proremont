<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key('block', 'lang');
$cache_group = 'pror:theme:footer';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<div class="footer mt-5 py-4">
    <div class="container pt-4">
        <div class="row">

            <div class="col-12 col-sm-6 col-lg-4 order-3 order-sm-2 order-lg-1">
                <?php _e('Язык:', 'common'); ?>
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
                <div class="fb-page" data-href="https://www.facebook.com/ProRemont.Catalog/" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/ProRemont.Catalog/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ProRemont.Catalog/"><?php _e('ProRemont - Каталог Мастеров с рейтингами со всей Украины.', 'common'); ?></a></blockquote></div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 order-2 order-sm-3 mb-5 mb-sm-0">
                <p><strong><?php _e('Для мастеров:', 'common'); ?></strong></p>
                <?php module_template('master/menu/advanced'); ?>

                <?php wp_nav_menu(array(
                        'container' => false,
                        'menu_class' => 'list-unstyled footer-menu-master',
                        'theme_location' => 'footer_master',
                )); ?>
            </div>
        </div>
    </div>
</div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.11&appId=535430443460993';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>

