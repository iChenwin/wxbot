<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package TA Magazine
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php $fav = ta_option('custom_favicon', false, 'url'); ?>
<?php if ($fav !== '') { ?>
<link rel="icon" type="image/png" href="<?php echo ta_option('custom_favicon', false, 'url'); ?>" />
<?php } ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="sr-only" href="#content"><?php _e( 'Skip to content', 'ta-magazine' ); ?></a>

	<?php if ( ta_option('disable_header_info') =='1' ) { ?>
	<div class="head-news container">
		<!-- News block begin -->
		<header><p><i class="fa fa-bullhorn"></i><?php if ( ta_option('header_info_title') != '') : echo ta_option('header_info_title'); ?><?php endif; ?></p></header> 
		<div class="content-news">
			<p><?php if ( ta_option('header_info') != '') : echo ta_option('header_info'); ?><?php endif; ?></p>
		</div>
		<!-- News block end -->

		<!-- Search-form begin -->	
		<div id="search" class="dropdown search">
			<a role="button" data-toggle="dropdown" data-target="#" href="#" onclick="return false">
				<i class="fa fa-search"></i>
			</a>
			<ul class="dropdown-menu" role="menu">
				<li>
					<form method="get" class="navbar-search pull-left input-group" action="<?php echo home_url( '/' ); ?>">
						<input type="text" class="form-control search-query" name="s" placeholder="<?php _e('Type and hit enter', 'ta-magazine'); ?>" />
						<div class="input-group-btn">
							<button class="btn btn-defaul" type="submit"><i class="fa fa-search"></i></button> 
						</div>
					</form>
				</li>
			</ul>
		</div> 
		<!-- Search-form end -->
	</div>
	<?php } ?>

	<header id="masthead" class="site-header header-block" role="banner">
		<div class="container">
			<div class="header-top">
				<!-- Logo -->
				<div class="logo">
				<?php $logo = ta_option( 'custom_logo', false, 'url' ); ?>
				<?php if( $logo !== '' ) { ?>
					<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img class="img-responsive" src="<?php echo $logo ?>" alt="Logo" title="<?php bloginfo('description') ?>"></a></h1>
				<?php } else { ?>
					<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo('description') ?>"><?php bloginfo('name'); ?></a></h1>
				<?php } ?>
				</div>

				<?php if ( ta_option('disable_header_ad') =='1' && ta_option('ad_header') != '' ) { ?>
				<!-- Header advertise -->
				<figure class="header-adv">
					<?php echo ta_option('ad_header'); ?>
				</figure>
				<?php } ?>

				<?php if ( ta_option('disable_header_social') =='1' ) { ?>
				<!-- We are in social nets -->
				<div class="social-icons">
					<ul>
						<?php $social_options = ta_option('social_icons'); ?>
						<?php foreach ($social_options as $key => $value) {
							if ($value && $key == 'Google Plus') { ?>
						<li>
							<a href="<?php echo $value; ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $key; ?>"><i class="fa fa-<?php echo strtolower( strtr($key, " ", "-") ); ?>"></i></a>
						</li>
						<?php } elseif ( $value ) { ?>
						<li>
							<a href="<?php echo $value; ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $key; ?>"><i class="fa fa-<?php echo strtolower($key); ?>"></i></a>
						</li>
						<?php }
					} ?>
					</ul>
				</div>
				<?php } ?>

				<?php if ( ta_option('disable_login') =='1' ) { ?>
				<!-- Member area -->
				<div class="member-area">
					<ul>
						<li>
							<a href="<?php echo wp_registration_url(); ?>"><i class="fa fa-plus"></i><?php _e('Register', 'ta-magazine'); ?></a>
						</li>
						<li>
							<a href="<?php echo wp_login_url(); ?>"><i class="fa fa-user"></i><?php _e('Login', 'ta-magazine'); ?></a>
						<li>
					</ul>
				</div>
				<?php } ?>

				<div class="clearfix"></div>
			</div>

			<!-- Navigation -->
			<nav  class="mainmenu navbar navbar-default" role="navigation">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_id'        => 'nav',
					'menu_class'     => 'nav nav-tabs'
					)
				);
				?>
			</nav>
		</div><!-- .container -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">