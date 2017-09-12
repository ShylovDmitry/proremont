<?php get_header(); ?>

<?php get_template_part('breadcrumb'); ?>

<div class="container colored-box py-3">
    <div class="row">
        <div class="col">

            <?php if (have_posts()): the_post(); ?>
            <div class="media">
                <img class="d-flex mr-3" src="http://via.placeholder.com/200" alt="" width="200" />
                <div class="media-body">
                    <h3 class="mt-0 mb-1"><?php the_field('master_type'); ?> - <?php the_title(); ?></h3>

                    <br />
                    <p><?php the_terms(null, 'location'); ?></p>
                    <p>Досвід 10 років.</p>
                    <p>Телефон: <a href="#"><?php the_field('master_tel'); ?></a></p>
                </div>
            </div>

            <hr />

            <div class="clearfix mb-5">
                <?php the_content(); ?>
            </div>

            <div class="clearfix mb-5">
                <?php
                $images = get_field('master_gallery');

                if( $images ): ?>
                    <div class="master-gallery-wrapper">
                    <div class="master-gallery">
                        <?php foreach( $images as $image ): ?>
                            <div>
                                <a href="<?php echo wp_get_attachment_image_url($image['ID'], 'full'); ?>">
                                    <?php echo wp_get_attachment_image( $image['ID'], 'pror-medium', '', array('height' => 20)); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php
                if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
            ?>

            <?php endif; ?>
        </div>

        <?php get_sidebar('banner-right'); ?>
    </div>
</div>

<?php get_footer(); ?>
