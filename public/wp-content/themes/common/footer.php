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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/slick-lightbox.min.js"></script>

    <script src="<?php echo get_template_directory_uri(); ?>/js/common.js"></script>

    <?php wp_footer(); ?>
</body>
</html>
