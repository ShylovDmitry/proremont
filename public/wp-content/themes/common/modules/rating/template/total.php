<?php
    global $post;

    $total = get_post_meta($post->ID, 'crfp-total-ratings', true);
    $totals = get_post_meta($post->ID, 'crfp-totals', true);
    $score = round(array_sum($totals) / ($total * count($totals)), 1);
?>
<div class="rating-total">
    <div class="pror-score">
        <?php echo sprintf("%.1f", $score); ?>
    </div>
    <?php
        $instance = array(
            'enabled' => 2,
            'displaystyle' => 'grey',
            'displayaverage' => 1,
            'displaytotalratings' => 1,
            'filtercomments' => 1,
            'totalratingsbefore' => sprintf(__('<a href="%s#comments"><span>Отзывы (</span>', 'common'), get_permalink()),
            'totalratingsafter' => '<span>)</span></a>',
        );
        if ( function_exists( 'display_average_rating' ) ) {
            display_average_rating( $instance );
        }
    ?>
</div>
