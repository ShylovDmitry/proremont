<?php
$menu = [
    'settings' => [
        'name' => __('Настройки', 'common'),
        'icon' => 'person',
        'template' => 'profile/subscriber/settings',
    ],
];
?>

<div class="profile-account">
    <?php if (!is_user_logged_in()): ?>
        <?php _e( 'Нет доступа. Необходимо <a href="%s">войти</a> на сайт.', 'common' ); ?>
    <?php else: ?>
        <div class="row">
            <div class="col-3">
                <?php module_template('profile/menu', ['menu' => $menu]); ?>
            </div>
            <div class="col-9">
                <div class="colored-box p-3">
                    <?php $menu_item = isset($menu[$_GET['section']]) ? $menu[$_GET['section']] : reset($menu); ?>
                    <?php module_template($menu_item['template']); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
