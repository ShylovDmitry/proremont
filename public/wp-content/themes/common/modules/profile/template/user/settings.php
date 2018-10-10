<div class="profile-settings">
    <?php module_template('profile/errors', ['param_key' => 'errors']) ?>

    <?php if ( $_REQUEST['success'] ) : ?>
        <div class="alert alert-success" role="alert">
            <?php _e('Данные успешно обновлены.', 'common'); ?>
        </div>
    <?php endif; ?>


    <?php $userdata = get_userdata(get_current_user_id()); ?>
    <form action="" method="post" class="form-container">
        <input type="hidden" name="profile_update_type" value="user" />

        <div class="form-group">
            <label for="first_name" class="form-label"><?php _e( 'Имя', 'common' ); ?></label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $userdata->first_name; ?>" />
        </div>

        <div class="form-group">
            <label for="last_name" class="form-label"><?php _e( 'Фамилия', 'common' ); ?></label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $userdata->last_name; ?>" />
        </div>

        <button type="submit" class="btn btn-pror-primary"><?php _e( 'Обновить', 'common' ); ?></button>
    </form>
</div>
