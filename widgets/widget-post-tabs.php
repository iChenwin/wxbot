<?php
/**
 * Post Tabs Widget Class
 *
 * @package TA Magazine
 */

class ta_magazine_post_tabs_widget extends WP_Widget {
	/* Constructor method */
	function ta_magazine_post_tabs_widget() {
        $widget_ops = array( 'description' => __("Display popular posts and recent posts in tabbed format." , 'ta-magazine') );
        $this->WP_Widget( 'ta_magazine_post_tabs_widget', __('TA Magazine: Post Tabs Widget', 'ta-magazine'), $widget_ops );
		$this->alt_option_name = 'ta_magazine_post_tabs_widget';
    }

	/* Render this widget in the sidebar */
	function widget($args, $instance) {
		extract($args);
		/* Our variables from the widget settings. */
		$number = $instance['number'];
		echo '<div id="post-tabs" class="tabbed-widget">';
		?>

		<ul class="nav-tabs hr-bold" id="sidebar-tabs">
			<li class="active"><a href="#sidebar-tab1" data-toggle="tab"><i class="fa fa-star"></i></a></li>
			<li class=""><a href="#sidebar-tab2" data-toggle="tab"><i class="fa fa-clock-o"></i></a></li>
		</ul>

		<div class="tab-content">
			<div  class="tab-pane active" id="sidebar-tab1">
				<ul class="post-list list-tab">
				<?php if( function_exists('stats_get_csv') ) { // get popular posts by WordPress.com states if Jetpack plugin installed.
					$count = 0;
					$popular_posts = stats_get_csv( 'postviews', array( 'days' => 365, 'limit' => -1 ) ); ?>
					<?php foreach ( $popular_posts as $p ) {
					if ($count >= $number) {
						break;
					}

					if ( 'post' == get_post_type( $p['post_id'] ) && 'publish' == get_post_status ( $p['post_id'] ) && false == post_password_required ( $p['post_id'] ) && 0 != $p['post_id'] ) { ?>
					<li>
						<article class="post-type-2 clearfix">
							<figure>
								<a href="<?php echo $p['post_permalink']; ?>">
									<?php echo get_the_post_thumbnail( $p['post_id'], 'feature-sm', array('class' => 'img-responsive') ); ?>
									<div class="tag-style-3">
									<?php if ( 'gallery' == get_post_format($p['post_id']) ) { ?>
										<i class="fa fa-image"></i>
									<?php } elseif ( 'audio' == get_post_format($p['post_id']) ) { ?>
										<i class="fa fa-music"></i>
									<?php } elseif ( 'video' == get_post_format($p['post_id']) ) { ?>
										<i class="fa fa-video-camera"></i>
									<?php } else { ?>
										<i class="fa fa-plus"></i>
									<?php } ?>
									</div>
								</a>
							</figure>
							<header>
								<p class="meta-tags">
									<span><i class="fa fa-clock-o"></i><?php echo get_the_date('', $p['post_id']); ?></span>
									<span><i class="fa fa-eye"></i><?php echo $p['views']; ?></span>

									<?php $num_comments = get_comments_number($p['post_id']); // get_comments_number returns only a numeric value ?>
									<?php if ( comments_open($p['post_id']) ) {
										if ($num_comments == 0) {
											$comments = 0;
										} elseif ($num_comments > 1) {
											$comments = $num_comments;
										} else {
											$comments = 1;
										}
										$write_comments = '<a href="' . get_comments_link($p['post_id']) .'">'. $comments.'</a>';
									} else {
										$write_comments =  __('Comments are off for this post.', 'ta-magazine');
									} ?>
									<span><i class="fa fa-comments"></i><?php echo $write_comments; ?></span>
								</p>
								<h4><a href="<?php echo $p['post_permalink']; ?>" title="<?php echo $p['post_title']; ?>"><?php echo $p['post_title']; ?></a></h4>
							</header>
						</article>
					</li>
					<?php $count++; }
					wp_reset_query(); } ?>
				<?php }

				else { // get popular posts by comment count.
					$popular_posts = new WP_Query( array( 'showposts' => $number, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'has_password' => false, 'orderby' => 'comment_count', 'order'=> 'DESC', ) );
					while( $popular_posts->have_posts() ): $popular_posts->the_post(); ?>
					<li>
						<article class="post-type-2 clearfix">
							<figure>
								<a href="<?php echo get_permalink(); ?>">
									<?php the_post_thumbnail( 'feature-sm', array('class' => "img-responsive") ); ?>
									<div class="tag-style-3">
									<?php if ( 'gallery' == get_post_format() ) { ?>
										<i class="fa fa-image"></i>
									<?php } elseif ( 'audio' == get_post_format() ) { ?>
										<i class="fa fa-music"></i>
									<?php } elseif ( 'video' == get_post_format() ) { ?>
										<i class="fa fa-video-camera"></i>
									<?php } else { ?>
										<i class="fa fa-plus"></i>
									<?php } ?>
									</div>
								</a>
							</figure>
							<header>
								<p class="meta-tags">
									<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
									<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
										<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
									<?php endif; ?>
								</p>
								<h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
							</header>
						</article>
					</li>
					<?php endwhile;
					wp_reset_query();
				} ?>
				</ul>
			</div>

			<div  class="tab-pane" id="sidebar-tab2">
				<ul class="post-list list-tab">
				<?php $recent_posts = new WP_Query( array( 'showposts' => $number, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'has_password' => false ) ); ?>
				<?php while( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
					<li>
						<article class="post-type-2 clearfix">
							<figure>
								<a href="<?php echo get_permalink(); ?>">
									<?php the_post_thumbnail( 'feature-sm', array('class' => "img-responsive") ); ?>
									<div class="tag-style-3">
									<?php if ( 'gallery' == get_post_format() ) { ?>
										<i class="fa fa-image"></i>
									<?php } elseif ( 'audio' == get_post_format() ) { ?>
										<i class="fa fa-music"></i>
									<?php } elseif ( 'video' == get_post_format() ) { ?>
										<i class="fa fa-video-camera"></i>
									<?php } else { ?>
										<i class="fa fa-plus"></i>
									<?php } ?>
									</div>
								</a>
							</figure>
							<header>
								<p class="meta-tags">
									<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
									<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
										<?php jp_get_post_views( get_the_ID() ); ?>
									<?php endif; ?>
									<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
										<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
									<?php endif; ?>
								</p>
								<h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
							</header>
						</article>
					</li>
				<?php endwhile; ?>
				</ul>
			</div>
			<?php wp_reset_query(); ?>
		</div>

		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		if ( !$this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'ta_magazine_post_tabs_widget', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	/* Output user options */
	function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array( 'number' => 5 );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<!-- Number of posts -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show', 'ta-magazine') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="1" />
		</p>

	<?php }
	
	/* Update the widget settings */
	function update ($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;
	}

}// end ta_magazine_post_tabs_widget

?>