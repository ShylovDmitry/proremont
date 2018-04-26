<ul class="profile-menu list-unstyled">
<?php if (is_user_logged_in() && pror_user_has_role('master')): ?>
    <li><a href="<?php echo get_edit_user_link(); ?>">Профиль</a></li>
    <li><a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Выйти</a></li>
<?php else: ?>
    <li><a href="<?php echo esc_url(wp_login_url(get_edit_user_link())); ?>">Войти</a></li>
    <li><a href="<?php echo esc_url(wp_registration_url()); ?>">Зарегистрироваться</a></li>
<?php endif; ?>
</ul>
