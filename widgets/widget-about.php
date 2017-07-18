<?php
/**
 * About Widget Class
 *
 * @package TA Magazine
 */

class ta_magazine_about_widget extends WP_Widget {
	/* Constructor method */
	function ta_magazine_about_widget() {
        $widget_ops = array( 'description' => __( "Extended text widget for About information." , 'ta-magazine' ) );
        $this->WP_Widget( 'ta_magazine_about_widget', __( 'TA Magazine: About Widget', 'ta-magazine' ), $widget_ops );
    }

	public function widget($args, $instance) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$title = str_replace( '[', '<', $title );
		$title = str_replace( '[/', '</', $title );
		$title = str_replace( ']', '>', $title );
		echo $args['before_widget'];
		if ( !empty($title) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
			<p><?php echo $text; ?></p>
		<?php
		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		return $instance;
	}

	public function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = $instance['title'];
		$text = esc_textarea($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ta-magazine'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		<?php _e('You can use [span][/span] tag to add color to your text.', 'ta-magazine'); ?></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
<?php
	}
}