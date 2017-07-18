<?php
/**
 * Social Network Icon Widget Class
 *
 * @package TA Magazine
 */
 
class ta_magazine_social_widget extends WP_Widget {
	/* Constructor method */
	function ta_magazine_social_widget() {
        $widget_ops = array( 'classname' => 'social-widget', 'description' => __("Add social icons to your sidebar." , 'ta-magazine') );
        $this->WP_Widget( 'ta_magazine_social_widget', __('TA Magazine: Social Widget', 'ta-magazine'), $widget_ops );
    }

	/* Render this widget in the sidebar */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo $after_title;
		?>

		<!-- We are in social nets -->
		<div class="row">
			<div class="col-md-12">
				<ul class="social-icons">
					<?php $social_options = ta_option('social_icons'); ?>
					<?php foreach ($social_options as $key => $value) {
						if ($value && $key == 'Google Plus') { ?>
					<li>
						<a href="<?php echo $value; ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $key; ?>"><i class="fa fa-<?php echo strtolower( strtr($key, " ", "-") ); ?>"></i></a>
					</li>
					<?php } elseif ($value) { ?>
					<li>
						<a href="<?php echo $value; ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $key; ?>"><i class="fa fa-<?php echo strtolower($key); ?>"></i></a>
					</li>
					<?php }
				} ?>
				</ul>
			</div>
		</div>

		<?php echo $after_widget;
	}

	/* Update the widget settings */
	function update ($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	/* Output user options */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array('title' => '') );
		$title = $instance['title'];
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title','ta-portfolio') ?></label>
		<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>

		<?php
	}

} // end ta_magazine_social_widget

?>