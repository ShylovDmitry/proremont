<div class="tender-item"
     onclick="javascript:window.open('<?php echo esc_url( get_permalink() ); ?>', '_blank');">
    <div class="tender-body">
        <h4 class="mt-0 mb-1">
            <a class="title" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(get_the_title()); ?>" target="_blank"><?php the_title(); ?></a>
        </h4>
        <div class="subtitle">
            <span class="location"><?php echo pror_get_section_localized_name(get_field('section')); ?></span>
            <div>Бюджет: <?php echo pror_tender_get_budgets()[get_field('budget')]; ?></div>
        </div>

        <div class="catalog"><?php module_template('catalog_master/small-list'); ?></div>
    </div>
    <div class="clearfix"></div>
</div>
