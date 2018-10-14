<?php if (have_posts()): the_post(); ?>
<div class="partner-detailed">

    <?php
    $cache_expire = pror_cache_expire(0);
    $cache_key = pror_cache_key();
    $cache_group = 'pror:partner:post:id-' . get_the_ID();

    $cache = wp_cache_get($cache_key, $cache_group);
    if ($cache):
        echo $cache;
    else:
    ob_start();
    ?>

    <div class="colored-box p-3 main-content">
        <div class="header">
            <div class="left">
                <div class="avatar">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium', array(
                                'alt' => pror_get_master_img_alt(),
                                'pror_no_scrset' => true,
                        )); ?>
                    <?php else: ?>
                        <img src="<?php module_img('master/no-avatar.png'); ?>" />
                    <?php endif; ?>
                </div>
            </div>

            <div class="media-body">
                <h1 class="mt-0 mb-1 header-underlined"><?php the_title(); ?></h1>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="d-lg-none mt-2">
            <?php module_template('prom/mobile1'); ?>
        </div>

        <div class="post-content mt-3">
            <?php if(get_the_content()): ?>
                <?php the_content(); ?>
            <?php elseif(get_the_excerpt()): ?>
                <?php the_excerpt(); ?>
            <?php else: ?>
                <i><?php _e('Нет информации.', 'common'); ?></i>
            <?php endif; ?>
        </div>

        <div class="post-catalogs">
            <?php the_terms(get_the_ID(), 'catalog_master'); ?>
        </div>

        <div class="post-sharing">
            <?php echo do_shortcode('[oa_social_sharing_icons]'); ?>
        </div>
    </div>

    <?php
    wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
    endif;
    ?>
</div>
<?php endif; ?>
