<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

    <?php
    $cache_expire = pror_cache_expire(0);
    $cache_key = pror_cache_key();
    $cache_group = 'pror:comments:post:id-' . get_the_ID();

    $cache = wp_cache_get($cache_key, $cache_group);
    if ($cache):
        echo $cache;
    else:
    ob_start();
    ?>

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<ul class="list-unstyled comment-list">
			<?php
				wp_list_comments( array(
					'avatar_size' => 100,
					'style' => 'ul',
                    'type' => 'comment',
					'short_ping' => true,
				) );
			?>
		</ul>

		<?php the_comments_pagination( array(
			'prev_text' => 'Previous',
			'next_text' => 'Next',
		) );

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyseventeen' ); ?></p>
	<?php
	endif;
	?>

    <?php
    wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
    endif;
    ?>

    <a class="leave-review-button" data-toggle="collapse" href="#leaveReview" role="button" aria-expanded="false" aria-controls="leaveReview">Написать новый отзыв <span class="oi oi-pencil"></span></a>
    <div class="collapse" id="leaveReview">
        <?php
        $logged_user = wp_get_current_user();
        comment_form(array(
            'logged_in_as' => '<div class="logged-in-as">' . sprintf(
                                  '%1$s<strong>%2$s</strong><p><i>Если это не вы, нажмите <a href="%3$s">выйти</a>.</i></p>',
                                  get_avatar($logged_user ? $logged_user->ID : null),
                                  $user_identity,
                                  wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )
                              ) . '</div>',
            'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea><span id="comment-error" class="comment-error text-danger"></span></p>',
            'title_reply' => 'Оставить отзыв',
            'label_submit' => 'Оставить отзыв',
        ));
        ?>
    </div>

</div><!-- #comments -->
