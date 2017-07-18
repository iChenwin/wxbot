<?php
/**
 * @package TA Magazine
 */
?>

<?php if ( ta_option('disable_listing_style') == '1' ) { echo '<div class="masonry-loop">'; } ?>	
	<article id="post-<?php the_ID(); ?>" <?php post_class( array('post-type-1', 'clearfix') ); ?>>
		<div class="post-thumbnail-3">
			<?php if ( has_post_thumbnail() ) : ?>
			<div class="tag-style-2">
				<?php
				$categories_list = get_the_category_list(' / ');
				$category = get_the_category();
				$tag = $category[0]->cat_ID;
				$tag_extra_fields = get_option(add_category_icon);
				if ( isset($tag_extra_fields[$tag]) ) {
					$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
				}
				?>
				<p><?php printf($categories_list); ?></p><?php if(!empty($category_icon_code)) { ?><i class="fa fa-<?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?>"></i><?php } ?>
				<?php $category_icon_code = ""; ?>
			</div>

			<figure>
				<?php if (ta_option('disable_listing_style') == '1') {
					$thumb_size = 'feature-lg';
				} else {
					$thumb_size = 'feature-md';
				} ?>

				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail( $thumb_size, array('class' => "img-responsive") ); ?>
				</a>
			</figure>
			<?php endif; ?>

			<?php if (ta_option('disable_listing_style') == '0') { echo '</div>'; } ?>

			<?php if (ta_option('disable_listing_style') == '0') : ?>
			<div class="meta-tags">
				<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
				<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
				<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
					<?php jp_get_post_views( get_the_ID() ); ?>
				<?php endif; ?>
				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
					<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		
			<?php if (ta_option('disable_listing_style') == '1') : ?>
			<div class="meta-tags">
				<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
				<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
				<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
					<?php jp_get_post_views( get_the_ID() ); ?>
				<?php endif; ?>
				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
					<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
				<?php endif; ?>
			</div>
			<?php endif; ?>

		<?php if (ta_option('disable_listing_style') == '1') { echo '</div>'; } ?>

		<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
		<p>
		<?php if( has_excerpt() ) {
			the_excerpt();
		} elseif (ta_option('disable_listing_style') == '1') {
			$content = strip_shortcodes( get_the_content() );
			echo wp_trim_words( $content, 50 );
		} else {
			echo trim_characters( get_the_content() );
		} ?>
		</p>
		<a href="<?php echo get_permalink(); ?>" class="btn btn-default read-more"><p><?php echo ta_option('read_more_text', 'Read More'); ?></p></a>
	</article>
<?php if ( ta_option('disable_listing_style') == '1' ) { echo '</div>'; } ?>