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

                <?php wp_nav_menu(array(
                        'container' => false,
                        'menu_class' => 'list-unstyled list-inline footer-menu',
                        'theme_location' => 'footer_main',
                )); ?>

                <p class="copyright">
                    2017 &copy; ProRemont. Все права защищены.
                </p>
            </div>

            <div class="col-md-4">
                <div class="fb-page" data-href="https://www.facebook.com/ProRemont.Catalog/" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/ProRemont.Catalog/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ProRemont.Catalog/">ProRemont - Каталог Мастеров с рейтингами со всей Украины.</a></blockquote></div>
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

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.11&appId=535430443460993';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
