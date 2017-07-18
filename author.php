<?php
/**
 * The template for displaying author archive pages.
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

	<section id="content" class="container">
		<div class="row">
			<div id="primary" class="author-page col-md-8<?php if ( ta_option('disable_listing_style') == '0' ) { echo ' blog-listing'; } ?>">
				<main id="main" class="site-main" role="main">

				<!-- Author info begin -->
				<div class="author">
					<figure>
						<?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('ID'), 170 ); }?>
					</figure>
					<div>
						<h2><?php the_author_posts_link(); ?></h2>
						<p><?php the_author_meta('description'); ?></p>
					</div>
					<?php
					// Retrieve a custom field value
					$wHandle = get_the_author_meta('user_url');
					$tHandle = get_the_author_meta('twitter'); 
					$fHandle = get_the_author_meta('facebook');
					$gHandle = get_the_author_meta('gplus');
					$lHandle = get_the_author_meta('linkedin');
					$dHandle = get_the_author_meta('dribbble');
					$pHandle = get_the_author_meta('pinterest');
					?>
					<div class="social-icons">
						<ul>
							<?php if ( get_the_author_meta('user_url') != '' ) : ?>
							<li>
								<a href="<?php echo $wHandle; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Website"><i class="fa fa-globe"></i></a>
							</li>
							<?php endif; // no website url ?>

							<?php if ( get_the_author_meta('twitter') != '' ) : ?>
							<li>
								<a href="<?php echo $tHandle; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
							</li>
							<?php endif; // no twitter url ?>

							<?php if ( get_the_author_meta('facebook') != '' ) : ?>
							<li>
								<a href="<?php echo $fHandle; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
							</li>
							<?php endif; // no facebook url ?>

							<?php if ( get_the_author_meta('gplus') != '' ) : ?>
							<li>
								<a href="<?php echo $gHandle; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Google Plus"><i class="fa fa-google-plus"></i></a>
							</li>
							<?php endif; // no gplus url ?>

							<?php if ( get_the_author_meta('linkedin') != '' ) : ?>
							<li>
								<a href="<?php echo $lHandle; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a>
							</li>
							<?php endif; // no linkedin url ?>

							<?php if ( get_the_author_meta('dribbble') != '' ) : ?>
							<li>
								<a href="<?php echo $dHandle; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Dribbble"><i class="fa fa-dribbble"></i></a>
							</li>
							<?php endif; // no dribbble url ?>

							<?php if ( get_the_author_meta('pinterest') != '' ) : ?>
							<li>
								<a href="<?php echo $dHandle; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Pinterest"><i class="fa fa-pinterest"></i></a>
							</li>
							<?php endif; // no pinterest url ?>
						</ul>
					</div>
				</div>
				<!-- Author info end -->

				<?php if ( have_posts() ) : ?>

				<!-- Author's posts begin -->
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
				<!-- Author's posts end -->

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