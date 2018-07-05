<?php if (is_user_logged_in() && pror_user_has_role('master')): ?>
<ul class="navbar-nav ml-5 profile-menu">
    <li class="navbar-nav-item"><a class="nav-link" href="<?php echo get_edit_user_link(); ?>"><?php _e('Профиль', 'common'); ?></a></li>
    <li class="navbar-nav-item"><a class="nav-link" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php _e('Выйти', 'common'); ?></a></li>
</ul>
<?php endif; ?>
