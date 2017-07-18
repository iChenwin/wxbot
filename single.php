<?php
/**
 * The template for displaying all single posts.
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

	<section id="content" class="container blog-posts">
		<div class="row">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( function_exists('sharing_display') )
				remove_filter('the_content', 'sharing_display', 19); ?>

				<?php if ( function_exists('sharing_display') )
				remove_filter('the_excerpt', 'sharing_display', 19); ?>

				<!-- Post info begin -->
				<aside class="col-md-2 post-info clearfix">

					<!-- Author info begin -->
					<div class="author">
						<figure>
							<?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('ID'), 165 ); }?>
						</figure>
						<div>
							<h4><?php the_author_posts_link(); ?></h4>
							<p><?php the_author_meta('description'); ?></p>
						</div>
					</div>
					<!-- Author info end -->

					<div>
						<p class="meta-tags">
							<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
							<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
								<?php jp_get_post_views( get_the_ID() ); ?>
							<?php endif; ?>
							<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
								<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
							<?php endif; ?>
							<?php
							$categories_list = get_the_category_list(' / ');
							if ( $categories_list && ta_magazine_categorized_blog() ) :
							?>
							<span><?php printf('<i class="fa fa-folder"></i> %1$s', $categories_list); ?></span>
							<?php endif; ?>
							<?php
							$tags_list = get_the_tag_list( '', ' / ' );
							if ($tags_list) :
							?>
							<span><?php printf('<i class="fa fa-tags"></i> %1$s', $tags_list); ?></span>
							<?php endif; ?>
						</p>

						<?php if ( function_exists('sharing_display') ) echo sharing_display(); ?>

						<div class="post-left-adv">
							<?php if ( ta_option('ad_left') != '' ) { echo ta_option('ad_left'); } ?>
						</div>
					</div>
				</aside>
				<!-- Post info end -->

				<?php $switch = !empty( get_post_meta($post->ID, '_cmb_full_width') ) ? '1' : '0'; ?>
				<div class="col-md-<?php echo ( $switch == '1' ? '10' : '6' ); ?>">

					<?php get_template_part( 'content', 'single' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				</div>

				<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php if ($switch == '0') : ?>
			<!-- Sidebar block begin -->
			<?php get_sidebar(); ?>
			<!-- Sidebar block end -->
			<?php endif; ?>
		</div>
	</section>

<?php get_footer(); ?>
