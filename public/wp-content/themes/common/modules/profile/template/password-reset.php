<div class="profile-login">
    <?php if (!isset( $_REQUEST['login'] ) || !isset( $_REQUEST['key'] )): ?>
        <?php _e( 'Неверная ссылка для возобновления пароля.', 'common' ); ?>
    <?php else: ?>
        <h2 class="mb-4"><?php _e( 'Установить пароль', 'common' ); ?></h2>

        <p><?php printf(
                __('Уже зарегистрированы? <a href="%s">Войти &raquo;</a>', 'common'),
                wp_login_url()
            ); ?></p>

        <?php module_template('profile/errors', ['param_key' => 'error']) ?>

        <div class="row mb-3">
            <div class="col-12">
                <form action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off" class="form-container from-validation-simple">
                    <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $_REQUEST['login'] ); ?>" />
                    <input type="hidden" name="rp_key" value="<?php echo esc_attr( $_REQUEST['key'] ); ?>" />

                    <div class="form-group">
                        <label for="pass1" class="form-label"><?php _e( 'Новый пароль', 'common' ); ?></label>
                        <input type="password" name="pass1" id="pass1" class="form-control" autocomplete="off" />
                    </div>

                    <div class="form-group">
                        <label for="pass2" class="form-label"><?php _e( 'Повторите новый пароль', 'common' ); ?></label>
                        <input type="password" name="pass2" id="pass2" class="form-control" autocomplete="off" data-rule-equalto="#pass1" />
                    </div>

                    <button type="submit" class="btn btn-pror-primary"><?php _e( 'Установить пароль', 'common' ); ?></button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
