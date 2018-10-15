<?php $master_phones = pror_get_master_phones(get_the_author_meta('ID')); ?>
<?php $master_phones_count = count($master_phones)-1; ?>
<?php $redirect_to = home_url($_SERVER['REQUEST_URI']); ?>

<div class="master-phones-container">
    <div class="master-phones">
        <span class="oi oi-phone phone-icon"></span>

        <span class="stub">
            <?php foreach ($master_phones as $pos => $phone): ?>
                <?php echo sprintf('%s xxx xxxx', substr($phone['text'], 0, 5)); ?><?php if ($pos != $master_phones_count): ?><span class="delimiter">,</span><?php endif; ?>
            <?php endforeach; ?>
            <a href="#" class="show-number"><?php _e('Показать', 'common'); ?></a>
        </span>
        <span class="phones d-none">
            <?php if (is_user_logged_in()): ?>
                <?php foreach ($master_phones as $pos => $phone): ?>
                    <a href="tel:<?php echo $phone['tel']; ?>"><?php echo $phone['text']; ?></a><?php if ($pos != $master_phones_count): ?><span class="delimiter">,</span><?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </span>
    </div>

    <?php if (!is_user_logged_in()): ?>
        <div class="registration-required-message alert alert-danger mt-3 d-none">Для просмотра телефона необходимо <a href="<?php echo pror_get_permalink_by_slug('login'); ?>?redirect_to=<?php echo urlencode($redirect_to); ?>">войти</a> или <a href="<?php echo pror_get_permalink_by_slug('register'); ?>; ?>">зарегестрироваться</a>.</div>
    <?php endif; ?>
</div>
