<div class="profile-login">
    <?php if (is_user_logged_in()): ?>
        <?php
            printf(
                __( 'Вы уже зарегистрированы. Перейдите в свой <a href="%s">профиль</a>.', 'common' ),
                home_url('profile')
            );
        ?>
    <?php else: ?>
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
                        __( 'Вы успешно зарегестрировались на ProRemont. Мы отправили письм с паролем на <strong>%s</strong>.', 'common' ),
                        $_REQUEST['registered']
                    );
                ?>
            </div>
        <?php endif; ?>

        <?php if ( isset($_REQUEST['checkemail']) && $_REQUEST['checkemail'] == 'confirm' ) : ?>
            <div class="alert alert-warning" role="alert">
                <?php _e( 'Проверьте вашу почту для востановления пароля.', 'common' ); ?>
            </div>
        <?php endif; ?>

        <?php if ( isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed' ) : ?>
            <div class="alert alert-success" role="alert">
                <?php _e( 'Ваш пароль был изменен. Теперь можете ввойти на сайт.', 'common' ); ?>
            </div>
        <?php endif; ?>


        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="mb-1">Используйте социальные сети что бы войти:</div>
                <?php echo oa_social_login_render_login_form ('custom', ['callback_uri' => $_GET['redirect_to'] ? $_GET['redirect_to'] : home_url('profile')]); ?>

                <hr />

                <div class="mb-1 mt-3">Или введите свой Email и пароль:</div>
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
                            <?php _e( 'Забыл пароль?', 'common' ); ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <a href="<?php echo wp_registration_url(); ?>">
            <?php _e( 'Зарегистрироваться &raquo;', 'common' ); ?>
        </a>
    <?php endif; ?>
</div>
