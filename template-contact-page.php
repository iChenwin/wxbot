<?php
/**
 * The template for displaying contact page.
 *
 * @package TA Magazine
 *
 * Template Name: Contact Page
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

	<section id="content" class="container contact">
		<div class="row">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<div class="col-md-8">
						<div class="hr-bold">
							<?php the_title('<h2>', '</h2>'); ?>
						</div>

						<?php if ( ta_option('disable_map') == '1' ) { ?>
						<!-- Google Map begin -->
						<div class="map">
							<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1584.2679903399307!2d-122.09496935581758!3d37.42444119584552!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba1a7f2db7e7%3A0x59c3e570fe8e0c73!2sGoogle+West+Campus+6%2C+2350+Bayshore+Pkwy%2C+Mountain+View%2C+CA+94043%2C+USA!5e0!3m2!1sen!2s!4v1422891258666" width="600" height="450" frameborder="0" style="border:0"></iframe>
						</div>
						<!-- Google Map end -->
						<?php } ?>

						<div class="post-content hr-bold">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; ?>
						</div>

						<!-- Contact form begin -->
						<div class="contact-form">
							<h2><?php _e('Tell us about yourself...', 'ta-magazine' ); ?></h2>
							<div id="form-messages"></div>
							<form id="ajax-contact" method="post" action="<?php echo get_template_directory_uri() . '/inc/mailer.php'; ?>">
								<div class="col-md-6 form-group field">
									<input type="text" class="form-control"  name="contactName" id="comment-name" placeholder="<?php _e('Name', 'ta-magazine' ); ?>" required>
								</div>
								<div class="col-md-6 form-group field">
									<input type="email" class="form-control" name="email" id="comment-email" placeholder="<?php _e('Email address', 'ta-magazine' ); ?>" required>
								</div>
								<div class="clearfix"></div>
									<div class="col-md-6 whats-up">
										<h2><?php _e("Whats's up?", 'ta-magazine' ); ?></h2>
										<p><?php _e('What is it going to be about? (Subject)', 'ta-magazine' ); ?></p>

										<?php
										$subjects = ta_option('contact_subject');
										?>
										<?php foreach ($subjects as $key => $value) { ?>
										<div class="form-group">
											<div class="radio field">
												<input type="radio" name="whats-upRadios" id="whats-up<?php echo $key+1; ?>" value="<?php echo $value; ?>" <?php if ($key == 0) { echo 'checked'; } ?>>
												<label for="whats-up<?php echo $key+1; ?>" onclick="">
													<?php echo $value; ?>
												</label>
											</div>
										</div>
										<?php
										}
										?>

									</div>
								<div class="col-md-6 contact-textfield">
									<div class="form-group field">
										<textarea class="form-control" rows="7" id="comment-text" name="message" placeholder="<?php _e('How can we help you?', 'ta-magazine' ); ?>" required></textarea>
									</div>
									<button type="submit" class="btn btn-default read-more"><?php _e('Send', 'ta-magazine' ); ?></button>
								</div>
							</form>
						</div>
						<!-- Contact form end -->
					</div>

				</main><!-- #main -->
			</div><!-- #primary -->

			<!-- Sidebar block begin -->
			<?php get_sidebar(); ?>
			<!-- Sidebar block end -->
		</div>
	<section>

<?php get_footer(); ?>