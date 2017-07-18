<?php
/**
 * Slide Show Class
 *
 * @package TA Magazine
 */
 
class ta_magazine_slide_show_widget extends WP_Widget {

	function ta_magazine_slide_show_widget() {
        $widget_ops = array( 'classname' => 'slide-show', 'description' => __("Add Slide Show Widget to your sidebar.", 'ta-magazine') );
        $this->WP_Widget( 'ta_magazine_slide_show_widget', __('TA Magazine: Slide Show', 'ta-magazine'), $widget_ops );
	}

	public function widget($args, $instance) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __('Slide Show', 'ta-magazine') : $instance['title'], $instance, $this->id_base );
		$output = $before_widget."\n";
		if($title)
			$output .= $before_title.$title.$after_title;
		ob_start();
	
?>

	<?php
	$posts = new WP_Query( array(
		'post_type'				=> array('post'),
		'showposts'				=> $instance['posts_num'],
		'cat'					=> $instance['posts_cat_id'],
		'ignore_sticky_posts'	=> true,
		'orderby'				=> $instance['posts_orderby'],
		'order'					=> 'dsc',
		'date_query' => array(
			array(
				'after' => $instance['posts_time'],
			),
		),
	) );
	?>
		
	<div id="footer-slider" class="carousel slide" data-ride="carousel">
		<!-- Carousel item -->
		<div class="carousel-inner">
			<?php
			$i = 1;
			while ($posts->have_posts()): $posts->the_post();
			?>
			<div class="item <?php if ($i == 1) { echo 'active'; } ?>">
				<div class="post-thumbnail-1">
					<div class="tag-style-1">
						<?php
						$categories_list = get_the_category_list(' / ');
						$category = get_the_category();
						$tag = $category[0]->cat_ID;
						$tag_extra_fields = get_option(add_category_icon);
						if ( isset($tag_extra_fields[$tag]) ) {
							$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
						}
						?>
						<p><?php printf($categories_list); ?></p><?php if(!empty($category_icon_code)) {?><i class="fa fa-<?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?>"></i><?php } ?>
						<?php $category_icon_code = ""; ?>
					</div>
					<figure>
						<?php 
						if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'slide-show', array('class' => "img-responsive") ); ?>
						</a>
						<?php endif; ?>
					</figure>
					<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
					<p class="meta-tags">
						<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
						<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
						<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
							<?php jp_get_post_views( get_the_ID() ); ?>
						<?php endif; ?>
						<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
							<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
						<?php endif; ?>
					</p>
				</div>
			</div>
			<?php
			$i++;
			endwhile;
			?>
		</div>
		<!-- Carousel nav -->
		<a class="carousel-control left" href="#footer-slider" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#footer-slider" data-slide="next">&rsaquo;</a>
	</div>

	<?php
	$output .= ob_get_clean();
	$output .= $after_widget."\n";
	echo $output;
	}
	
	public function update($new,$old) {
		$instance = $old;
		$instance['title'] = strip_tags($new['title']);
		$instance['posts_num'] = strip_tags($new['posts_num']);
		$instance['posts_cat_id'] = strip_tags($new['posts_cat_id']);
		$instance['posts_orderby'] = strip_tags($new['posts_orderby']);
		$instance['posts_time'] = strip_tags($new['posts_time']);
		return $instance;
	}

	public function form($instance) {
		$defaults = array(
			'title' 			=> '',
			'posts_num' 		=> '5',
			'posts_cat_id' 		=> '0',
			'posts_orderby' 	=> 'date',
			'posts_time' 		=> '0',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id("posts_num"); ?>"><?php _e('Number of posts to show:', 'ta-magazine'); ?></label>
		<input id="<?php echo $this->get_field_id("posts_num"); ?>" name="<?php echo $this->get_field_name("posts_num"); ?>" type="text" value="<?php echo absint($instance["posts_num"]); ?>" size='3' />
	</p>
	<p>
		<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_cat_id"); ?>"><?php _e('Category:', 'ta-magazine'); ?></label>
		<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("posts_cat_id"), 'selected' => $instance["posts_cat_id"], 'show_count' => true ) ); ?>		
	</p>
	<p">
		<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_orderby"); ?>"><?php _e('Order by:', 'ta-magazine'); ?></label>
		<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_orderby"); ?>" name="<?php echo $this->get_field_name("posts_orderby"); ?>">
		  <option value="date"<?php selected( $instance["posts_orderby"], "date" ); ?>><?php _e('Most Recent', 'ta-magazine'); ?></option>
		  <option value="comment_count"<?php selected( $instance["posts_orderby"], "comment_count" ); ?>><?php _e('Most Commented', 'ta-magazine'); ?></option>
		  <option value="rand"<?php selected( $instance["posts_orderby"], "rand" ); ?>><?php _e('Random', 'ta-magazine'); ?></option>
		</select>	
	</p>
	<p>
		<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_time"); ?>"><?php _e('Posts from:', 'ta-magazine'); ?></label>
		<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_time"); ?>" name="<?php echo $this->get_field_name("posts_time"); ?>">
		  <option value="0"<?php selected( $instance["posts_time"], "0" ); ?>><?php _e('All Time', 'ta-magazine'); ?></option>
		  <option value="1 year ago"<?php selected( $instance["posts_time"], "1 year ago" ); ?>><?php _e('This Year', 'ta-magazine'); ?></option>
		  <option value="1 month ago"<?php selected( $instance["posts_time"], "1 month ago" ); ?>><?php _e('This Month', 'ta-magazine'); ?></option>
		  <option value="1 week ago"<?php selected( $instance["posts_time"], "1 week ago" ); ?>><?php _e('This Week', 'ta-magazine'); ?></option>
		  <option value="1 day ago"<?php selected( $instance["posts_time"], "1 day ago" ); ?>><?php _e('Past 24 Hours', 'ta-magazine'); ?></option>
		</select>	
	</p>

<?php

	}

}