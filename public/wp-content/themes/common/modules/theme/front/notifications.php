<?php

function pror_theme_send_notification($title, $message) {
	@wp_mail(get_option('admin_email'), $title, $message);
}


add_action('comment_post', function($comment_ID, $comment_approved, $commentdata) {
	$post_url = get_permalink($commentdata['comment_post_ID']);

	pror_theme_send_notification(
		"Новий коментар #{$comment_ID}",
		<<< EOF
{$post_url}

Автор #{$commentdata['user_ID']}: {$commentdata['comment_author']} - {$commentdata['comment_author_email']}

{$commentdata['comment_content']}
EOF
	);
}, 20, 3);

add_action('pror_tender_created', function($tender_ID) {
	$tender = get_post($tender_ID);
	$tender_url = get_permalink($tender_ID);
	$author = get_userdata($tender->post_author);
	$title = pror_tender_get_title($tender_ID);
	$description = get_field('description', $tender_ID, false);

	pror_theme_send_notification(
		"Новий тендер #{$tender_ID}",
		<<< EOF
{$tender_url}

Автор #{$author->ID}: {$author->first_name} {$author->last_name} - {$author->user_email}

{$title} 

{$description}
EOF
	);
}, 20, 3);

add_action('pror_tender_response_created', function($tender_response_ID) {
	$tender_id = get_field('tender', $tender_response_ID);
	$tender_url = get_permalink($tender_id);
	$author_post = get_field('author', $tender_response_ID);
	$author = get_userdata($author_post->post_author);
	$title = pror_tender_get_title($tender_id);
	$comment = get_field('comment', $tender_response_ID, false);

	pror_theme_send_notification(
		"Нова відповідь #{$tender_response_ID} на тендер #{$tender_id}",
		<<< EOF
{$tender_url}

Автор #{$author->ID}: {$author->first_name} {$author->last_name} - {$author->user_email}

{$title}

{$comment}
EOF
	);
}, 20, 3);
