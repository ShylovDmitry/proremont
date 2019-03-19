<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key(null, 'user_id');
$cache_group = 'pror:theme:header';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo home_url('/'); ?>">
            <img src="<?php module_img('theme/logo-proremont.png'); ?>" height="40px" alt="ProRemont logo" />
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form class="form-inline my-2 my-lg-0 ml-5 mr-auto d-none d-md-block"></form>

            <ul class="navbar-nav">
                <?php if (is_user_logged_in()): ?>
                    <?php
                        $current_user = wp_get_current_user();
                        $name = "{$current_user->first_name} {$current_user->last_name}";
                        if (!trim($name)) {
                            $name = __('Профиль', 'common');
                        }
                    ?>
                    <li class="nav-item"><a href="<?php echo pror_get_permalink_by_slug('profile'); ?>" class="nav-link username"><?php echo $name; ?></a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="<?php echo pror_get_permalink_by_slug('login'); ?>" class="nav-link"><?php _e('Войти', 'common'); ?></a></li>
                <?php endif; ?>
                <li class="nav-item"><a href="<?php echo pror_get_permalink_by_slug('catalog'); ?>" class="nav-link find-master"><?php _e('Найти мастера', 'common'); ?></a></li>
                <li class="nav-item"><a href="<?php echo pror_get_permalink_by_slug('informacia-dlya-masterov'); ?>" class="nav-link iam-master"><?php _e('Стать исполнителем', 'common'); ?></a></li>
            </ul>
        </div>
    </div>
</nav>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>

