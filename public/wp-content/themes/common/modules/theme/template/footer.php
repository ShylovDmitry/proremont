<div class="footer mt-5 py-4">
    <div class="container pt-4">
        <div class="row">

            <div class="col-md-4">
                <p>
                    <strong>Служба поддержки:</strong>
                </p>
                <p>
                    <a href="mailto:ProRemont.Catalog@gmail.com">ProRemont.Catalog@gmail.com</a>
                </p>
                <p class="copyright">
                    2017 &copy; ProRemont. Все права защищены.
                </p>
            </div>

            <div class="col-md-4">
                <p>
                    Мы в соцсетях:
                </p>
                <ul class="list-unstyled list-inline">
                    <li class="list-inline-item"><a href="https://www.facebook.com/ProRemont.Catalog/" target="_blank"><img src="<?php module_img('theme/social-facebook.png'); ?>" width="40" height="40" /></a></li>
                </ul>

                <?php wp_nav_menu(array(
                        'container' => false,
                        'menu_class' => 'list-unstyled list-inline footer-menu',
                        'theme_location' => 'footer_main',
                )); ?>
            </div>

            <div class="col-md-4">
                <p>
                    <strong>Для мастеров:</strong>
                </p>
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
