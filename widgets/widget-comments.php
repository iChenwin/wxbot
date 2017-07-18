<?php
/**
 * Latest Comments Class
 *
 * @package TA Magazine
 */

class ta_magazine_comments_widget extends WP_Widget {

	function ta_magazine_comments_widget() {
        $widget_ops = array( 'classname' => 'latest-comments', 'description' => __("Add Latest Comments Widget to your sidebar.", 'ta-magazine') );
        $this->WP_Widget( 'ta_magazine_comments_widget', __('TA Magazine: Latest Comments Widget', 'ta-magazine'), $widget_ops );
		$this->alt_option_name = 'ta_magazine_comments_widget';
    }

	public function flush_widget_cache() {
		wp_cache_delete('ta_magazine_comments_widget', 'widget');
	}

	public function widget($args, $instance) {
		global $comments, $comment;

		$cache = array();
		if ( !$this->is_preview() ) {
			$cache = wp_cache_get('ta_magazine_comments_widget', 'widget');
		}
		if ( !is_array( $cache ) ) {
			$cache = array();
		}

		if ( !isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		$output = '';

		$title = ( !empty($instance['title']) ) ? $instance['title'] : __( 'Latest Comments' );

		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$number = ( !empty($instance['number']) ) ? absint($instance['number']) : 5;
		if ( ! $number )
			$number = 5;

		$comments = get_comments( apply_filters('widget_comments_args', array(
			'number'      => $number,
			'status'      => 'approve',
			'post_status' => 'publish'
		)) );

		$output .= $args['before_widget'];
		if ($title) {
			$output .= $args['before_title'] . $title . $args['after_title'];
		}

		$output .= '<ul>';
		if ($comments) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck($comments, 'comment_post_ID') );
			_prime_post_caches( $post_ids, strpos( get_option('permalink_structure'), '%category%' ), false );

			foreach ( (array) $comments as $comment ) {
				$output .= '<li>';
				$output .= '<i class="fa fa-comments"></i>';
				/* translators: comments widget: 1: comment author, 2: post link */
				$output .= sprintf( _x( '%1$s on %2$s', 'ta-magazine' ),
					'<p class="semibold"><span>' . get_comment_author_link() . '</span>',
					'<span><a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a><span></p>'
				);
				$output .= '<p>';
				$output .= wp_trim_words( $comment->comment_content, 20, '<a href="'. esc_url( get_comment_link($comment->comment_ID) ) .'"> ...</a>' );
				$output .= '</p>';
				$output .= '</li>';
			}
		}
		$output .= '</ul>';
		$output .= $args['after_widget'];

		echo $output;

		if ( !$this->is_preview() ) {
			$cache[ $args['widget_id'] ] = $output;
			wp_cache_set('ta_magazine_comments_widget', $cache, 'widget');
		}
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get('alloptions', 'options');
		if ( isset($alloptions['ta_magazine_comments_widget']) )
			delete_option('ta_magazine_comments_widget');

		return $instance;
	}

	public function form($instance) {
		$title  = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ta-magazine'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of comments to show:', 'ta-magazine'); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}