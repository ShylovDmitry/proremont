<?php if (!is_user_logged_in()): ?>
    <?php _e( 'Вы не зарегистрированы. Войти', 'common' ); ?>
<?php else: ?>

<div class="row">
    <div class="col-3">
        <?php module_template('profile/master/menu'); ?>
    </div>
    <div class="col-9">
        <div class="colored-box p-3">
            <?php if ($_GET['section'] == 'saved'): ?>
                <?php module_template('profile/master/saved'); ?>
            <?php elseif ($_GET['section'] == 'history'): ?>
                <?php module_template('profile/master/history'); ?>
            <?php else: ?>
                <?php module_template('profile/master/settings'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php endif; ?>
