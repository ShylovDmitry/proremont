<?php $phones = isset($__data['phones']) ? (array) $__data['phones'] : []; ?>
<?php
    $phones = array_map(function($value) { return pror_format_phones($value); }, $phones);
?>

<div class="contact-info">
    <?php if (is_user_logged_in()): ?>
        <dl class="row">
            <dt class="col-sm-3">Телефон</dt>
            <dd class="col-sm-9">
                <span class="stub">
                    <?php echo implode(', ', array_map(function($value) { return $value['hidden']; }, $phones)); ?>
                    <a href="#" class="show-contact-info"><?php _e('Показать', 'common'); ?></a>
                </span>
                <ul class="contact-info-list list-unstyled mb-0 d-none">
                    <?php foreach ($phones as $pos => $phone): ?>
                        <li><a href="tel:<?php echo $phone['tel']; ?>"><?php echo $phone['text']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </dd>
        </dl>
    <?php else: ?>
        <div class="pror-alert-info alert alert-info">
            <?php printf(__('Что бы просматривать контактную информацию, необходимо <a href="%s">зарегистрироваться на сайте</a>.', 'common'),
                pror_get_permalink_by_slug('login') . '?redirect_to=' . urlencode(home_url($_SERVER['REQUEST_URI'])) ); ?>
        </div>
    <?php endif; ?>
</div>
