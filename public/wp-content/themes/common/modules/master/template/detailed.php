<?php if (have_posts()): the_post(); ?>
<div class="master-detailed<?php if (get_field('master_is_pro')): ?> pro<?php endif; ?>">
    <div class="header">
        <div class="left">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('pror-medium', array( 'class' => 'd-flex mr-3' )); ?>
            <?php else: ?>
                <img src="http://via.placeholder.com/100" class="d-flex mr-3" />
            <?php endif; ?>

            <div class="rating">
                <?php module_template('rating/total'); ?>
            </div>
        </div>

        <div class="media-body">
            <h1 class="mt-0 mb-1">
                <?php the_title(); ?>
                <?php if (get_field('master_is_confirmed')): ?>
                    <span class="oi oi-circle-check is-confirmed"></span>
                <?php endif; ?>
            </h1>

            <div class="type"><?php the_field('master_type'); ?></div>
            <br />
            <div class="location"><?php echo pror_get_master_location(); ?></div>
            <br />
            <div class="phone">Телефон:
                <?php $master_phones = pror_format_phones(get_field('master_phones')); ?>
                <?php $master_phones_count = count($master_phones)-1; ?>
                <?php foreach ($master_phones as $pos => $phone): ?>
                    <a href="tel:<?php echo $phone['tel']; ?>"><?php echo $phone['text']; ?></a><?php if ($pos != $master_phones_count): ?>, <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="content">
        <h4>О мастере</h4>
        <?php the_content(); ?>
    </div>

    <div class="catalog">
        <h4>Услуги</h4>

        <div class="row">
            <?php foreach (pror_get_master_catalogs() as $pos => $parent): ?>
                <div class="col-6">
                    <div class="catalog-title">
                        <span class="circle"><?php module_svg("catalog_master/{$parent->slug}.svg"); ?></span>
                        <span class="link"><a href="<?php echo esc_url( get_term_link($parent) ); ?>"><?php echo $parent->name; ?></a></span>
                    </div>

                    <ul class="list-unstyled">
                    <?php foreach ($parent->children as $child): ?>
                        <li><a href="<?php echo esc_url( get_term_link($child) ); ?>"><?php echo $child->name; ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
                <?php if (($pos+1) % 2 == 0): ?><div class="w-100"></div><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    $images = get_field('master_gallery');
    if ($images): ?>
        <div class="gallery">
            <h4>Галерея</h4>

            <div class="gallery-wrapper">
                <div class="gallery-carousel">
                    <?php foreach ($images as $image): ?>
                        <div>
                            <a href="<?php echo wp_get_attachment_image_url($image['ID'], 'full'); ?>">
                                <?php echo wp_get_attachment_image( $image['ID'], 'pror-medium', '', array('height' => 20)); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="rating">
        <h4>Оценки</h4>
        <?php module_template('rating/breakdown'); ?>
        <div class="clearfix"></div>
    </div>

    <div class="content">
        <h4>Отзывы</h4>
    <?php
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    ?>
    </div>
</div>
<?php endif; ?>
