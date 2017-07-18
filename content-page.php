<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package TA Magazine
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- Post begin -->
	<div class="hr-bold">
		<?php the_title('<h2>', '</h2>'); ?>
	</div>

	<div class="post-content hr-bold">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'ta-magazine' ),
			'after'  => '</div>',
		) );
	?>
	</div>
	<!-- Post end -->
</article><!-- #post-## -->