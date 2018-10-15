<div class="profile-login">
    <?php if (is_user_logged_in()): ?>
        <?php _e( 'Вы уже зарегистрированы.', 'common' ); ?>
    <?php else: ?>
        <h2 class="mb-4"><?php _e( 'Забыл пароль?', 'common' ); ?></h2>

        <?php module_template('profile/errors', ['param_key' => 'errors']) ?>

        <p><?php _e("Введите email и мы отправим ссылку для востановления пароля.", 'common'); ?></p>

        <div class="row mb-3">
            <div class="col-sm-6">
                <form action="<?php echo wp_lostpassword_url(); ?>" method="post" class="form-container from-validation-simple">
                    <div class="form-group">
                        <label for="user_login" class="form-label"><?php _e( 'Email', 'common' ); ?></label>
                        <input type="email" name="user_login" id="user_login" class="form-control" required="required" />
                    </div>

                    <button type="submit" class="btn btn-pror-primary"><?php _e( 'Востановить пароль', 'common' ); ?></button>
                </form>
            </div>
        </div>

        <p><?php printf(
            __('<a href="%s">Войти</a> на сайт.', 'common'),
            wp_login_url()
        ); ?></p>
    <?php endif; ?>
</div>
