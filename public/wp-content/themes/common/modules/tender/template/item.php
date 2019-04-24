<div class="tender-item<?php if (pror_tender_is_expired()): ?> expired<?php endif; ?>"
     onclick="javascript:location.href='<?php echo esc_url( get_permalink() ); ?>';">
    <div class="tender-body">
        <h4 class="mt-0 mb-1">
            <a class="title" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr(pror_tender_get_title()); ?>"><?php echo pror_tender_get_title(); ?></a>
        </h4>
        <div class="catalog"><?php module_template('catalog_master/small-list'); ?></div>

	    <?php module_template('tender/time'); ?>
    </div>
    <div class="clearfix"></div>
</div>
