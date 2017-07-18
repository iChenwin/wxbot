<?php
/**
 * TA Magazine functions and definitions
 *
 * @package TA Magazine
 */

/**
 * Include the Redux theme options Framework.
 */
if ( !class_exists( 'ReduxFramework' ) ) {
	require_once( get_template_directory() . '/redux/framework.php' );
}

/**
 * Register all the theme options.
 */
require_once( get_template_directory() . '/inc/redux-config.php' );

/**
 * Theme options functions.
 */
require_once( get_template_directory() . '/inc/ta-option.php' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( !isset($content_width) ) {
	$content_width = 555; /* pixels */
}

/**
 * Set the content width for full width pages with no sidebar.
 */
function full_width_page() {
	if ( is_page_template('template-full-width-page.php') ) {
	global $content_width;
	$content_width = 1140; /* pixels */
	}
}
add_action('template_redirect', 'full_width_page');

if ( ! function_exists( 'ta_magazine_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ta_magazine_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on TA Magazine, use a find and replace
	 * to change 'ta-magazine' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'ta-magazine', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'slider-lg', 750, 360, true );
	add_image_size( 'slider-sm', 165, 165, true );
	add_image_size( 'slide-show', 360, 265, true );
	add_image_size( 'feature-lg', 360, 165, true );
	add_image_size( 'feature-md', 270, 250, true );
	add_image_size( 'feature-sm', 90, 90, true );
	add_image_size( 'gallery-lg', 945, 530, true );
	add_image_size( 'gallery-sm', 180, 110, true );
	add_image_size( 'related', 270, 170, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ta-magazine' ),
		'secondary' => __( 'Secondary Menu', 'ta-magazine' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'gallery', 'audio', 'video',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ta_magazine_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // ta_magazine_setup
add_action( 'after_setup_theme', 'ta_magazine_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function ta_magazine_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'ta-magazine' ),
		'id'            => 'sidebar-right',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="hr-bold">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 1', 'ta-magazine' ),
		'id'            => 'footer-widget-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 2', 'ta-magazine' ),
		'id'            => 'footer-widget-2',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 3', 'ta-magazine' ),
		'id'            => 'footer-widget-3',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_widget('ta_magazine_social_widget');
	register_widget('ta_magazine_posts_widget');
	register_widget('ta_magazine_post_tabs_widget');
	register_widget('ta_magazine_popular_posts_widget');
	register_widget('ta_magazine_slide_show_widget');
	register_widget('ta_magazine_comments_widget');
	register_widget('ta_magazine_about_widget');
	register_widget('ta_magazine_mailchimp_widget');
}
add_action('widgets_init', 'ta_magazine_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function ta_magazine_scripts() {
	wp_enqueue_style( 'ta-magazine-bootstrap-style', get_template_directory_uri() . '/layouts/bootstrap.min.css', array(), '3.3.2', 'all' );

	wp_enqueue_style( 'ta-magazine-bootstrap-theme-style', get_template_directory_uri() . '/layouts/bootstrap-theme.min.css', array(), '3.3.2', 'all' );

	wp_enqueue_style( 'ta-magazine-font-awesome-style', get_template_directory_uri() . '/layouts/font-awesome.min.css', array(), '4.3.0', 'all' );

	wp_enqueue_style( 'ta-magazine-lightbox-style', get_template_directory_uri() . '/layouts/jquery.lightbox.css', array(), '', 'all' );

	wp_enqueue_style( 'ta-magazine-owl-carousel-style', get_template_directory_uri() . '/layouts/owl.carousel.css', array(), '1.3.3', 'all' );

	wp_enqueue_style( 'ta-magazine-owl-theme-style', get_template_directory_uri() . '/layouts/owl.theme.css', array(), '1.3.3', 'all' );

	wp_enqueue_style( 'ta-magazine-owl-transitions-style', get_template_directory_uri() . '/layouts/owl.transitions.css', array(), '1.3.2', 'all' );

	wp_enqueue_style( 'ta-magazine-custom-font-style', get_template_directory_uri() . '/layouts/font.css', array(), '', 'all' );

	wp_enqueue_style( 'ta-magazine-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ta-magazine-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.2', true );

	wp_enqueue_script( 'ta-magazine-placeholder-js', get_template_directory_uri() . '/js/jquery.placeholder.js', array('jquery'), '', true );

	wp_enqueue_script( 'ta-magazine-tinynav-js', get_template_directory_uri() . '/js/tinynav.min.js', array('jquery'), '1.2', true );

	wp_enqueue_script( 'ta-magazine-lightbox-js', get_template_directory_uri() . '/js/jquery.lightbox.min.js', array('jquery'), '', true );

	wp_enqueue_script( 'ta-magazine-owlcarousel-js', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '1.3.3', true );

	wp_enqueue_script( 'ta-magazine-app-js', get_template_directory_uri() . '/js/app.js', array('jquery'), '', true );

	wp_enqueue_script( 'masonry' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ta_magazine_scripts' );

/**
 * Add Respond.js for IE
 */
if( !function_exists('ie_scripts') ) {
	function ie_scripts() {
	 	echo '<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->';
	   	echo ' <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->';
	   	echo ' <!--[if lt IE 9]>';
	    echo ' <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>';
	    echo ' <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>';
	   	echo ' <![endif]-->';
   	}
   	add_action('wp_head', 'ie_scripts');
} // end if

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require_once get_template_directory() . '/inc/jetpack.php';

/**
 * Add category icon.
 */
require_once get_template_directory() . '/inc/category-icon.php';

/**
 * Add Breadcrumbs.
 */
require_once get_template_directory() . '/inc/breadcrumb.php';

/**
 * Comments Callback.
 */
require_once get_template_directory() . '/inc/comments-callback.php';

/**
 * Add Custom Meta Boxes.
 */
require_once get_template_directory() . '/inc/custom-metaboxes/CMB.php';

/**
 * Add Author Meta.
 */
require_once get_template_directory() . '/inc/author-meta.php';

/**
 * Theme Options - Custom CSS.
 */
require_once get_template_directory() . '/inc/custom-css.php';

/**
 * Add Theme Widgets.
 */
require_once (get_template_directory() . '/widgets/widget-social.php');
require_once (get_template_directory() . '/widgets/widget-posts.php');
require_once (get_template_directory() . '/widgets/widget-post-tabs.php');
require_once (get_template_directory() . '/widgets/widget-popular-posts.php');
require_once (get_template_directory() . '/widgets/widget-slide-show.php');
require_once (get_template_directory() . '/widgets/widget-comments.php');
require_once (get_template_directory() . '/widgets/widget-about.php');
require_once (get_template_directory() . '/widgets/widget-mailchimp.php');