<?php
/**
 * The template for displaying search results pages.
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
			<div id="primary" class="col-md-8 search-res blog-listing">
				<main id="main" class="site-main" role="main">

				<div class="hr-bold">
					<?php
					$allsearch = new WP_Query("s=$s&showposts=-1");
					$count = $allsearch->post_count;
					wp_reset_query();
					?>
					<h2><?php printf( __( 'Search Results for: %s', 'ta-magazine' ), '<span class="result">' . get_search_query() . '</span>' ); ?> <?php echo '( <span class="red">' .$count . '</span> )'; ?></h2>
				</div>

				<?php if ( have_posts() ) : ?>

				<!-- Search results begin -->
				<ul>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<li>
						<article id="post-<?php the_ID(); ?>" <?php post_class( array('post-type-1', 'clearfix') ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
							<div class="post-thumbnail-3">
								<div class="tag-style-2">
									<?php
									$categories_list = get_the_category_list(' / ');
									$category = get_the_category();
									$tag = $category[0]->cat_ID;
									$tag_extra_fields = get_option(add_category_icon);
									if ( isset($tag_extra_fields[$tag]) ) {
										$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
									}
									?>
									<p><?php printf($categories_list); ?></p><?php if(!empty($category_icon_code)) { ?><i class="fa fa-<?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?>"></i><?php } ?>
									<?php $category_icon_code = ""; ?>
								</div>
								<figure>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail( 'feature-md', array('class' => "img-responsive") ); ?>
									</a>
								</figure>
							</div>
							<?php endif; ?>

							<div class="meta-tags">
								<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
								<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
								<?php if ( !post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
									<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
								<?php endif; ?>
								<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
									<?php jp_get_post_views( get_the_ID() ); ?>
								<?php endif; ?>
							</div>
							<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
							<p>
							<?php if( has_excerpt() ) {
								the_excerpt();
							} else {
								echo trim_characters( get_the_content() );
							} ?>
							</p>
							<a href="<?php echo get_permalink(); ?>" class="btn btn-default read-more"><p><?php echo ta_option('read_more_text', 'Read More'); ?></p></a>
						</article>
					</li>

				<?php endwhile; ?>
				</ul>
				<!-- Search results end -->

				<?php ta_magazine_paging_nav(); ?>

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<!-- Sidebar block begin -->
			<?php get_sidebar(); ?>
			<!-- Sidebar block end -->
		</div>
	</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>