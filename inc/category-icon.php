<?php
/**
 * Add Category Icon
 *
 * @package TA Magazine
 */

// The option name
define('add_category_icon', 'my_category_fields_option');

// Your fields (the form)
function ta_my_category_fields($tag) {
    $tag_extra_fields = get_option(add_category_icon);
	$category_icon_code = isset( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) : '';
?>

<div class="form-field">	
	<table class="form-table">
		<tr class="form-field">
			<th scope="row" valign="top"><label for="category-page-slider"><?php _e('Icon Code', 'ta-magazine'); ?></label></th>
			<td>
				<input id="category_icon_code" type="text" size="36" name="category_icon_code" value="<?php $category_icon = stripslashes($category_icon_code); echo esc_attr($category_icon); ?>" />
				<p class="description"><?php _e('AwesomeFont code:', 'ta-magazine'); ?> <a href="http://fontawesome.io/icons/" target="_blank">fontawesome.io/icons</a>. <?php _e('e.g.', 'ta-magazine'); ?> folder-open.</p>
			</td>
		</tr>
	</table>
</div>

<?php }
add_filter('edit_category_form_fields', 'ta_my_category_fields');

// When the form gets submitted.
function ta_update_my_category_fields($term_id) {
	if($_POST['taxonomy'] == 'category'):
		$tag_extra_fields = get_option(add_category_icon);
		$tag_extra_fields[$term_id]['category_icon_code'] = $_POST['category_icon_code'];
		update_option(add_category_icon, $tag_extra_fields);
	endif;
}
add_action('edit_term_taxonomy', 'ta_update_my_category_fields');  

// When a category is removed.
function ta_remove_my_category_fields($term_id) {
	if($_POST['taxonomy'] == 'category'):
		$tag_extra_fields = get_option(add_category_icon);
		unset($tag_extra_fields[$term_id]);
		update_option(add_category_icon, $tag_extra_fields);
	endif;
}
add_filter('deleted_term_taxonomy', 'ta_remove_my_category_fields');