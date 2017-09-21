<div class="colored-box mt-4 py-4">
    <div class="container pt-4">
        <div class="row">

            <div class="col-4">
                <p>
                    <strong>Служба підтримки:</strong>
                </p>
                <p>
                    <a href="#">(063) 155 55 25</a>
                    <br />
                    <a href="#">ProRemont.UA@gmail.com</a>
                </p>
            </div>

            <div class="col-3">
                <p>
                    Ми в соцмережах:
                </p>
                <ul class="list-unstyled list-inline">
                    <li class="list-inline-item"><a href="#">Facebook</a></li>
                    <li class="list-inline-item"><a href="#">Google+</a></li>
                </ul>
            </div>

            <div class="col">
                <?php wp_nav_menu(array(
                        'container' => false,
                        'menu_class' => 'list-unstyled list-inline',
                        'theme_location' => 'footer_main',
                )); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <p>
                    2017 &copy; ProRemont.UA. Все права защищены.
                </p>
            </div>
            <div class="col-3">
                <?php wp_nav_menu(array(
                        'container' => false,
                        'menu_class' => 'list-unstyled list-inline',
                        'theme_location' => 'footer_secondary',
                )); ?>
            </div>
        </div>
    </div>
</div>
