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
	if ( have_comments() ) : ?>
		<ul class="list-unstyled comment-list">
			<?php
				wp_list_comments( array(
//                    'reverse_top_level' => true,
					'avatar_size' => 0,
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

	endif;

	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php _e( 'Коментарии закрыты.', 'common' ); ?></p>
	<?php
	endif;
	?>

    <?php
    wp_cache_add($cache_key, ob_get_flush(), $cache_group, $cache_expire);
    endif;
    ?>

    <div id="leaveReview">
        <?php
        global $wp;
        $logged_user = wp_get_current_user();

        $title_text = (get_post_type() == 'post') ? __('Оставить коментарий', 'common') : __('Оставить отзыв', 'common');

        comment_form(array(
            'logged_in_as' => '<div class="logged-in-as">' . sprintf('<strong>%1$s</strong> <i>(%2$s)</i>',
                                  $user_identity,
                                  sprintf(__('Если это не вы, нажмите <a href="%s">выйти</a>', 'common'),
                                        wp_logout_url( home_url(trailingslashit($wp->request)) )
                                  )
                              ) . '</div>',
            'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea><span id="comment-error" class="comment-error text-danger"></span></p>',
            'title_reply' => $title_text,
            'label_submit' => $title_text,
        ));
        ?>
    </div>

</div><!-- #comments -->
