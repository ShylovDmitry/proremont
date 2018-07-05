<ul class="profile-menu list-unstyled">
<?php if (is_user_logged_in() && pror_user_has_role('master')): ?>
    <li><a href="<?php echo get_edit_user_link(); ?>"><?php _e('Профиль', 'common'); ?></a></li>
    <li><a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php _e('Выйти', 'common'); ?></a></li>
<?php else: ?>
    <li><a href="<?php echo esc_url(wp_login_url(get_edit_user_link())); ?>"><?php _e('Войти', 'common'); ?></a></li>
    <li><a href="<?php echo esc_url(wp_registration_url()); ?>"><?php _e('Зарегистрироваться', 'common'); ?></a></li>
<?php endif; ?>
</ul>
