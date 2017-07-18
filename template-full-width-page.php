<?php
/**
 * The template for displaying full-width pages.
 *
 * @package TA Magazine
 *
 * Template Name: Full Width Page
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

	<section id="content" class="container">
		<div class="row">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<div class="col-md-12">
						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part('content', 'page'); ?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
							?>

						<?php endwhile; // end of the loop. ?>
					</div>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	<section>

<?php get_footer(); ?>
