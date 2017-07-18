<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package TA Magazine
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ta_magazine_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'ta_magazine_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function ta_magazine_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'ta-magazine' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'ta_magazine_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function ta_magazine_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'ta_magazine_render_title' );
endif;

function my_special_nav_class( $classes, $item ) {
	// Adding custom classes to nav menu.
    $classes[] = 'dropdown';
    return $classes;
}
add_filter('nav_menu_css_class', 'my_special_nav_class', 10, 2);

function add_home_link($items, $args) {
	// Add Home link to nav menu.
	if ( $args->theme_location == 'primary' ) {
		$homeMenuItem =
			'<li>' .
			$args->before .
			'<a href="' . home_url( '/' ) . '" title="Home">' .
			$args->link_before . '<i class="fa fa-home"></i>' . $args->link_after .
			'</a>' .
			$args->after .
			$args->before .
			'<a class="tiny-home" href="' . home_url( '/' ) . '" title="Home">' .
			$args->link_before . 'Home' . $args->link_after .
			'</a>' .
			$args->after .
			'</li>';

		$items = $homeMenuItem . $items;
	}
  
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_home_link', 10, 2 );

/**
 * Add class to post navigation links.
 */
function post_link_attributes($output) {
    $code = 'class="btn btn-default post-nav"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}
add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');

/**
 * Add class to posts navigation links.
 */
function posts_link_attributes() {
    return 'class="btn btn-default posts-nav"';
}
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

/**
 * Add class to comment navigation links.
 */
function comments_link_attributes() {
    return 'class="btn btn-default comments-nav"';
}
add_filter('next_comments_link_attributes', 'comments_link_attributes');
add_filter('previous_comments_link_attributes', 'comments_link_attributes');

/**
 * Get images attached to post.
 */
if ( !function_exists('ta_post_images') ) {
	function ta_post_images( $args=array() ) {
		global $post;

		$defaults = array(
			'numberposts'		=> -1,
			'order'				=> 'ASC',
			'orderby'			=> 'menu_order',
			'post_mime_type'	=> 'image',
			'post_parent'		=>  $post->ID,
			'post_type'			=> 'attachment',
		);
		$args = wp_parse_args( $args, $defaults );

		return get_posts( $args );
	}
}

/**
 * Trims a string of words to a specified number of characters.
 */
function trim_characters($text, $length = 350, $append = '&hellip;') {

	$length = (int)$length;
	$text = trim( strip_tags( strip_shortcodes($text) ) );
	$text = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $text);

	if ( strlen($text) > $length ) {
		$text = substr($text, 0, $length + 1);
		$words = preg_split("/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY);
		preg_match("/[\s]|&nbsp;/", $text, $lastchar, 0, $length);
		if ( empty($lastchar) )
			array_pop( $words );

		$text = implode( ' ', $words ) . $append;
	}

	return $text;
}