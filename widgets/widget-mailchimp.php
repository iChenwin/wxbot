<?php
/**
 * MailChimp Newsletter Class
 *
 * @package TA Magazine
 */
 
class ta_magazine_mailchimp_widget extends WP_Widget {

	function ta_magazine_mailchimp_widget() {
        $widget_ops = array( 'classname' => 'newsletter-widget', 'description' => __("Add MailChimp Newsletter to your sidebar.", 'ta-magazine') );
        $this->WP_Widget( 'ta_magazine_mailchimp_widget', __('TA Magazine: MailChimp Newsletter Widget', 'ta-magazine'), $widget_ops );
    }

	public function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title']) ? __('Join Our Newsletter', 'ta-magazine') : $instance['title'], $instance, $this->id_base );
		$url = apply_filters( 'widget_url', empty($instance['url']) ? '' : $instance['url'], $instance, $this->id_base );
		$uid = apply_filters( 'widget_uid', empty($instance['uid']) ? '' : $instance['uid'], $instance, $this->id_base );
		$lid = apply_filters( 'widget_lid', empty($instance['lid']) ? '' : $instance['lid'], $instance, $this->id_base );
		$des = apply_filters( 'widget_des', empty($instance['des']) ? '' : $instance['des'], $instance, $this->id_base );
		echo $before_widget;
		echo $before_title;
		echo $title;
		echo $after_title;
		?>

		<!-- Begin MailChimp Signup Form -->
		<div>
			<form action="<?php echo $url; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					<input type="email" value="" name="EMAIL" class="form-control" placeholder="<?php _e('Your email address','ta-magazine') ?>" required>
					<div class="input-group-btn">
						<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div class="mailchimp">
							<input type="text" name="b_<?php echo $uid; ?>_<?php echo $lid; ?>" tabindex="-1" value="">
						</div>
						<div class="clear">
							<button type="submit" value="Subscribe" name="subscribe"  class="btn btn-default"><i class="fa fa-angle-right"></i></button>
						</div>
					</div>
				</div>
				<p><?php echo $des; ?></p>
			</form>
		</div>
		<!--End mc_embed_signup-->

		<?php echo $after_widget;
	}

	public function form($instance) {
		$instance = wp_parse_args( (array) $instance, array('title' => '', 'url' => '', 'uid' => '', 'lid' => '', 'des' => '') );
		$title = strip_tags($instance['title']);
		$url = strip_tags($instance['url']);
		$uid = strip_tags($instance['uid']);
		$lid = strip_tags($instance['lid']);
		$des = strip_tags($instance['des']);
?>
		<p><?php _e('Please visit <a href="http://kb.mailchimp.com/lists/signup-forms/host-your-own-signup-forms" target="_blank">MailChimp Knowledge Base</a> to get your Signup Form URL, User ID and List ID.', 'ta-magazine' ); ?></p>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ta-magazine'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><?php _e('Signup Form URL Structure:', 'ta-magazine' ); ?><br />http://listname.usx.list-manage.com/subscribe?u=userID&id=listID</p>
		<p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Signup Form URL:', 'ta-magazine'); ?> <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('uid'); ?>"><?php _e('User ID:', 'ta-magazine'); ?> <input class="widefat" id="<?php echo $this->get_field_id('uid'); ?>" name="<?php echo $this->get_field_name('uid'); ?>" type="text" value="<?php echo esc_attr($uid); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('lid'); ?>"><?php _e('List ID:', 'ta-magazine'); ?> <input class="widefat" id="<?php echo $this->get_field_id('lid'); ?>" name="<?php echo $this->get_field_name('lid'); ?>" type="text" value="<?php echo esc_attr($lid); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('des'); ?>"><?php _e('Description:', 'ta-magazine'); ?> <input class="widefat" id="<?php echo $this->get_field_id('des'); ?>" name="<?php echo $this->get_field_name('des'); ?>" type="text" value="<?php echo esc_attr($des); ?>" /></label></p>
<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array('title' => '', 'url' => '', 'uid' => '', 'lid' => '', 'dec' => '') );
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['uid'] = strip_tags($new_instance['uid']);
		$instance['lid'] = strip_tags($new_instance['lid']);
		$instance['des'] = strip_tags($new_instance['des']);

		return $instance;
	}

}