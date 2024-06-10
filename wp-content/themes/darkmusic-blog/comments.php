<?php
/**
 * The template for displaying comments.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#comments
 *
 * @package WordPress
 * 
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can add a custom title here for your comments section.
	// Example: <h2 class="comments-title">Leave a Comment</h2>
	comment_form_title();
	?>

	<?php if ( have_comments() ) : ?>
		<div class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'div',
					'short_ping' => true,
				)
			);
			?>
		</div><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="comment-navigation" role="navigation">
				<div class="comment-nav-prev"><?php previous_comments_link( __( '&larr; Older Comments', 'darkmusic-blog' ) ); ?></div>
				<div class="comment-nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'darkmusic-blog' ) ); ?></div>
			</nav><!-- .comment-navigation -->
		<?php endif; ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	comment_form(
		array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
		)
	);
	?>

</div><!-- #comments -->


