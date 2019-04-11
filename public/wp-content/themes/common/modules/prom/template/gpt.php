<?php
    $dfp_current_page = pror_get_current_page_identifier();
    $dfp_current_section = pror_detect_section()->slug;
    $dfp_current_catalog = pror_prom_get_catalog();
?>
<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
</script>
<script>
    function ProrDefineSlot(adUnitPath, size, opt_div) {
        return googletag.defineSlot(adUnitPath, size, opt_div)
            .setTargeting('page', '<?php echo $dfp_current_page; ?>')
            .setTargeting('section', '<?php echo $dfp_current_section; ?>')
            .setTargeting('master_catalog', <?php echo json_encode($dfp_current_catalog); ?>)
            .addService(googletag.pubads());
    }

    googletag.cmd.push(function() {
        ProrDefineSlot('/21681373772/sidebar1', [300, 600], 'div-sidebar1');
//        ProrDefineSlot('/21681373772/sidebar2', [300, 600], 'div-sidebar2');

        ProrDefineSlot('/21681373772/mobile1', [300, 250], 'div-mobile1');
//        ProrDefineSlot('/21681373772/mobile2', [300, 250], 'div-mobile2');

        ProrDefineSlot('/21681373772/native1', ['fluid'], 'div-native1').setCollapseEmptyDiv(true, true);

        googletag.pubads().enableAsyncRendering();
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });
</script>
