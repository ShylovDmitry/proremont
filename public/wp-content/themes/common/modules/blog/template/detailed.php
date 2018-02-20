<article>
    <?php
    $cache_expire = pror_cache_expire(0);
    $cache_key = pror_cache_key();
    $cache_group = 'pror:blog:post:id-' . get_the_ID();

    $cache = wp_cache_get($cache_key, $cache_group);
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
        <div class="post-date header-underlined mb-3"><?php echo get_the_date(); ?></div>

        <div class="mb-3 d-lg-none">
            <?php module_template('banner/mobile1'); ?>
        </div>


        <div class="post-content">
            <?php the_content(); ?>
        </div>

        <div class="post-catalogs">
            <?php the_terms(get_the_ID(), 'catalog_master'); ?>
        </div>
    </div>

    <?php
    wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
    endif;
    ?>

    <div class="colored-box mt-3 p-3">
        <h4 class="header-underlined">Коментарии</h4>
        <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        ?>
    </div>
</article>
