<?php if (have_posts()): the_post(); ?>
<div class="tender-detailed">
    <?php
        $is_user_master = pror_user_has_role('administrator master');
    ?>

    <?php
    $cache_expire = pror_cache_expire(0);
    $cache_key = pror_cache_key();
    $cache_group = 'pror:tender:post:id-' . get_the_ID();

    $cache = wp_cache_get($cache_key, $cache_group);
    if ($cache):
        echo $cache;
    else:
        ob_start();
        ?>

        <div class="colored-box p-3 main-content">
            <div class="header">
                <div class="tender-body">
                    <h1 class="mt-0 mb-1"><?php the_title(); ?></h1>

                    <div class="subtitle">
                        <span class="location"><?php echo pror_get_section_localized_name(get_field('section')); ?></span>
                        <div>Бюджет: <?php echo pror_tender_get_budgets()[get_field('budget')]; ?></div>
                    </div>

                    <div class="catalog"><?php module_template('catalog_master/small-list'); ?></div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="line"></div>
            <div class="contacts">
                <h5><?php _e('Контактная информация', 'common'); ?></h5>

                <?php if ($is_user_master): ?>
                    <?php
                        $customer_id = get_field('customer');
                        $customer = get_userdata($customer_id);
                    ?>
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
                <form action="" id="create-tender-response">
                    <input type="hidden" name="tender_id" value="<?php the_ID(); ?>" />
                    <textarea name="comment" class="tender-response-comment"></textarea>

                    <input type="radio" name="comment_visibility" value="all" checked="checked" /> Все
                    <input type="radio" name="comment_visibility" value="client_only" /> Только клиент


                    <button class="btn btn-pror-primary mt-3"><?php _e('Откликнуться на заявку', 'common'); ?></button>
                </form>
            <?php endif; ?>
        </div>
        <?php
        wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
    endif;
    ?>
</div>
<?php endif; ?>

<div class="colored-box p-3 mt-3">
    <?php $query = pror_tender_query_tender_responses(get_the_ID()); ?>
	<?php if ($query->have_posts()): ?>
        Заинтересованих исполнителей: <?php echo pror_tender_query_tender_responses(get_the_ID())->post_count; ?>
        <div class="master-2columns">
            <div class="row">
		        <?php while ($query->have_posts()): $query->the_post(); ?>
                    <div class="col-12">
                        <?php
                            $author_id = get_field('author', get_the_ID());
                            $comment = get_field('comment', get_the_ID());

                            if ('client_only' == get_field('comment_visibility', get_the_ID())) {
                                if (get_current_user_id() == $author_id) {
                                    $comment .= sprintf('<i>%s</i>', __('(Только вы и клиент можете видеть этот коментарий)', 'common'));
                                } else {
                                    $comment = sprintf('<i>%s</i>', __('Исполнитель предпочел скрыть свой комментарий.', 'common'));
                                }

                            }
                        ?>
				        <?php module_template('master/item', [
				                'id' => $author_id,
                                'excerpt' => $comment,
                        ]); ?>
                    </div>
		        <?php endwhile; ?>
            </div>
        </div>

    <?php endif; ?>
</div>
