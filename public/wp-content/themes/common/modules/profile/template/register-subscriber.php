<div class="profile-register">
    <?php if (is_user_logged_in()): ?>
        <?php _e( 'Вы уже зарегистрированы.', 'common' ); ?>
    <?php elseif (!get_option('users_can_register')): ?>
        <?php _e( 'Регистрация для новых пользователей временно закрыта.', 'common' ); ?>
    <?php else: ?>
        <h2 class="mb-4"><?php _e( 'Регистрация', 'common' ); ?></h2>

        <p>
            <?php printf(
                __('Уже зарегистрированы? <a href="%s">Войти</a> на сайт.', 'common'),
                wp_login_url()
            ); ?>
        </p>

        <?php module_template('profile/errors', ['param_key' => 'register-errors']) ?>

        <div class="row mb-3">
            <div class="col-sm-6">

                <div class="text-right">
                    <a href="<?php echo pror_get_permalink_by_slug('register-master'); ?>">
                        <?php _e( 'Регистрация для исполнителей &raquo;', 'common' ); ?>
                    </a>
                </div>

                <form action="<?php echo wp_registration_url(); ?>" method="post" class="form-container from-validation-simple">
                    <input type="hidden" name="user_role" value="subscriber" />

                    <div class="form-group">
                        <label for="email" class="form-label"><?php _e( 'Email', 'common' ); ?> <span class="required">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" required="required" />
                    </div>

                    <div class="form-group">
                        <label for="tel" class="form-label"><?php _e( 'Телефон', 'common' ); ?> <span class="required">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">+380</span>
                            </div>
                            <input type="tel" name="tel" id="tel" class="form-control" minlength="9" maxlength="9" required="required" data-rule-digits="true" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="first_name" class="form-label"><?php _e( 'Имя', 'common' ); ?> <span class="required">*</span></label>
                        <input type="text" name="first_name" id="first_name" class="form-control" required="required" />
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="form-label"><?php _e( 'Фамилия', 'common' ); ?> <span class="required">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="form-control" required="required" />
                    </div>

                    <div class="form-group">
                        <small class="form-text text-muted">
                            <?php _e( '<strong>Заметка:</strong> Пароль будет сгенерирован автоматически и отправлен на ваш Email.', 'common' ); ?>
                        </small>
                    </div>

                    <button type="submit" class="btn btn-pror-primary"><?php _e( 'Зарегистрироваться', 'common' ); ?></button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
