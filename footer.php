<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package TA Magazine
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container footer-content">
			<div class="row">
				<!-- Footer widget 1 begin -->
				<div class="col-md-4">
					<?php dynamic_sidebar('footer-widget-1'); ?>
				</div>
				<!-- Footer widget 1 end -->

				<!-- Footer widget 2 begin -->
				<div class="col-md-4">
					<?php dynamic_sidebar('footer-widget-2'); ?>
				</div>
				<!-- Footer widget 2 end -->

				<!-- Footer widget 3 begin -->
				<div class="col-md-4">
					<?php dynamic_sidebar('footer-widget-3'); ?>
				</div>
				<!-- Footer widget 3 end -->
			</div>
		</div>

		<!-- Copyrights -->
		<div class="copyright">
			<div class="container">
				<div class="row">
					<p><?php if ( ta_option('custom_copyright') != '') : ?><?php echo ta_option('custom_copyright'); ?><?php endif; ?></p>
					<!-- Footer menu -->
					<div class="footer-menu">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'secondary',
							'container'      => false,
							)
						);
						?>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
