<?php
$is_user_master = pror_user_has_role('administrator master');
$customer_id = get_field('customer');
?>

<div class="colored-box p-3 mt-3">
    <div class="row">
        <div class="col-12 mb-1">
            <h4 class="header-underlined"><?php printf(__('Ответы (%s)', 'common'), pror_tender_query_tender_responses(get_the_ID())->post_count); ?></h4>
        </div>
    </div>

	<?php $query = pror_tender_query_tender_responses(get_the_ID()); ?>
	<?php if ($query->have_posts()): ?>
        <div class="master-2columns">
            <div class="row">
				<?php while ($query->have_posts()): $query->the_post(); ?>
                    <div class="col-12">
						<?php
						$author_id = get_field('author', get_the_ID());
						$comment = get_field('comment', get_the_ID());

						if ('client_only' == get_field('comment_visibility', get_the_ID())) {
							if ($author_id == get_current_user_id()) {
								$comment .= sprintf('<i>%s</i>', __('(Только вы и клиент можете видеть этот коментарий)', 'common'));
							} else if ($customer_id != get_current_user_id()) {
								$comment = sprintf('<i>%s</i>', __('Исполнитель предпочел скрыть свой комментарий.', 'common'));
							}

						}
						?>
						<?php module_template('master/item', [
							'id' => $author_id,
							'datetime' => get_the_date('U'),
							'excerpt' => $comment,
						]); ?>
                    </div>
				<?php endwhile; ?>
            </div>
        </div>
	<?php endif; ?>

	<?php if ($is_user_master && !pror_tender_is_tender_assigned_to_user(get_the_ID()) && !pror_tender_is_expired()): ?>
        <div class="text-center">
            <a href="#" class="btn btn-pror-primary mt-2" data-toggle="modal" data-target="#createTenderResponseModal"><?php _e('Ответить на заявку', 'common'); ?></a>
        </div>
	<?php else: ?>
        <div class="pror-alert-info alert alert-info">
			<?php printf(__('Что бы ответить на заявку, необходимо <a href="%s">зарегистрироваться на сайте как мастер</a>.', 'common'),
				pror_get_permalink_by_slug('login') . '?redirect_to=' . urlencode(home_url($_SERVER['REQUEST_URI'])) ); ?>
        </div>
	<?php endif; ?>
</div>