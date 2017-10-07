<?php
    $instance = array(
        'enabled' => 2,
        'displaystyle' => 'grey',
        'displaytotalratings' => 1,
        'filtercomments' => 1,
        'displaybreakdown' => 1,
        'cssClass' => 'rating-breakdown',
    );
    if ( function_exists( 'display_average_rating' ) ) {
        display_average_rating( $instance );
    }
?>
