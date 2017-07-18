<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package TA Magazine
 */

if ( ! is_active_sidebar( 'sidebar-right' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-md-4" role="complementary">
	<?php dynamic_sidebar( 'sidebar-right' ); ?>
</aside><!-- #secondary -->
