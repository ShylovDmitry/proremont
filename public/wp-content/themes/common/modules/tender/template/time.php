<div class="row tender-datetime">
    <div class="col-md-6"><span><?php _e('Создано', 'common'); ?></span>
		<?php
		printf( _x( '%1$s назад', '%2$s = human-readable time difference', 'common' ), human_time_diff(
			get_the_time( 'U' ),
			current_time( 'timestamp' )
		));
		?>
    </div>
    <div class="col-md-6 text-md-right">
		<?php if (pror_tender_is_expired()): ?>
			<?php _e('Выполнено', 'common'); ?>
		<?php else: ?>
            <span><?php _e('Окончание', 'common'); ?></span>
            <?php printf(_x('через %1$s', '%2$s = human-readable time difference', 'common'), human_time_diff(
				get_field('expires_date'),
				current_time('timestamp')
			)); ?>
		<?php endif; ?>
    </div>
</div>
