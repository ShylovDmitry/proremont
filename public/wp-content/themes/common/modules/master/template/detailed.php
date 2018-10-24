<?php if (have_posts()): the_post(); ?>
    <div class="master-detailed<?php if (get_field('master_is_pro', "user_" . get_the_author_meta('ID'))): ?> pro<?php endif; ?>">

        <?php
        $cache_expire = pror_cache_expire(0);
        $cache_key = pror_cache_key();
        $cache_group = 'pror:master:post:id-' . get_the_ID();

        $cache = wp_cache_get($cache_key, $cache_group);
        if ($cache):
            echo $cache;
        else:
        ob_start();
        ?>

        <div class="colored-box p-3 main-content">
            <div class="header">
                <?php if (has_post_thumbnail()): ?>
                    <div class="thumbnail">
                        <div class="avatar">
                            <?php the_post_thumbnail('pror-medium', array(
                                    'alt' => pror_get_master_img_alt(),
                                    'pror_no_scrset' => true,
                            )); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="master-body">
                    <h1 class="mt-0 mb-1">
                        <?php the_title(); ?>
                        <?php if (get_field('master_is_confirmed', "user_" . get_the_author_meta('ID'))): ?>
                            <span class="oi oi-circle-check is-confirmed" data-toggle="tooltip" data-placement="top" title="<?php _e('Проверено', 'common'); ?>"></span>
                        <?php endif; ?>
                    </h1>

                    <div class="subtitle">
                        <span class="type">
                            <?php if (get_field('master_is_pro', "user_" . get_the_author_meta('ID'))): ?><span class="pro-label">PRO</span><?php endif; ?>
                            <?php _e(get_field('master_type', "user_" . get_the_author_meta('ID')), 'common'); ?>,
                        </span>
                        <span class="location"><?php echo pror_get_section_name(pror_get_master_section()); ?></span>
                    </div>

                    <div class="rating d-none d-sm-block">
                        <?php module_template('rating/total-inline'); ?>
                    </div>

                    <div class="catalog"><?php module_template('catalog_master/small-list'); ?></div>

                    <div class="phone"><?php module_template('master/master-phones'); ?></div>
<!--                    <div class="report mt-2 text-right"><a href="#" data-toggle="modal" data-target="#reportModal">--><?php //_e('Пожаловаться', 'common'); ?><!--</a></div>-->
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="line"></div>

            <div class="content">
                <?php if(get_the_content()): ?>
                    <?php the_content(); ?>
                <?php elseif(get_the_excerpt()): ?>
                    <?php the_excerpt(); ?>
                <?php else: ?>
                    <i><?php _e('Нет информации.', 'common'); ?></i>
                <?php endif; ?>
            </div>

            <?php
            $images = get_field('master_gallery', "user_" . get_the_author_meta('ID'));
            if ($images): ?>
                <div class="line"></div>
                <div class="gallery">
                    <h4><?php _e('Галерея', 'common'); ?></h4>

                    <div class="gallery-wrapper">
                        <div class="gallery-carousel">
                            <?php foreach ($images as $image): ?>
                                <div class="slick-slide">
                                    <a href="<?php echo wp_get_attachment_image_url($image['ID'], 'full'); ?>">
                                        <?php echo wp_get_attachment_image( $image['ID'], 'pror-medium', '', array('height' => 20)); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="d-lg-none mt-3">
            <?php module_template('prom/mobile1'); ?>
        </div>
    </div>
    <?php
    wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
    endif;
    ?>
<?php endif; ?>

    <div class="colored-box mt-3 p-3">
        <div class="content">
            <h4 class="header-underlined"><?php _e('Отзывы', 'common'); ?></h4>
            <?php comments_template(); ?>
        </div>
    </div>

    <div class="colored-box mt-3 p-3">
        <div class="content">
            <?php
            $catalog_ids = [];
            foreach (pror_get_master_catalogs() as $parent) {
                foreach ($parent->children as $child) {
                    $catalog_ids[] = $child->term_id;
                }
            }
            ?>
            <?php module_template('master/related-list', ['exclude_master_id' => get_the_ID(), 'catalog_ids' => $catalog_ids, 'display_mobile' => 0]); ?>
        </div>
    </div>




<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reportModalLabel"><?php _e('Пожаловаться на исполнителя', 'common'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <?php if (pll_current_language() == 'uk'): ?>
              <?php echo do_shortcode('[contact-form-7 id="35316" title="Пожалітись UK"]'); ?>
          <?php else: ?>
              <?php echo do_shortcode('[contact-form-7 id="34139" title="Пожаловаться"]'); ?>
          <?php endif; ?>
      </div>
    </div>
  </div>
</div>
