<?php
$acf_key = 'user_' . get_current_user_id();
?>
<div class="profile-settings">
    <?php module_template('profile/errors', ['param_key' => 'errors']) ?>

    <?php if ( $_REQUEST['success'] ) : ?>
        <div class="alert alert-success" role="alert">
            <?php _e('Данные успешно обновлены.', 'common'); ?>
        </div>
    <?php endif; ?>


    <?php $userdata = get_userdata(get_current_user_id()); ?>
    <form action="" method="post" class="form-container from-validation-advanced">
        <input type="hidden" name="profile_update_type" value="master" />

        <div class="form-group">
            <label for="tel" class="form-label"><?php _e( 'Телефон', 'common' ); ?> <span class="required">*</span></label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">+380</span>
                </div>
                <input type="tel" name="tel" id="tel" class="form-control" value="<?php the_field('contact_phone', 'user_' . $userdata->ID); ?>" minlength="9" maxlength="9" required="required" data-rule-digits="true" />
            </div>
        </div>

        <div class="form-group">
            <label for="first_name" class="form-label"><?php _e( 'Имя', 'common' ); ?> <span class="required">*</span></label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $userdata->first_name; ?>" required="required" />
        </div>

        <div class="form-group">
            <label for="last_name" class="form-label"><?php _e( 'Фамилия', 'common' ); ?> <span class="required">*</span></label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $userdata->last_name; ?>" required="required" />
        </div>


        <hr class="mb-4 mt-4" />

        <h3 class="mb-3"><?php _e('Информация', 'common'); ?></h3>

        <div class="form-group">
            <label class="form-label"><?php _e( 'Тип', 'common' ); ?> <span class="required">*</span></label>

            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user_type" id="user_type_master" value="master"<?php if (get_field('master_type', $acf_key, false) == 'master'): ?> checked<?php endif; ?> />
                    <label class="form-check-label" for="user_type_master">
                        <?php _e( 'Мастер', 'common' ); ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user_type" id="user_type_brigada" value="brigada"<?php if (get_field('master_type', $acf_key, false) == 'brigada'): ?> checked<?php endif; ?> />
                    <label class="form-check-label" for="user_type_brigada">
                        <?php _e( 'Бригада', 'common' ); ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user_type" id="user_type_kompania" value="kompania"<?php if (get_field('master_type', $acf_key, false) == 'kompania'): ?> checked<?php endif; ?> />
                    <label class="form-check-label" for="user_type_kompania">
                        <?php _e( 'Компания', 'common' ); ?>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="user_title" class="form-label"><?php _e( 'Название', 'common' ); ?> <span class="required">*</span></label>
            <input type="text" name="user_title" id="user_title" class="form-control" value="<?php echo get_field('master_title', $acf_key); ?>" required="required" />
        </div>

        <div class="form-group">
            <label class="form-label"><?php _e( 'Лого', 'common' ); ?></label>
            <div class="image-container">
                <?php $logo_id = get_field('master_logo', $acf_key, false); ?>
                <?php list($url,) = wp_get_attachment_image_src($logo_id, 'pror-medium'); ?>

                <div id="logo-block">
                <?php if ($logo_id): ?>
                    <div data-image-id="<?php echo $logo_id; ?>">
                        <input type="hidden" name="logo_id" value="<?php echo $logo_id; ?>">
                        <div class="image-wrapper">
                            <button type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <img src="<?php echo $url; ?>">
                        </div>
                    </div>
                <?php endif; ?>
                </div>

                <span class="btn btn-pror-primary btn-sm upload-logo fileinput-button<?php if ($logo_id): ?> d-none<?php endif; ?>">
                    <span><?php _e('Добавить лого', 'common'); ?></span>
                    <input id="logoupload" type="file" name="files">
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="user_tel" class="form-label"><?php _e( 'Рабочий телефон', 'common' ); ?> <span class="required">*</span></label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">+380</span>
                </div>
                <input type="tel" name="user_tel" id="user_tel" class="form-control" value="<?php the_field('master_phone', 'user_' . $userdata->ID); ?>" minlength="9" maxlength="9" required="required" data-rule-digits="true" />
            </div>
        </div>

        <div class="form-group">
            <label for="user_city" class="form-label"><?php _e( 'Город', 'common' ); ?> <span class="required">*</span></label>
            <select class="w-100" name="user_city" id="user_city" data-placeholder="Select a state" required="required">
                <option selected value="<?php echo get_field('master_location', $acf_key, true); ?>"><?php echo get_term(get_field('master_location', $acf_key), 'location')->name; ?></option>
            </select>
        </div>

        <div class="form-group">
            <label for="user_website" class="form-label"><?php _e( 'Сайт', 'common' ); ?></label>
            <input type="text" name="user_website" id="user_website" class="form-control" value="<?php echo get_field('master_website', $acf_key); ?>" />
        </div>

        <div class="form-group">
            <label for="categories" class="form-label"><?php _e( 'Основные категории', 'common' ); ?> <span class="required">*</span></label>

            <?php $master_catalog = get_field('master_catalog', $acf_key); ?>
            <select id="categories" name="user_catalog_master[]" multiple="multiple" class="form-control" style="width: 100%;" data-placeholder="<?php _e( 'Выбирете категории', 'common' ); ?>" lang="<?php echo pll_current_language(); ?>" required="required">
                <?php foreach(pror_get_catalog() as $main_catalog): ?>
                    <optgroup label="<?php echo $main_catalog->name; ?>">
                        <?php foreach (pror_get_catalog($main_catalog->term_id) as $index => $sub_catalog): ?>
                            <option value="<?php echo $sub_catalog->term_id; ?>"<?php if(in_array($sub_catalog->term_id, $master_catalog)): ?> selected="selected"<?php endif; ?>>
                                <?php echo $sub_catalog->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </div>

        <hr class="mb-4 mt-4" />

        <h3 class="mb-3"><label for="user_description" class="form-label"><?php _e( 'Описание', 'common' ); ?> <span class="required">*</span></h3>

        <div class="form-group">
            <?php wp_editor(get_field('master_text', $acf_key), 'user_description', [
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

        <h3 class="mb-3"><label class="form-label"><?php _e( 'Галерея', 'common' ); ?></label></h3>

        <div class="image-container">
            <div id="files" class="files">
                <?php foreach (get_field('master_gallery', $acf_key, false) as $image_id): ?>
                    <?php list($url,) = wp_get_attachment_image_src($image_id, 'pror-medium'); ?>

                    <div class="image-col" data-image-id="<?php echo $image_id; ?>">
                        <input type="hidden" name="user_images[]" value="<?php echo $image_id; ?>">
                        <div class="image-wrapper">
                            <button type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <img src="<?php echo $url; ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="clearfix"></div>
            <div class="text-right">
                <span class="btn btn-pror-primary upload-gallery fileinput-button">
                    <span><?php _e('Добавить файл', 'common'); ?></span>
                    <input id="fileupload" type="file" name="files" multiple>
                </span>
            </div>
        </div>

        <hr class="mb-4 mt-4" />


        <button type="submit" class="btn btn-pror-primary"><?php _e( 'Обновить', 'common' ); ?></button>
    </form>

    <a href="<?php echo wp_logout_url(); ?>" class="logout-url">Выйти</a>
</div>
