<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package TA Magazine
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function ta_magazine_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'type'      => 'click',
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'ta_magazine_jetpack_setup' );

/**
 * Custom Older Posts for Infinite Scroll.
 */
function filter_jetpack_infinite_scroll_js_settings($settings) {
    $settings['text'] = ta_option('load_more_text', '+ Load More');

    return $settings;
}
add_filter( 'infinite_scroll_js_settings', 'filter_jetpack_infinite_scroll_js_settings' );

/**
 * Get post views from Jetpack.
 */
function jp_get_post_views( $postID ) {
	if ( function_exists('stats_get_csv') ) {
		$post_stats = stats_get_csv( 'postviews', array( 'days' => 365, 'limit' => -1 ) );
		foreach ($post_stats as $p) {
			if ( $p['post_id'] == $postID ) { ?>
				<span><?php echo '<i class="fa fa-eye"></i>' . number_format_i18n( $p['views'] ); ?></span>
			<?php }
		}
	} ?>
<?php }

/**
 * Remove Jetpack's related-posts scripts.
 */
function jetpackme_remove_rp() {
	if ( class_exists('Jetpack_RelatedPosts') ) {
		$jprp = Jetpack_RelatedPosts::init();
		$callback = array($jprp, 'filter_add_target_to_dom');
		remove_filter('the_content', $callback, 40);
	}
}
add_filter('wp', 'jetpackme_remove_rp', 20);

/**
 * Disable Infinite Scroll on search result and author pages.
 */
function tweakjp_custom_is_support() {
    $supported = current_theme_supports('infinite-scroll') && ( !is_search() );
     
    return $supported;
}
add_filter('infinite_scroll_archive_supported', 'tweakjp_custom_is_support');

/*
 * Remove/Deregister Jetpack contact form styles.
 */
add_filter('jetpack_implode_frontend_css', '__return_false');

function remove_jetpack_stylesheets() {
    wp_deregister_style('grunion.css'); // Grunion Is Jetpack's Contact Form
} 
add_action('wp_print_styles', 'remove_jetpack_stylesheets');