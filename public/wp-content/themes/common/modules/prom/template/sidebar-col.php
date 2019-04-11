<div class="col col-prom-sidebar d-none d-lg-block">
<!--    --><?php //if (pror_detect_section()->slug == 'lvov'): ?>
<!--        <div class="prom-card colored-box p-3 mb-3">-->
<!--            <h4 class="text-center">--><?php //_e('Экономьте на ремонте!', 'common'); ?><!--</h4>-->
<!--            <p class="text-center"><img src="--><?php //module_img('theme/logo-proremont-dark.png'); ?><!--" height="16" alt="ProRemont logo" /> --><?php //_e('знает как', 'common'); ?><!--.</p>-->
<!--            <a href="--><?php //echo pror_get_permalink_by_slug('family-order'); ?><!--" class="btn btn-block">--><?php //_e('Сэкономить <strong>до $3,000</strong>', 'common'); ?><!--</a>-->
<!--        </div>-->
<!--    --><?php //endif; ?>



    <div id="prom_sidebar">

        <div id="div-sidebar1-wrapper">
            <!-- /21681373772/sidebar1 -->
            <div id='div-sidebar1' class="prom-placeholder" style='height:600px; width:300px;'>
                <script>
                    googletag.cmd.push(function() { googletag.display('div-sidebar1'); });
                </script>
            </div>
            <div class="prom-placeholder-blocked" style="display:none;">
                <img src="<?php module_img('prom/nonad-3600.png'); ?>" alt="" width="300" height="600" />
            </div>
            <a href="<?php echo pror_get_permalink_by_slug('reklama'); ?>" class="reklama-link"><?php _e('Реклама на ProRemont.co', 'common'); ?></a>
        </div>

        <!-- /21681373772/sidebar2 -->
<!--        <div id='div-sidebar2' style='height:600px; width:300px;'>-->
<!--            <script>-->
<!--                googletag.cmd.push(function() { googletag.display('div-sidebar2'); });-->
<!--            </script>-->
<!--        </div>-->

    </div>
</div>
