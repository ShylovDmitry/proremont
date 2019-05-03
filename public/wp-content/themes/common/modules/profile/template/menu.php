<?php $menu = isset($__data['menu']) ? $__data['menu'] : []; ?>

<ul class="list-unstyled profile-menu">
    <?php foreach ($menu as $slug => $item): ?>
        <?php
            $link = $item['link'] ? $item['link'] : pror_get_permalink_by_slug('profile') . '?section=' . $slug;
            $class = (empty($_GET['section']) || $_GET['section'] == $slug) ? 'active' : '';
        ?>
        <li>
            <a href="<?php echo $link; ?>" class="<?php echo $class; ?>">
                <?php if ($item['icon']): ?><span class="oi oi-<?php echo $item['icon']; ?>"></span><?php endif; ?><?php echo $item['name']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php if (!pror_user_has_role('master')): ?>
    <p><a href="<?php echo pror_get_permalink_by_slug('register-master'); ?>"><?php _e('Стать исполнителем', 'common'); ?></a></p>
<?php endif; ?>

<a href="<?php echo wp_logout_url(); ?>" class="logout-url"><?php _e('Выйти', 'common'); ?></a>