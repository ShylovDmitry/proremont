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

	comment_form(array(
//	    'must_log_in' => '<p class="must-log-in">Только авторизированый пользователь может оставить коментарий.</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf(
		                              /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
		                              __( 'Авторизирован как <strong>%1$s</strong>. <a href="%2$s">Выйти?</a>' ),
		                              $user_identity,
		                              wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )
		                          ) . '</p>',
        'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => 'Коментировать',
    ));
	?>

</div><!-- #comments -->
