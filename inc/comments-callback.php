<?php
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @package TA Magazine
 */

if ( !function_exists('ta_magazine_comment') ) :
function ta_magazine_comment($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment;
	switch ($comment -> comment_type) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<p><?php _e('Pingback:', 'ta-magazine'); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __('Edit', 'ta-magazine'), '<span class="ping-meta"><span class="edit-link">', '</span></span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
	?>
	<li id="li-comment-<?php comment_ID(); ?>" class="media media-comment">          
		<div class="media-heading">
			<figure>
				<?php echo get_avatar($comment, 70); ?>
			</figure>
			<p class="author-name"><?php comment_author_link(); ?></p>
		</div><!-- .comment-author -->
   
		<div class="media-body">
			<div class="comment-text arrow">
				<div class="comment-date">
				<?php
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'ta-magazine' ), get_comment_date(), get_comment_time() )
					);
				?>
				</div><!-- .comment-date -->

				<?php if ('0' == $comment->comment_approved) : ?>
					<p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'ta-magazine'); ?></p>
				<?php endif; ?>

				<?php comment_text(); ?>
				<?php comment_reply_link( array_merge($args, array( 'reply_text' => __('Reply', 'ta-magazine') . '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
		</div><!-- .comment-details -->
	</li>
	<?php
		break;
	endswitch; // End comment_type check.
}
endif;