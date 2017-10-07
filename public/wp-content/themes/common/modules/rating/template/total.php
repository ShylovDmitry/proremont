<?php
    $instance = array(
        'enabled' => 2,
        'displaystyle' => 'grey',
        'displayaverage' => 1,
        'displaytotalratings' => 1,
        'filtercomments' => 1,
        'totalratingsbefore' => '<a href="' . get_permalink() . '#comments"><span>Отзывы (</span>',
        'totalratingsafter' => '<span>)</span></a>',
        'cssClass' => 'rating-total',
    );
    if ( function_exists( 'display_average_rating' ) ) {
        display_average_rating( $instance );
    }
?>
