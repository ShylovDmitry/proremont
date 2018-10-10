<?php if (is_user_logged_in()): ?>
    <?php _e( 'Вы уже зарегистрированы.', 'common' ); ?>
<?php elseif (!get_option('users_can_register')): ?>
    <?php _e( 'Регистрация для новых пользователей временно закрыта.', 'common' ); ?>
<?php else: ?>

    <div class="profile-register">
        <h2 class="mb-4"><?php _e( 'Регистрация для исполнителей', 'common' ); ?></h2>

        <p><?php printf(
                __('Уже зарегистрированы? <a href="%s">Войти</a> на сайт.', 'common'),
                wp_login_url()
            ); ?></p>

        <?php module_template('profile/errors', ['param_key' => 'register-errors']) ?>

        <div class="mb-3">
            <div class="text-right">
                <a href="<?php echo home_url('register-master'); ?>">
                    <?php _e( 'Регистрация для пользователей &raquo;', 'common' ); ?>
                </a>
            </div>

            <form action="<?php echo wp_registration_url(); ?>" method="post" class="form-container">
                <input type="hidden" name="account_type" value="master" />


                <h3 class="mb-3">Данные для входа</h3>

                <div class="form-group">
                    <label for="email" class="form-label"><?php _e( 'Email', 'common' ); ?> <strong>*</strong></label>
                    <input type="text" name="email" id="email" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="first_name" class="form-label"><?php _e( 'Имя', 'common' ); ?></label>
                    <input type="text" name="first_name" id="first_name" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label"><?php _e( 'Фамилия', 'common' ); ?></label>
                    <input type="text" name="last_name" id="last_name" class="form-control" />
                </div>

                <hr class="mb-4 mt-4" />

                <h3 class="mb-3">Информация</h3>

                <div class="form-group">
                    <label for="user_title" class="form-label"><?php _e( 'Название', 'common' ); ?> <strong>*</strong></label>
                    <input type="text" name="user_title" id="user_title" class="form-control" />
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e( 'Тип', 'common' ); ?> <strong>*</strong></label>

                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="user_type" id="user_type_master" value="master" checked />
                            <label class="form-check-label" for="user_type_master">
                                <?php _e( 'Мастер', 'common' ); ?>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="user_type" id="user_type_brigada" value="brigada" />
                            <label class="form-check-label" for="user_type_brigada">
                                <?php _e( 'Бригада', 'common' ); ?>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="user_type" id="user_type_kompania" value="kompania" />
                            <label class="form-check-label" for="user_type_kompania">
                                <?php _e( 'Компания', 'common' ); ?>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="user_tel" class="form-label"><?php _e( 'Телефон', 'common' ); ?> <strong>*</strong></label>
                    <input type="tel" name="user_tel" id="user_tel" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="user_city" class="form-label"><?php _e( 'Город', 'common' ); ?> <strong>*</strong></label>
                    <select class="w-100" name="user_city" id="user_city"></select>
                </div>

                <div class="form-group">
                    <label for="user_website" class="form-label"><?php _e( 'Сайт', 'common' ); ?></label>
                    <input type="text" name="user_website" id="user_website" class="form-control" />
                </div>

                <hr class="mb-4 mt-4" />

                <h3 class="mb-3"><label for="user_description" class="form-label"><?php _e( 'Описание', 'common' ); ?> <strong>*</strong></label></h3>

                <div class="form-group">
                    <?php wp_editor('', 'user_description', [
                            'media_buttons' => false,
                            'quicktags' => false,
                            'tinymce' => [
                                'statusbar' => false,
                                'branding' => false,
                                'toolbar1' => 'bold bullist numlist header',
                                'toolbar2' => false,
                                'plugins' => 'lists header-button',
                            ],
                    ]); ?>
                </div>

                <hr class="mb-4 mt-4" />

                <h3 class="mb-3"><label class="form-label"><?php _e( 'Категории', 'common' ); ?> <strong>*</strong></label></h3>

                <div class="form-group">
                    <?php foreach(pror_get_catalog() as $main_catalog): ?>
                        <div>
                            <strong><?php echo $main_catalog->name; ?></strong><br />
                            <?php foreach (pror_get_catalog($main_catalog->term_id) as $index => $sub_catalog): ?>
                                <label class="form-check-label">
                                    <input type="checkbox" name="user_catalog_master[]" value="<?php echo $sub_catalog->term_id; ?>" />
                                    <?php echo $sub_catalog->name; ?>
                                </label><br />
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>


                <hr>

                <div class="form-group">
                    <small class="form-text text-muted">
                        <?php _e( '<strong>Заметка:</strong> Ваш пароль будет автоматически сгенерирован и отправлен на ваш Email.', 'common' ); ?>
                    </small>
                </div>
                <div class="form-group">
                    <?php printf(
                            __('Нажимая расположенную ниже кнопку «Зарегистрироваться», вы принимаете <a href="%s">условия использования сайта</a> и <a href="%s">политику конфиденциальности</a>.', 'common'),
                            pror_get_permalink_by_slug('politika-konfidenciynosti'),
                            pror_get_permalink_by_slug('politika-konfidenciynosti')
                    ); ?>
                </div>

                <button type="submit" class="btn btn-pror-primary"><?php _e( 'Зарегистрироваться', 'common' ); ?></button>
            </form>
        </div>

    </div>
<?php endif; ?>