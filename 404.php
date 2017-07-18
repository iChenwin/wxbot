<?php
/**
 * The template for displaying 404 pages (not found).
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
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<div class="page-404 col-md-4">
						<?php $error_image = ta_option('404_image', false, 'url'); ?>
						<?php if($error_image !== '') { ?>
							<img class="img-responsive" src="<?php echo $error_image ?>" alt="404">
						<?php } else { ?>
							<img class="img-responsive" src="<?php bloginfo( 'template_directory' ); ?>/images/404.png" alt="404">
						<?php } ?>
					</div>
					<div class="page-404 col-md-4">
						<?php if ( ta_option('404_info') != '' ) { echo '<p>' .ta_option('404_info'). '</p>'; } ?>
						<ul>
							<li>
								<a href="javascript:history.go(-1)"><?php _e('Go to Previous Page', 'ta-magazine'); ?></a>
							</li>	
							<li>
								<a href="<?php echo home_url( '/' ); ?>"><?php _e('Go to Homepage', 'ta-magazine'); ?></a>
							</li>
						</ul>
					</div>

				</main><!-- #main -->
			</div><!-- #primary -->

			<!-- Sidebar block begin -->
			<?php get_sidebar(); ?>
			<!-- Sidebar block end -->
		</div>
	</section>

<?php get_footer(); ?>
