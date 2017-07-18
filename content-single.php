<?php
/**
 * @package TA Magazine
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content hr-bold">
		<!-- Post format begin -->
		<?php 
		if( get_post_format() ) {
			get_template_part('inc/post-formats');
		} elseif ( has_post_thumbnail() && ( ta_option('disable_featured_img') == '1' ) ) { ?>
			<figure>
				<?php the_post_thumbnail( 'full', array('class' => "img-responsive") ); ?>
			</figure>
		<?php } ?>
		<!-- Post format end -->

		<!-- Post begin -->
		<?php the_title( '<h2>', '</h2>' ); ?>

		<?php if ( ta_option('ad_post_top') != '' ) { ?>
		<!-- Post header advertise -->
		<figure class="adv-post-header">
			<?php echo ta_option('ad_post_top'); ?>
		</figure>
		<?php } ?>

		<?php the_content(); ?>

		<?php if ( ta_option('ad_post_bottom') != '' ) { ?>
		<!-- Post header advertise -->
		<figure class="adv-post-bottom">
			<?php echo ta_option('ad_post_bottom'); ?>
		</figure>
		<?php } ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'ta-magazine' ),
			'after'  => '</div>',
		) );
		?>
		<!-- Post end -->
	</div>

	<?php if ( ta_option('disable_post_nav') == '1' ) { ?>
	<div class="hr-bold">
		<?php ta_magazine_post_nav(); ?>
	</div>
	<?php } ?>

	<!-- Related posts begin (owl-carousel) -->
	<?php if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) { ?>

	<?php
	$related = Jetpack_RelatedPosts::init_raw()
		-> set_query_name( 'get-related-posts' )
		-> get_for_post_id (
			get_the_ID(),
			array( 'size' => 6 )
		);
	?>

	<?php if ($related) { ?>
	<div class="hr-bold">
		<h2><?php if ( ta_option('related_title') != '' ) { echo ta_option('related_title'); } ?></h2>
		<div id="owl-related" class="owl-carousel owl-theme">
			<?php foreach ( $related as $result ) {	?>
			<div class="item">
				<article class="post-type-1">
					<div class="post-thumbnail-3">
						<div class="tag-style-2">
							<?php
							$categories_list = get_the_category_list(' / ', '', $result['id'] );
							$category = get_the_category($result['id']);
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
							<?php 
							if ( has_post_thumbnail($result['id']) ) : ?>
								<a href="<?php echo get_permalink($result['id']); ?>" title="<?php echo get_the_title($result['id']); ?>">
								<?php echo get_the_post_thumbnail( $result['id'], 'related', array('class' => 'img-responsive') ); ?>
							</a>
							<?php endif; ?>
						</figure>
						<div class="meta-tags">
							<span><i class="fa fa-clock-o"></i><?php echo get_the_date('m.d.Y', $result['id']); ?></span>
							<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
							<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
								<?php jp_get_post_views($result['id']); ?>
							<?php endif; ?>
							<?php $num_comments = get_comments_number($result['id']); // get_comments_number returns only a numeric value ?>
							<?php if ( comments_open() ) {
								if ( $num_comments == 0 ) {
									$comments = 0;
								} elseif ( $num_comments > 1 ) {
									$comments = $num_comments;
								} else {
									$comments = 1;
								}
								$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
							} else {
								$write_comments =  __('Comments are off for this post.');
							} ?>
							<span><i class="fa fa-comments"></i><?php echo $write_comments; ?></span>
						</div>
					</div>
					<h3><a href="<?php echo get_permalink($result['id']); ?>" title="<?php echo get_the_title($result['id']); ?>"><?php echo get_the_title($result['id']); ?></a></h3>
				</article>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
	<!-- Related posts end -->
	<?php } ?>
</article><!-- #post-## -->