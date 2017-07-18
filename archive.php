<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package TA Magazine
 */

get_header(); ?>

	<section id="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php ta_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	</section>

	<section id="content" class="container<?php if ( ta_option('disable_listing_style') == '1' ) { echo ' ms-listing'; } ?>">
		<div class="row">
			<div id="primary" class="content-area col-md-8<?php if ( ta_option('disable_listing_style') == '0' ) { echo ' blog-listing'; } ?>">
				<main id="main" class="site-main" role="main">

				<?php if ( have_posts() ) : ?>

				<div class="hr-bold">
					<?php the_archive_title('<h2>', '</h2>'); ?>
				</div>

				<?php if ( ta_option('disable_listing_style') == '1' ) { echo '<div id="masonry">'; } ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php ta_magazine_paging_nav(); ?>

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>
				<?php if ( ta_option('disable_listing_style') == '1' ) { echo '</div>'; } ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<!-- Sidebar block begin -->
			<?php get_sidebar(); ?>
			<!-- Sidebar block end -->
		</div>
	</section>

<?php get_footer(); ?>