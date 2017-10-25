<ul class="profile-menu">
<?php if (!is_user_logged_in()): ?>
    <li><a href="<?php echo get_page_by_path('informacia-dlya-mastrov'); ?>">Информация о размещении</a></li>
    <li><a href="<?php echo get_page_by_path('master-pro'); ?>">PRO аккаунт</a></li>
    <li><a href="<?php echo esc_url(wp_login_url(get_edit_user_link())); ?>">Войти</a></li>
    <li><a href="<?php echo esc_url(wp_registration_url()); ?>">Зарегестрироваться</a></li>
<?php else: ?>
    <li><a href="<?php echo get_page_by_path('informacia-dlya-mastrov'); ?>">Информация о размещении</a></li>
    <li><a href="<?php echo get_page_by_path('master-pro'); ?>">PRO аккаунт</a></li>
    <li><a href="<?php echo get_edit_user_link(); ?>">Профиль</a></li>
    <li><a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Выйти</a></li>
<?php endif; ?>
</ul>
