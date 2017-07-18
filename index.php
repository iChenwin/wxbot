<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package TA Magazine
 */

get_header(); ?>

	<?php if ( ta_option('disable_slider') == '1' ) { ?>
	<!-- Slider block begin -->
	<section class="slider-wrapper">
		<div class="container">
			<div class="row">
				<?php
				// get recent sticky posts.
				$sticky = get_option('sticky_posts');
				rsort($sticky);
				$sum = count($sticky);
				if ($sum <= 4) {
					$psum = $sum;
				} else {
					$psum = 4;
				}
				?>

				<?php if ($sticky[0]) : ?>
				<!-- Slider begin (bootstrap carousel) -->
				<div class="col-md-8 slider">
				    <div id="slider" class="carousel slide" data-ride="carousel">
					    <ol class="carousel-indicators">
						<?php
						$o = 1;
						while ($o <= $psum) {
						?>
							<li data-target="#slider" data-slide-to="<?php echo $o-1?>"<?php if ($o == 1) { echo 'class="active"'; } ?>></li>
						<?php
						$o++;
						}
						?>
					    </ol>

					    <!-- Carousel items begin -->
					    <div class="carousel-inner">
							<?php
							$i = 1;
							$sposts = array_slice ($sticky, 0, 4);
							$posts = new WP_Query( array('post__in' => $sposts, 'ignore_sticky_posts' => 1) );
							while( $posts->have_posts() ) : $posts->the_post();
							?>
						    <div class="<?php if ($i == 1) { echo 'active'; } ?> item">
								<div class="post-thumbnail-1">
									<div class="tag-style-1">
										<?php
										$categories_list = get_the_category_list(' / ');
										$category = get_the_category();
										$tag = $category[0]->cat_ID;
										$tag_extra_fields = get_option(add_category_icon);
										if ( isset($tag_extra_fields[$tag]) ) {
											$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
										}
										?>
										<p><?php printf($categories_list); ?></p><?php if(!empty($category_icon_code)) {?><i class="fa fa-<?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?>"></i><?php } ?>
										<?php $category_icon_code = ""; ?>
									</div>
									<figure>
										<?php 
										if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php the_post_thumbnail( 'slider-lg', array('class' => "img-responsive") ); ?>
										</a>
										<?php endif; ?>
									</figure>
									<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
									<p class="meta-tags">
										<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
										<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
										<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
											<?php jp_get_post_views( get_the_ID() ); ?>
										<?php endif; ?>
										<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
											<span><i class="fa fa-comments"></i><?php comments_popup_link( __('Leave a comment', 'ta-magazine'), __('1 Comment', 'ta-magazine'), __('% Comments', 'ta-magazine') ); ?></span>
										<?php endif; ?>
									</p>
								</div>
						    </div>
							<?php
							$i++;
							endwhile;
							wp_reset_query();
							?>
						</div>
					    <!-- Carousel's item end -->
					</div>
				</div>
				<!-- Slider end -->
				<?php else : ?>
					<?php _e('No sticky posts.', 'ta-magazine' ); ?>
				<?php endif; ?>

				<?php if ($sum > 4) : ?>
				<!-- Slider sidebar begin -->
				<div class="col-md-4 slider-sidebar">
					<div class="row ">
						<div class="slider-sidebar-wrapper">
							<div class="col-md-6">
								<?php
								$s = 1;
								$sposts = array_slice ($sticky, 4, 2);
								$posts = new WP_Query( array('post__in' => $sposts, 'ignore_sticky_posts' => 1) );
								while( $posts->have_posts() ) : $posts->the_post();
								?>
								<div class="post-thumbnail-2">
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
										<p><?php printf($categories_list); ?></p><?php if(!empty($category_icon_code)) {?><i class="fa fa-<?php $category_icon = stripslashes($category_icon_code); echo $category_icon; ?>"></i><?php } ?>
										<?php $category_icon_code = ""; ?>
									</div>
									<figure>
										<?php 
										if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php the_post_thumbnail( 'slider-sm', array('class' => "img-responsive") ); ?>
										</a>
										<?php endif; ?>
									</figure>
									<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
								</div>
								<?php
								$s++;
								endwhile;
								wp_reset_query();
								?>
							</div>
							<?php if ($sum > 6) : ?>
							<div class="col-md-6">
								<?php
								$s = 3;
								$sposts = array_slice ($sticky, 6, 2);
								$posts = new WP_Query( array('post__in' => $sposts, 'ignore_sticky_posts' => 1) );
								while( $posts->have_posts() ) : $posts->the_post();
								?>
								<div class="post-thumbnail-2<?php if ($s == 4) { echo ' mr-0'; } ?>">
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
										<?php 
										if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php the_post_thumbnail( 'slider-sm', array('class' => "img-responsive") ); ?>
										</a>
										<?php endif; ?>
									</figure>
									<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
								</div>
								<?php
								$s++;
								endwhile;
								wp_reset_query();
								?>								
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<!-- Slider sidebar end -->
				<?php endif; ?>
			</div>
		</div>
	</section>
	<!-- Slider block end -->
	<?php } else { ?>
	<!-- Breadcrumbs block begin -->
	<section id="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					 <?php ta_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>

	<!-- Content block begin -->
	<section id="content" class="container">
		<div class="row">
			<div class="col-md-8">
				<?php if ( ta_option('disable_modern') == '1' ) { ?>
				<!-- Modern Style Content section begin -->
				<div class="row hr-bold">
					<?php
					$o = 1;
					while ($o <= 2) {
					?>
					<div class="col-md-6">
						<?php
						if ( ta_option('modern_cat', [$o-1]) != '') :
						$category_id = ta_option('modern_cat')[$o-1];
						$category_link = get_category_link($category_id);
						$category_name = get_cat_name($category_id);
						endif;
						?>
						<h2><a href="<?php echo esc_url($category_link); ?>"><?php echo $category_name; ?></a></h2>
						<div>
							<?php
							$posts = new WP_Query( array('showposts' => 1, 'cat' => $category_id, 'post_status' => 'publish', 'post__not_in' => get_option('sticky_posts'), 'has_password' => false) );
							while( $posts->have_posts() ) : $posts->the_post();
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('post-type-1'); ?>>
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
										<?php 
										if ( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php the_post_thumbnail( 'feature-lg', array('class' => "img-responsive") ); ?>
										</a>
										<?php endif; ?>
									</figure>
									<div class="meta-tags">
										<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
										<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
										<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
											<?php jp_get_post_views( get_the_ID() ); ?>
										<?php endif; ?>
										<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
											<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
										<?php endif; ?>
									</div>
								</div>
								<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
								<p>
								<?php if( has_excerpt() ) {
									the_excerpt();
								} else {
									echo trim_characters( get_the_content() );
								} ?>
								</p>
							</article>
							<?php
							endwhile;
							wp_reset_query();
							?>

							<ul class="post-list">
								<?php
								$post_number = ta_option('modern_posts') - 1;
								$posts = new WP_Query( array('showposts' => $post_number, 'offset' => 1, 'cat' => $category_id, 'post_status' => 'publish', 'post__not_in' => get_option('sticky_posts'), 'has_password' => false) );
								while( $posts->have_posts() ) : $posts->the_post();
								?>
								<li>
									<article id="post-<?php the_ID(); ?>" <?php post_class( array('post-type-2', 'clearfix') ); ?>>
										<figure>
											<a href="<?php echo get_permalink(); ?>">
												<?php the_post_thumbnail( 'feature-sm', array('class' => "img-responsive") ); ?>
												<div class="tag-style-3">
												<?php if ( 'gallery' == get_post_format() ) { ?>
													<i class="fa fa-image"></i>
												<?php } elseif ( 'audio' == get_post_format() ) { ?>
													<i class="fa fa-music"></i>
												<?php } elseif ( 'video' == get_post_format() ) { ?>
													<i class="fa fa-video-camera"></i>
												<?php } else { ?>
													<i class="fa fa-plus"></i>
												<?php } ?>
												</div>
											</a>
										</figure>
										<header>
											<p class="meta-tags">
												<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
												<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
													<?php jp_get_post_views( get_the_ID() ); ?>
												<?php endif; ?>
												<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
													<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
												<?php endif; ?>
											</p>
											<h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
										</header>
									</article>
								</li>
								<?php
								endwhile;
								wp_reset_query();
								?>
							</ul>
						</div>
					</div>
					<?php
					$o++;
					}
					?>
				</div>
				<!-- Modern Style Content section end -->
				<?php } ?>

				<?php if ( ta_option('disable_tab') == '1' ) { ?>
				<!-- Tab Style Content section begin -->
				<div class="row hr-bold">
					<?php $sum = count( ta_option('tab_cat') ); ?>
					<div class="col-md-12">
						<ul class="nav-tabs" id="content-tabs">
							<?php
							$o = 1;
							while ($o <= $sum) {
							?>
							<li <?php if ($o == 1) { echo 'class="active"'; } ?>>
								<a href="#tab<?php echo $o; ?>" data-toggle="tab"><h2><?php echo get_cat_name( ta_option('tab_cat')[$o-1] ); ?></h2></a>
							</li>
							<?php
							$o++;
							}
							?>
						</ul>
					</div>
					<div class="clearfix"></div>
					<div class="tab-content">
						<?php
						$o = 1;
						while ($o <= $sum) {
						?>
						<div  class="tab-pane <?php if ($o == 1) { echo 'active'; } ?>" id="tab<?php echo $o; ?>">
							<div class="col-md-6">
								<?php
								$posts = new WP_Query( array('showposts' => 1, 'cat' => ta_option('tab_cat')[$o-1], 'post_status' => 'publish', 'post__not_in' => get_option('sticky_posts'), 'has_password' => false) );
								while( $posts->have_posts() ) : $posts->the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( array('post-type-1', 'hr-none') ); ?>>
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
										<figure>
											<?php 
											if ( has_post_thumbnail() ) : ?>
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
												<?php the_post_thumbnail( 'feature-lg', array('class' => "img-responsive") ); ?>
											</a>
											<?php endif; ?>
										</figure>
										<div class="meta-tags">
											<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
											<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
											<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
												<?php jp_get_post_views( get_the_ID() ); ?>
											<?php endif; ?>
											<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
												<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
											<?php endif; ?>
										</div>
									</div>
									<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
									<p>
									<?php if( has_excerpt() ) {
										the_excerpt();
									} else {
										echo trim_characters( get_the_content() );
									} ?>
									</p>
								</article>
								<?php
								endwhile;
								wp_reset_query();
								?>
							</div>
							<div class="col-md-6">
								<ul class="post-list">
									<?php
									$posts = new WP_Query( array('showposts' => 3, 'offset' => 1, 'cat' => ta_option('tab_cat')[$o-1], 'post_status' => 'publish', 'post__not_in' => get_option('sticky_posts'), 'has_password' => false) );
									while( $posts->have_posts() ) : $posts->the_post();
									?>
									<li>
										<article id="post-<?php the_ID(); ?>" <?php post_class( array('post-type-2', 'clearfix') ); ?>>
											<figure>
												<a href="<?php echo get_permalink(); ?>">
													<?php the_post_thumbnail( 'feature-sm', array('class' => "img-responsive") ); ?>
													<div class="tag-style-3">
													<?php if ( 'gallery' == get_post_format() ) { ?>
														<i class="fa fa-image"></i>
													<?php } elseif ( 'audio' == get_post_format() ) { ?>
														<i class="fa fa-music"></i>
													<?php } elseif ( 'video' == get_post_format() ) { ?>
														<i class="fa fa-video-camera"></i>
													<?php } else { ?>
														<i class="fa fa-plus"></i>
													<?php } ?>
													</div>
												</a>
											</figure>
											<header>
												<p class="meta-tags">
													<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
													<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
														<?php jp_get_post_views( get_the_ID() ); ?>
													<?php endif; ?>
													<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
														<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
													<?php endif; ?>
												</p>
												<h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
											</header>
										</article>
									</li>
									<?php
									endwhile;
									wp_reset_query();
									?>
								</ul>
							</div>
						</div>
						<?php
						$o++;
						}
						?>
					</div>
				</div>
				<!-- Tab Style Content section end -->
				<?php } ?>

				<?php if ( ta_option('disable_blog') == '1' ) { ?>
				<!-- Blog Style Content section begin -->
				<div class="row">
					<?php
					$o = 1;
					while ($o <= 2) {
					?>
					<div class="col-md-6">
						<?php
						if ( ta_option('blog_cat', [$o-1]) != '') :
						$category_id = ta_option('blog_cat')[$o-1];
						$category_link = get_category_link($category_id);
						$category_name = get_cat_name($category_id);
						endif;
						?>
						<h2><a href="<?php echo esc_url($category_link); ?>"><?php echo $category_name; ?></a></h2>
						<ul class="post-list">
							<?php
							$i = 1;
							$post_number = ta_option('blog_posts');
							$posts = new WP_Query( array('showposts' => $post_number, 'cat' => $category_id, 'post_status' => 'publish', 'post__not_in' => get_option('sticky_posts'), 'has_password' => false) );
							while( $posts->have_posts() ) : $posts->the_post();
							?>
							<li>
								<?php if ($i == 1) : ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( array('post-type-1', 'clearfix') ); ?>>
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
											<?php 
											if ( has_post_thumbnail() ) : ?>
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
												<?php the_post_thumbnail( 'feature-lg', array('class' => "img-responsive") ); ?>
											</a>
											<?php endif; ?>
										</figure>
										<div class="meta-tags">
											<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
											<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
											<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
												<?php jp_get_post_views( get_the_ID() ); ?>
											<?php endif; ?>
											<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
												<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
											<?php endif; ?>
										</div>
									</div>
									<h3><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
								</article>
								<?php else : ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( array('post-type-2', 'clearfix') ); ?>>
									<header>
										<p class="meta-tags">
											<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
											<span><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta('display_name'); ?></a></span>
											<?php if( class_exists('Jetpack') && Jetpack::is_module_active('stats') ) : ?>
												<?php jp_get_post_views( get_the_ID() ); ?>
											<?php endif; ?>
											<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
												<span><i class="fa fa-comments"></i><?php comments_popup_link('0', '1', '%'); ?></span>
											<?php endif; ?>
										</p>
										<h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
									</header>
								</article>
								<?php endif; ?>
							</li>
							<?php
							$i++;
							endwhile;
							wp_reset_query();
							?>
						</ul>
					</div>
					<?php
					$o++;
					}
					?>
				</div>
				<!-- Blog Style Content section end -->
				<?php } ?>
			</div>

			<!-- Sidebar block begin -->
			<?php get_sidebar(); ?>
			<!-- Sidebar block end -->
		</div>
	</section>

<?php get_footer(); ?>