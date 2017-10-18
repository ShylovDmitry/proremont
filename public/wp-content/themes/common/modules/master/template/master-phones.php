<?php $master_phones = pror_format_phones(get_field('master_phones')); ?>
<?php $master_phones_count = count($master_phones)-1; ?>

<span class="master-phones">
    <span class="stub">
        <?php foreach ($master_phones as $pos => $phone): ?>
            <?php echo sprintf('%sx xxx xxxx', substr($phone['text'], 0, 2)); ?><?php if ($pos != $master_phones_count): ?>, <?php endif; ?>
        <?php endforeach; ?>
        <a href="#" class="show-number">Показать</a>
    </span>
    <span class="phones d-none">
        <?php foreach ($master_phones as $pos => $phone): ?>
            <a href="tel:<?php echo $phone['tel']; ?>"><?php echo $phone['text']; ?></a><?php if ($pos != $master_phones_count): ?>, <?php endif; ?>
        <?php endforeach; ?>
    </span>
</span>
