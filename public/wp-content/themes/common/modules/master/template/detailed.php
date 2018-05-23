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
            <div class="left">
                <div class="avatar">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('pror-medium', array(
                                'alt' => pror_get_master_img_alt(),
                                'pror_no_scrset' => true,
                        )); ?>
                    <?php else: ?>
                        <img src="<?php module_img('master/no-avatar.png'); ?>" />
                    <?php endif; ?>
                </div>

                <div class="rating">
                    <?php module_template('rating/total'); ?>
                </div>
            </div>

            <div class="media-body">
                <h1 class="mt-0 mb-1">
                    <?php the_title(); ?>
                    <?php if (get_field('master_is_confirmed', "user_" . get_the_author_meta('ID'))): ?>
                        <span class="oi oi-circle-check is-confirmed" data-toggle="tooltip" data-placement="top" title="Проверено"></span>
                    <?php endif; ?>
                </h1>

                <div class="type">
                    <?php if (get_field('master_is_pro', "user_" . get_the_author_meta('ID'))): ?><span class="pro-label">PRO</span><?php endif; ?>
                    <?php the_field('master_type', "user_" . get_the_author_meta('ID')); ?>
                </div>
                <div class="location"><?php echo end(pror_get_master_location()); ?></div>
                <br />
                <div class="phone">Телефон:
                    <?php module_template('master/master-phones'); ?>
                </div>
                <div class="report mt-2 text-right"><a href="#" data-toggle="modal" data-target="#reportModal">Пожаловаться</a>
                </div>
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
                <i>Нет информации.</i>
            <?php endif; ?>
        </div>

        <div class="d-lg-none mt-2">
            <?php module_template('prom/mobile1'); ?>
        </div>
    </div>

    <div class="colored-box mt-3 p-3">
        <div class="rating">
            <h4 class="header-underlined">Оценки</h4>
            <?php module_template('rating/breakdown'); ?>
            <div class="clearfix"></div>
        </div>
    </div>

    <?php
    $images = get_field('master_gallery', "user_" . get_the_author_meta('ID'));
    if ($images): ?>
        <div class="colored-box mt-3 p-3">
            <div class="gallery">
                <h4 class="header-underlined">Галерея</h4>

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
        </div>
    <?php endif; ?>

    <div class="colored-box mt-3 pt-3 px-3">
        <div class="catalog-block">
            <h4 class="header-underlined">Услуги</h4>

            <div class="row">
                <?php foreach (pror_get_master_catalogs() as $pos => $parent): ?>
                    <div class="col-md-6 mb-3">
                        <div class="catalog-title">
                            <a href="<?php echo esc_url( get_term_link($parent) ); ?>" title="<?php echo esc_attr($parent->name); ?>">
                                <span class="icon"><?php module_svg("catalog_master/{$parent->slug}.svg"); ?></span>
                                <span class="link"><span><?php echo $parent->name; ?></span> <?php echo pror_catalog_get_count($parent); ?></span>
                            </a>
                        </div>

                        <ul class="list-unstyled catalog-subs">
                        <?php foreach ($parent->children as $child): ?>
                            <li><a href="<?php echo esc_url( get_term_link($child) ); ?>" title="<?php echo esc_attr($child->name); ?>"><span><?php echo $child->name; ?></span> <?php echo pror_catalog_get_count($child); ?></a></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php if (($pos+1) % 2 == 0): ?><div class="w-100 d-none d-md-block"></div><?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php
    wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
    endif;
    ?>

    <div class="colored-box mt-3 p-3">
        <div class="content">
            <h4 class="header-underlined">Отзывы</h4>
            <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
            ?>
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
            <?php module_template('master/related-list', ['exclude_master_id' => get_the_ID(), 'catalog_ids' => $catalog_ids]); ?>
        </div>
    </div>
</div>
<?php endif; ?>




<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reportModalLabel">Пожаловаться на исполнителя</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo do_shortcode('[contact-form-7 id="34139" title="Пожаловаться"]'); ?>
      </div>
    </div>
  </div>
</div>
