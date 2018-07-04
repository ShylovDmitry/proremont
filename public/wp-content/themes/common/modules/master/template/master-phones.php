<?php $master_phones = pror_get_master_phones(get_the_author_meta('ID')); ?>
<?php $master_phones_count = count($master_phones)-1; ?>

<span class="master-phones">
    <span class="stub">
        <?php foreach ($master_phones as $pos => $phone): ?>
            <?php echo sprintf('%s xxx xxxx', substr($phone['text'], 0, 5)); ?><?php if ($pos != $master_phones_count): ?><span class="delimiter">,</span><?php endif; ?>
        <?php endforeach; ?>
        <a href="#" class="show-number"><?php _e('Показать', 'common'); ?></a>
    </span>
    <span class="phones d-none">
        <?php foreach ($master_phones as $pos => $phone): ?>
            <a href="tel:<?php echo $phone['tel']; ?>"><?php echo $phone['text']; ?></a><?php if ($pos != $master_phones_count): ?><span class="delimiter">,</span><?php endif; ?>
        <?php endforeach; ?>
    </span>
</span>
