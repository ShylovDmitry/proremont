<div class="row profile-login">
    <?php if (is_user_logged_in()): ?>
        <div class="col-12">
            <?php printf(
                __( 'Вы уже зарегистрированы. Перейдите в свой <a href="%s">профиль</a>.', 'common' ),
                pror_get_permalink_by_slug('profile')
            ); ?>
        </div>
    <?php else: ?>
        <div class="col-12">
            <h2 class="mb-4"><?php _e( 'Вход', 'common' ); ?></h2>

            <?php module_template('profile/errors', ['param_key' => 'login']) ?>

            <?php if ( isset($_REQUEST['logged_out']) && $_REQUEST['logged_out'] == true ) : ?>
                <div class="alert alert-warning" role="alert">
                    <?php _e( 'Вы вышли.', 'common' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $_REQUEST['registered'] ) : ?>
                <div class="alert alert-success" role="alert">
                    <?php
                        printf(
                            __( 'Вы успешно зарегистрировались на ProRemont. Мы отправили письмо с паролем на <strong>%s</strong>.', 'common' ),
                            $_REQUEST['registered']
                        );
                    ?>
                </div>
            <?php endif; ?>

            <?php if ( isset($_REQUEST['checkemail']) && $_REQUEST['checkemail'] == 'confirm' ) : ?>
                <div class="alert alert-warning" role="alert">
                    <?php _e( 'Проверьте вашу почту для восстановления пароля.', 'common' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed' ) : ?>
                <div class="alert alert-success" role="alert">
                    <?php _e( 'Ваш пароль был изменен. Теперь можете войти на сайт.', 'common' ); ?>
                </div>
            <?php endif; ?>


            <div class="mb-1"><?php _e('Используйте социальные сети, чтобы войти:', 'common'); ?></div>
            <?php echo oa_social_login_render_login_form ('custom', ['callback_uri' => $_GET['redirect_to'] ? $_GET['redirect_to'] : pror_get_permalink_by_slug('profile')]); ?>

            <hr />

            <div class="mb-1 mt-3"><?php _e('Или введите свой Email и пароль:', 'common'); ?></div>
            <form method="post" action="<?php echo wp_login_url($_GET['redirect_to']); ?>" class="form-container from-validation-simple">
                <div class="form-group">
                    <label for="user_login" class="form-label"><?php _e( 'Email', 'common' ); ?></label>
                    <input type="email" name="log" id="user_login" class="form-control" required="required" />
                </div>
                <div class="form-group">
                    <label for="user_pass" class="form-label"><?php _e( 'Пароль', 'common' ); ?></label>
                    <input type="password" name="pwd" id="user_pass" class="form-control" required="required" />
                </div>
                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="rememberme" id="id_remember" value="forever" />
                    <label class="form-check-label" for="id_remember">
                        <?php _e( 'Запомнить меня', 'common' ); ?>
                    </label>
                </div>

                <div>
                    <button type="submit" class="btn btn-pror-primary"><?php _e( 'Войти', 'common' ); ?></button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
                        <?php _e( 'Забыли пароль?', 'common' ); ?>
                    </a>
                </div>
            </form>
        </div>
        <div class="col-12 mt-3">
            <div class="register-links">
                <h3 class="mb-4"><?php _e( 'Регистрация', 'common' ); ?></h3>

                <div class="row">
                    <div class="col-6">
                        <h5><?php _e( 'Вы - посетитель?', 'common' ); ?></h5>

                        <p><?php _e('Ищете мастеров, дизайнеров, строителей? Регистрируйтесь, чтобы получить полный доступ к сайту.', 'common'); ?></p>
                        <a href="<?php echo wp_registration_url(); ?>" class="btn btn-pror-primary"><?php _e( 'Зарегистрироваться как<br/><b>Посетитель</b>', 'common' ); ?></a>
                    </div>
                    <div class="col-6">
                        <h5><?php _e( 'Вы - исполнитель?', 'common' ); ?></h5>

                        <p><?php _e('Предоставляете услуги? Регистрируйтесь и наши посетители узнают о вас.', 'common'); ?></p>
                        <a href="<?php echo pror_get_permalink_by_slug('register-master'); ?>" class="btn btn-pror-primary"><?php _e( 'Зарегистрироваться как<br/><b>Исполнитель</b>', 'common' ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
