<article>
    <div class="post-image mb-3">
        <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
    </div>

    <h1 class="post-title"><?php the_title(); ?></h1>
    <div class="post-date header-underlined mb-3"><?php echo get_the_date(); ?></div>

    <div class="mb-3 d-lg-none">
        <?php module_template('banner/mobile'); ?>
    </div>


    <div class="post-content">
        <?php the_content(); ?>
    </div>

    <div class="post-catalogs">
        <?php the_terms(get_the_ID(), 'catalog_master'); ?>
    </div>

    <h4 class="header-underlined mt-4">Коментарии</h4>
    <?php
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    ?>
</article>
