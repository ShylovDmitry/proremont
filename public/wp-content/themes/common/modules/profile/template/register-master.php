<?php
$is_migrate_subscriber = is_user_logged_in() && pror_user_has_role('subscriber');
$userdata = get_userdata(get_current_user_id());
?>
<div class="profile-register">
    <?php if (is_user_logged_in() && pror_user_has_role('master')): ?>
        <?php printf(
            __( 'Вы уже зарегистрированы. Перейдите в свой <a href="%s">профиль</a>.', 'common' ),
            pror_get_permalink_by_slug('profile')
        ); ?>
    <?php elseif (!get_option('users_can_register')): ?>
        <?php _e( 'Регистрация для новых пользователей временно закрыта.', 'common' ); ?>
    <?php else: ?>
        <h2 class="mb-4"><?php _e( 'Регистрация для исполнителей', 'common' ); ?></h2>

        <p><?php printf(
                __('Уже зарегистрированы? <a href="%s">Войти &raquo;</a>', 'common'),
                wp_login_url()
            ); ?></p>

        <?php module_template('profile/errors', ['param_key' => 'register-errors']) ?>

        <div class="row mb-3">
            <div class="col-sm-12">

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo pror_get_permalink_by_slug('register-master'); ?>">Исполнитель</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo wp_registration_url(); ?>"><?php _e( 'Регистрация для Посетителя', 'common' ); ?> &raquo;</a>
                    </li>
                </ul>

                <form action="<?php echo wp_registration_url(); ?>" method="post" class="form-container from-validation-advanced">
                    <input type="hidden" name="user_role" value="master" />

                    <h3 class="mb-3"><?php _e('Личные данные', 'common'); ?></h3>

                    <div class="form-group">
                        <label for="email" class="form-label"><?php _e( 'Email', 'common' ); ?> <span class="required">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" required="required" value="<?php echo $userdata->user_email; ?>"<?php if ($is_migrate_subscriber): ?> disabled="disabled"<?php endif; ?> />
                    </div>

                    <div class="form-group">
                        <label for="tel" class="form-label"><?php _e( 'Телефон', 'common' ); ?> <span class="required">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">+380</span>
                            </div>
                            <input type="tel" name="tel" id="tel" class="form-control" minlength="9" maxlength="9" required="required" data-rule-digits="true" value="<?php echo get_field('contact_phone', "user_{$userdata->ID}"); ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="first_name" class="form-label"><?php _e( 'Имя', 'common' ); ?> <span class="required">*</span></label>
                        <input type="text" name="first_name" id="first_name" class="form-control" required="required" value="<?php echo $userdata->first_name; ?>" />
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="form-label"><?php _e( 'Фамилия', 'common' ); ?> <span class="required">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="form-control" required="required" value="<?php echo $userdata->last_name; ?>" />
                    </div>

                    <hr class="mb-4 mt-4" />

                    <h3 class="mb-3"><?php _e('Информация', 'common'); ?></h3>

                    <div class="form-group">
                        <label class="form-label"><?php _e( 'Тип', 'common' ); ?> <span class="required">*</span></label>

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
                        <label for="user_title" class="form-label"><?php _e( 'Название', 'common' ); ?> <span class="required">*</span></label>
                        <input type="text" name="user_title" id="user_title" class="form-control" required="required" />
                    </div>

                    <div class="form-group">
                        <label for="user_tel" class="form-label"><?php _e( 'Рабочий телефон', 'common' ); ?> <span class="required">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">+380</span>
                            </div>
                            <input type="tel" name="user_tel" id="user_tel" class="form-control" minlength="9" maxlength="9" required="required" data-rule-digits="true" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_city" class="form-label"><?php _e( 'Город', 'common' ); ?> <span class="required">*</span></label>
                        <select class="w-100" name="user_city" id="user_city" required="required"></select>
                    </div>

                    <div class="form-group">
                        <label for="user_website" class="form-label"><?php _e( 'Сайт', 'common' ); ?></label>
                        <input type="text" name="user_website" id="user_website" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="categories" class="form-label"><?php _e( 'Основные категории', 'common' ); ?> <span class="required">*</span></label>

                        <select id="categories" name="user_catalog_master[]" multiple="multiple" class="form-control" style="" data-placeholder="Выбирете категории" lang="<?php echo pll_current_language(); ?>" required="required">
                            <?php foreach(pror_get_catalog() as $main_catalog): ?>
                                <optgroup label="<?php echo $main_catalog->name; ?>">
                                    <?php foreach (pror_get_catalog($main_catalog->term_id) as $index => $sub_catalog): ?>
                                        <option value="<?php echo $sub_catalog->term_id; ?>"><?php echo $sub_catalog->name; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr class="mb-4 mt-4" />

                    <h3 class="mb-3"><label for="user_description" class="form-label"><?php _e( 'Описание', 'common' ); ?> <span class="required">*</span></label></h3>

                    <div class="form-group">
                        <?php wp_editor('', 'user_description', [
                                'mode' => "textareas",
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

                    <hr>

                    <div class="form-group">
                        <small class="form-text text-muted">
                            <?php _e( '<strong>Заметка:</strong> Пароль будет сгенерирован автоматически и отправлен на ваш Email.', 'common' ); ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <?php printf(
//                                __('Зарегистрировавшись, вы принимаете <a href="%s">условия использования сайта</a> и <a href="%s">политику конфиденциальности</a>.', 'common'),
                                __('Нажимая кнопку «Зарегистрироваться», вы принимаете <a href="%s">политику конфиденциальности</a>.', 'common'),
//                                pror_get_permalink_by_slug('politika-konfidenciynosti'),
                                pror_get_permalink_by_slug('politika-konfidenciynosti')
                        ); ?>
                    </div>

                    <button type="submit" class="btn btn-pror-primary"><?php _e( 'Зарегистрироваться', 'common' ); ?></button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
