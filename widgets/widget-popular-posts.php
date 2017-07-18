<?php
/**
 * Popular Posts Class
 *
 * @package TA Magazine
 */

class ta_magazine_popular_posts_widget extends WP_Widget {

	function ta_magazine_popular_posts_widget() {
        $widget_ops = array( 'classname' => 'popular-posts', 'description' => __("Popular posts widget for Jetpack.", 'ta-magazine') );
        $this->WP_Widget( 'ta_magazine_popular_posts_widget', __('TA Magazine: Popular Posts Widget', 'ta-magazine'), $widget_ops );
		$this->alt_option_name = 'ta_magazine_popular_posts_widget';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get('ta_magazine_popular_posts_widget', 'widget');
		}

		if ( !is_array($cache )) {
			$cache = array();
		}

		if ( !isset($args['widget_id']) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset($cache[ $args['widget_id'] ]) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( !empty( $instance['title'] ) ) ? $instance['title'] : __( 'Popular Posts', 'ta-magazine' );

		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$number = ( !empty( $instance['number']) ) ? absint( $instance['number'] ) : 2;
		if (!$number)
			$number = 2;

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<ul class="post-list">
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
			} ?>
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
						<?php if ( !post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
							<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
						<?php endif; ?>
					</p>
					<h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
				</header>
			</article>
		</li>
		<?php endwhile;
		} ?>
		</ul>
		<?php echo $args['after_widget']; ?>

<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		if ( !$this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'ta_magazine_popular_posts_widget', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['ta_magazine_popular_posts_widget']) )
			delete_option('ta_magazine_popular_posts_widget');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('ta_magazine_popular_posts_widget', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr($instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint($instance['number'] ) : 2;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ta-magazine'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'ta-magazine'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}