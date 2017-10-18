<div class="footer mt-5 py-4">
    <div class="container pt-4">
        <div class="row">

            <div class="col-sm-4">
                <p>
                    <strong>Служба поддержки:</strong>
                </p>
                <p>
                    <a href="mailto:ProRemont.Catalog@gmail.com">ProRemont.Catalog@gmail.com</a>
                </p>
                <p>
                    2017 &copy; ProRemont. Все права защищены.
                </p>
            </div>

            <div class="col-sm-4">
                <p>
                    Ми в соцсетях:
                </p>
                <ul class="list-unstyled list-inline">
                    <li class="list-inline-item"><a href="https://www.facebook.com/ProRemont.Catalog/" target="_blank"><img src="<?php module_img('theme/social-facebook.png'); ?>" width="40" height="40" /></a></li>
                </ul>
            </div>

            <div class="col-sm-4">
                <?php wp_nav_menu(array(
                        'container' => false,
                        'menu_class' => 'list-unstyled list-inline',
                        'theme_location' => 'footer_main',
                )); ?>
            </div>
        </div>

<!--        <div class="row">-->
<!--            <div class="col-sm-8">-->
<!--                --><?php //wp_nav_menu(array(
//                        'container' => false,
//                        'menu_class' => 'list-unstyled list-inline',
//                        'theme_location' => 'footer_secondary',
//                )); ?>
<!--            </div>-->
<!--        </div>-->
    </div>
</div>
