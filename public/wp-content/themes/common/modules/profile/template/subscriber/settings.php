<div class="profile-settings">
    <?php module_template('profile/errors', ['param_key' => 'errors']) ?>

    <?php if ( $_REQUEST['success'] ) : ?>
        <div class="alert alert-success" role="alert">
            <?php _e('Данные успешно обновлены.', 'common'); ?>
        </div>
    <?php endif; ?>


    <?php $userdata = get_userdata(get_current_user_id()); ?>
    <form action="" method="post" class="form-container from-validation-simple">
        <input type="hidden" name="profile_update_type" value="subscriber" />

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

        <button type="submit" class="btn btn-pror-primary"><?php _e( 'Обновить', 'common' ); ?></button>
    </form>

    <a href="<?php echo wp_logout_url(); ?>" class="logout-url">Выйти</a>
</div>
