<?php
$cache_expire = pror_cache_expire(0);
$cache_key = pror_cache_key();
$cache_group = 'pror:theme:header';

$cache = wp_cache_get($cache_key, $cache_group);
if ($cache):
    echo $cache;
else:
ob_start();
?>

<header id="header">
    <div class="container">
        <div class="header-inner">
            <a class="logo" href="<?php echo home_url('/'); ?>">
                <img src="<?php module_img('theme/logo-proremont.png'); ?>" height="40px" alt="ProRemont logo" />
            </a>

            <div class="right">
                <div class="master-link">
                    <a href="#">Виконавцю &rsaquo;</a>
                </div>

                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo home_url('mastera'); ?>">Знайти виконавця</a>
                    </li>
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link" href="#">Розмістити заявку</a>-->
<!--                    </li>-->
                    <li class="nav-item">
                        <?php if (is_user_logged_in()): ?>
                            <a class="nav-link" href="<?php echo home_url('profile'); ?>">Шилов Дмитро</a>
                        <?php else: ?>
                            <a class="btn btn-pror-primary" href="<?php echo home_url('login'); ?>">Войти</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<?php
wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
endif;
?>

