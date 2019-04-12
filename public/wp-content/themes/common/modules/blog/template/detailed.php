<article class="main-article">
    <?php
    $cache_obj = pror_cache_obj(0, '', 'pror:blog:post', get_the_ID());
    $cache = pror_cache_get($cache_obj);
    if ($cache):
        echo $cache;
    else:
    ob_start();
    ?>

    <div class="colored-box px-3 pb-3">
        <?php if (has_post_thumbnail()): ?>
            <div class="post-image">
                <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
            </div>
        <?php endif; ?>

        <h1 class="post-title pt-3"><?php the_title(); ?></h1>
        <div class="header-underlined mb-3">
            <div class="post-date"><?php echo get_the_date(); ?></div>
            <div class="post-categories"><?php module_template('blog/categories'); ?></div>
        </div>

        <div class="mb-3 d-lg-none">
            <?php module_template('prom/mobile1'); ?>
        </div>


        <div class="post-content">
            <?php the_content(); ?>
        </div>

        <div class="post-catalogs">
            <?php module_template('blog/catalog_master'); ?>
        </div>

        <div class="post-sharing">
            <?php echo do_shortcode('[oa_social_sharing_icons]'); ?>
        </div>
    </div>

    <?php
    pror_cache_set($cache_obj, ob_get_flush());
    endif;
    ?>

    <div class="colored-box mt-3 p-3">
        <h4 class="header-underlined"><?php _e('Комментарии', 'common'); ?></h4>
        <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        ?>
    </div>
</article>
