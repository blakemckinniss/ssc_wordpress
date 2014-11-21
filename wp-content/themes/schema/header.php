<!DOCTYPE html>
<?php $mts_options = get_option(MTS_THEME_NAME);
	  $header_class = $mts_options['mts_header_style']; 
?>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<?php mts_meta(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body id ="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">
	<div class="main-container-wrap">
		<header class="main-header <?php echo $header_class; ?>" role="banner" itemscope itemtype="http://schema.org/WPHeader">
			<?php if($mts_options['mts_show_primary_nav'] == '1') { ?>
				<div id="primary-nav">
					<div class="container">
				        <div class="primary-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
				    		<nav id="navigation" class="clearfix">
				    			<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
				    				<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) ); ?>
				    			<?php } else { ?>
				    				<ul class="menu clearfix">
				    					<?php wp_list_pages('title_li='); ?>
				    				</ul>
				    			<?php } ?>
				    		</nav>
				            <?php if($mts_options['mts_header_social_icons'] == '1') { ?>
					            <div class="header-social-icons">
						            <?php if($mts_options['mts_twitter_username'] != '') { ?>
										<a href="http://twitter.com/<?php echo $mts_options['mts_twitter_username']; ?>" class="mts-twitter-icon"><i class="fa fa-twitter"></i></a>
									<?php } ?>
									<?php if($mts_options['mts_facebook_username'] != '') { ?>
										<a href="<?php echo $mts_options['mts_facebook_username']; ?>" class="mts-fb-icon"><i class="fa fa-facebook"></i></a>
									<?php } ?>
									<?php if($mts_options['mts_gplus_username'] != '') { ?>
										<a href="<?php echo $mts_options['mts_gplus_username']; ?>" class="mts-linkedin-icon"><i class="fa fa-google-plus"></i></a>
									<?php } ?>
									<?php if($mts_options['mts_pinterest_username'] != '') { ?>
										<a href="<?php echo $mts_options['mts_pinterest_username']; ?>" class="mts-pinterest-icon"><i class="fa fa-pinterest"></i></a>
									<?php } ?>
									<?php if($mts_options['mts_header_feed_icon'] == '1') { ?>
										<a href="<?php echo $mts_options['mts_feedburner']; ?>" class="mts-feedburner-icon"><i class="fa fa-rss"></i></a>
									<?php } ?>
								</div>
							<?php } ?>
							<?php mts_cart(); ?>
				    	</div>
				    </div>
			    </div>
			<?php } ?>
		    <?php if ($mts_options['mts_header_style'] == 'regular_header') { ?>
			    <div id="regular-header">
			    	<div class="container">
						<div class="logo-wrap">
							<?php if ($mts_options['mts_logo'] != '') { ?>
								<?php if( is_front_page() || is_home() || is_404() ) { ?>
										<h1 id="logo" class="image-logo" itemprop="headline">
											<a href="<?php echo home_url(); ?>"><img src="<?php echo $mts_options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
										</h1><!-- END #logo -->
								<?php } else { ?>
									  <h2 id="logo" class="image-logo" itemprop="headline">
											<a href="<?php echo home_url(); ?>"><img src="<?php echo $mts_options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
										</h2><!-- END #logo -->
								<?php } ?>
							<?php } else { ?>
								<?php if( is_front_page() || is_home() || is_404() ) { ?>
										<h1 id="logo" class="text-logo" itemprop="headline">
											<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
										</h1><!-- END #logo -->
								<?php } else { ?>
									  <h2 id="logo" class="text-logo" itemprop="headline">
											<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
										</h2><!-- END #logo -->
								<?php } ?>
							<?php } ?>
						</div>
						<?php if($mts_options['mts_header_adcode'] != '') { ?>
							<div class="widget-header"><?php echo $mts_options['mts_header_adcode']; ?></div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<?php if($mts_options['mts_sticky_nav'] == '1') { ?>
				<div class="clear" id="catcher"></div>
				<div id="header" class="sticky">
			<?php } else { ?>
				<div id="header">
			<?php } ?>
				<div class="container">
					<?php if ($mts_options['mts_header_style'] == 'logo_in_nav_header') { ?>
						<div class="logo-wrap">
							<?php if ($mts_options['mts_logo'] != '') { ?>
								<?php if( is_front_page() || is_home() || is_404() ) { ?>
										<h1 id="logo" class="image-logo" itemprop="headline">
											<a href="<?php echo home_url(); ?>"><img src="<?php echo $mts_options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
										</h1><!-- END #logo -->
								<?php } else { ?>
									  <h2 id="logo" class="image-logo" itemprop="headline">
											<a href="<?php echo home_url(); ?>"><img src="<?php echo $mts_options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
										</h2><!-- END #logo -->
								<?php } ?>
							<?php } else { ?>
								<?php if( is_front_page() || is_home() || is_404() ) { ?>
										<h1 id="logo" class="text-logo" itemprop="headline">
											<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
										</h1><!-- END #logo -->
								<?php } else { ?>
									  <h2 id="logo" class="text-logo" itemprop="headline">
											<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
										</h2><!-- END #logo -->
								<?php } ?>
							<?php } ?>
						</div>
					<?php } ?>
					<div class="secondary-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
						<nav id="navigation" class="clearfix">
							<?php if ( has_nav_menu( 'secondary-menu' ) ) { ?>
								<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) ); ?>
							<?php } else { ?>
								<ul class="menu clearfix">
									<li class="menu-item pull"><a href="#" id="pull" class="toggle-mobile-menu"><?php _e('Menu','mythemeshop'); ?></a></li>
									<?php wp_list_categories('title_li='); ?>
								</ul>
							<?php } ?>
						</nav>
					</div>              
				</div><!--#header-->
			</div>
		</header>
		<div class="main-container">