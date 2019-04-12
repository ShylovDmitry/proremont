<?php if (have_posts()): the_post(); ?>
<div class="tender-detailed<?php if (pror_tender_is_expired()): ?> expired<?php endif; ?>">
    <?php
        $is_user_master = pror_user_has_role('administrator master');
        $customer_id = get_field('customer');
    ?>

    <?php
    $cache_obj = pror_cache_obj(0, '', 'pror:tender:post', get_the_ID());
    $cache = pror_cache_get($cache_obj);
    if ($cache):
        echo $cache;
    else:
        ob_start();
    ?>

        <div class="colored-box p-3 main-content">
            <div class="header">
                <div class="tender-body">
                    <h1 class="mt-0 mb-1"><?php echo pror_tender_get_title(); ?></h1>

                    <div class="catalog"><?php module_template('catalog_master/small-list'); ?></div>

	                <?php module_template('tender/time'); ?>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="line"></div>
            <div class="contacts">
                <h5><?php _e('Контактная информация', 'common'); ?></h5>

                <?php if ($is_user_master): ?>
                    <?php $customer = get_userdata($customer_id); ?>
                    <?php if ($customer->first_name): ?>
                        <div class="customer-name"><?php echo $customer->first_name; ?></div>
                    <?php endif; ?>
                    <?php module_template('contact-info/contacts', ['phones' => get_field('contact_phone', "user_{$customer_id}")]); ?>
                <?php else: ?>
                    <div class="pror-alert-info alert alert-info">
                        <?php printf(__('Что бы просматривать контактную информацию, необходимо <a href="%s">войти как исполнитель</a>.', 'common'),
                            pror_get_permalink_by_slug('login') . '?redirect_to=' . urlencode(home_url($_SERVER['REQUEST_URI'])) ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="line"></div>
            <div class="content">
                <h5><?php _e('Описание', 'common'); ?></h5>

                <?php if(get_field('description')): ?>
                    <?php the_field('description'); ?>
                <?php else: ?>
                    <i><?php _e('Нет информации.', 'common'); ?></i>
                <?php endif; ?>
            </div>

            <?php if ($is_user_master && !pror_tender_is_tender_assigned_to_user(get_the_ID())): ?>
                <div class="text-right">
                    <a href="#" class="btn btn-pror-primary mt-3" data-toggle="modal" data-target="#createTenderResponseModal"><?php _e('Откликнуться на заявку', 'common'); ?></a>
                </div>
            <?php endif; ?>
        </div>
    <?php
    pror_cache_set($cache_obj, ob_get_flush());
    endif;
    ?>
</div>

<div class="colored-box p-3 mt-3">
    Заинтересованих исполнителей: <?php echo pror_tender_query_tender_responses(get_the_ID())->post_count; ?>

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

	<?php if ($is_user_master && !pror_tender_is_tender_assigned_to_user(get_the_ID())): ?>
        <div class="text-center">
            <a href="#" class="btn btn-pror-primary mt-2" data-toggle="modal" data-target="#createTenderResponseModal"><?php _e('Откликнуться на заявку', 'common'); ?></a>
        </div>
	<?php endif; ?>

</div>


<?php module_template('tender/add-modal', ['tender_id' => get_the_ID()]); ?>

<?php endif; ?>
