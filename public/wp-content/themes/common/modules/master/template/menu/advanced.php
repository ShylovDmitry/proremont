<ul class="navbar-nav ml-5 profile-menu">
<?php if (!is_user_logged_in()): ?>
    <li class="navbar-nav-item"><a class="nav-link" href="<?php echo esc_url(wp_login_url(get_edit_user_link())); ?>">Войти</a></li>
    <li class="navbar-nav-item"><a class="nav-link" href="<?php echo esc_url(wp_registration_url()); ?>">Зарегестрироваться</a></li>
<?php else: ?>
    <li class="navbar-nav-item"><a class="nav-link" href="<?php echo get_edit_user_link(); ?>">Профиль</a></li>
    <li class="navbar-nav-item"><a class="nav-link" href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Выйти</a></li>
<?php endif; ?>
</ul>
