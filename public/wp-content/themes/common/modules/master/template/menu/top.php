<?php if (is_user_logged_in()): ?>
<ul class="navbar-nav ml-5 profile-menu">
    <li class="navbar-nav-item"><a class="nav-link" href="<?php echo get_edit_user_link(); ?>">Профиль</a></li>
    <li class="navbar-nav-item"><a class="nav-link" href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Выйти</a></li>
</ul>
<?php endif; ?>
