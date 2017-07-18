<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category TA Magazine
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter('cmb_meta_boxes', 'cmb_metaboxes');
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_metaboxes(array $meta_boxes) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$meta_boxes['full-width_metabox'] = array(
		'id'         => 'full-width_metabox',
		'title'      => __('Full-Width Template', 'ta-magazine'),
		'pages'      => array('post',), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Use full-width template?',
				'desc' => 'Check to use full-width post template without sidebar.',
				'id' => $prefix . 'full_width',
				'type' => 'checkbox',
			),
		),
	);

	$meta_boxes['audio_metabox'] = array(
		'id'         => 'audio_metabox',
		'title'      => __('Audio Post Metabox', 'ta-magazine'),
		'pages'      => array('post',), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'       => __('Audio Source Link', 'ta-magazine'),
				'desc'       => __('The URL to the file.', 'ta-magazine'),
				'id'         => $prefix . 'audio_link',
				'type'       => 'file',
			),
			array(
				'name' => __('Embed Audio Code', 'ta-magazine'),
				'desc' => __('Paste audio embed code here.', 'ta-magazine'),
				'id'   => $prefix . 'audio_code',
				'type' => 'textarea_code',
			),
		),
	);

	$meta_boxes['video_metabox'] = array(
		'id'         => 'video_metabox',
		'title'      => __('Video Post Metabox', 'ta-magazine'),
		'pages'      => array('post',), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'       => __('Video Source Link', 'ta-magazine'),
				'desc'       => __('The URL to the file.', 'ta-magazine'),
				'id'         => $prefix . 'video_link',
				'type'       => 'file',
			),
			array(
				'name' => __('Embed Video Code', 'ta-magazine'),
				'desc' => __('Paste video embed code here.', 'ta-magazine'),
				'id'   => $prefix . 'video_code',
				'type' => 'textarea_code',
			),
		),
	);

	return $meta_boxes;
}
add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );

/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {
	if ( !class_exists('cmb_Meta_Box') )
		require_once 'init.php';
}
