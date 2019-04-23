<?php
$menu = [
    'settings' => [
        'name' => __('Настройки', 'common'),
        'icon' => 'person',
        'template' => 'profile/master/settings',
    ],
	'tenders' => [
		'name' => __('Мои тендеры', 'common'),
		'icon' => 'wrench',
		'template' => 'tender/profile-list',
	],
	'tender_responses' => [
		'name' => __('Ответы на тендеры', 'common'),
		'icon' => 'task',
		'template' => 'tender/profile-responses-list',
	],
    'pro' => [
        'name' => __('PRO-аккаунт', 'common'),
        'icon' => 'dollar',
        'link' => pror_get_permalink_by_slug('pro-akkaunt-dlya-masterov'),
    ],
];
?>

<div class="profile-account">
    <?php if (!is_user_logged_in()): ?>
	    <?php printf( __( 'Нет доступа. Необходимо <a href="%s">войти</a> на сайт.', 'common' ), wp_login_url()); ?>
    <?php else: ?>
        <div class="row">
            <div class="col-3">
                <?php module_template('profile/menu', ['menu' => $menu]); ?>
            </div>
            <div class="col-9">
                <div class="colored-box p-3">
                    <?php if (!get_field('master_is_confirmed', "user_" . get_current_user_id())): ?>
                        <div class="mb-3">
                            <div class="alert alert-danger" role="alert">
                                <strong><?php _e('Внимание!', 'common'); ?></strong><br />
                                <?php _e('Ваш аккаунт не подтверджен. Чтобы подтвердить аккаунт, позвоните нашому менеджеру <nobr>(063) 199 63 04</nobr>.', 'common'); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php $menu_item = isset($menu[$_GET['section']]) ? $menu[$_GET['section']] : reset($menu); ?>
                    <?php module_template($menu_item['template']); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
