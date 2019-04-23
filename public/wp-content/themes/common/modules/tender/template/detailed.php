<?php if (have_posts()): the_post(); ?>
<?php
$is_user_master = pror_user_has_role('administrator master');
?>

<?php
$cache_obj = pror_cache_obj(0, '', 'pror:tender:post', get_the_ID(), $is_user_master);
$cache = pror_cache_get($cache_obj);
if ($cache):
    echo $cache;
else:
ob_start();
?>

    <div class="tender-detailed<?php if (pror_tender_is_expired()): ?> expired<?php endif; ?>">
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
                    <?php
	                    if (get_field('is_customer_registered')) {
		                    $customer_id = get_field('customer');
		                    $customer = get_userdata($customer_id);
		                    $customer_name = $customer->first_name ? $customer->first_name : '';
		                    $customer_phone = get_field('contact_phone', "user_{$customer_id}");
                        } else {
		                    $customer_name = get_field('customer_name');
		                    $customer_phone = get_field('customer_phone');
                        }
                    ?>
                    <?php if ($customer_name): ?>
                        <strong class="customer-name"><?php echo $customer_name; ?></strong>
                    <?php endif; ?>
                    <?php module_template('contact-info/contacts', ['phones' => $customer_phone]); ?>
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

	        <?php if ($is_user_master && !pror_tender_is_tender_assigned_to_user(get_the_ID()) && !pror_tender_is_expired()): ?>
                <div class="text-right">
                    <a href="#" class="btn btn-pror-primary mt-3" data-toggle="modal" data-target="#createTenderResponseModal"><?php _e('Ответить на тендер', 'common'); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
pror_cache_set($cache_obj, ob_get_flush());
endif;
?>

<?php module_template('tender/responses', ['tender_id' => get_the_ID()]); ?>
<?php module_template('tender/add-modal', ['tender_id' => get_the_ID()]); ?>

<?php endif; ?>
