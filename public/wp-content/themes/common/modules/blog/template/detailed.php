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

    <div class="post-image mb-3">
        <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
    </div>

    <h1 class="post-title"><?php the_title(); ?></h1>
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

    <?php
    wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
    endif;
    ?>

    <h4 class="header-underlined mt-4">Коментарии</h4>
    <?php
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    ?>
</article>
