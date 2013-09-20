<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
	<header id="branding" class="site-header" role="banner">
			<hgroup>
				<?php //Initialize home and default options ?>
				<?php $reframe_options = get_option('reframe_home'); ?>
				<?php $default_options = get_option('reframe_options'); ?>
				<?php $reframe_logo = $reframe_options['logo']; ?>
				<?php //Assign the header image based on if it's front page and if the home image is assigned
				if ( is_front_page() and $reframe_options['home'] != '') {
					$reframe_header_image = $reframe_options['home'];
				}
				else {
						$reframe_header_image = $default_options['def_header'];
				} 

				// Assign the color of the logo text
				if ( is_front_page()) {
					$reframe_branding_color = $reframe_options['color'];
				}
				else {
					$reframe_branding_color = $default_options['color'];
				}
				if ( $reframe_branding_color != '')  {
					$reframe_branding_color = 'style="color:' . $reframe_branding_color . '"';
				}
				?>

				<?php //Logo assignment ?>
				<?php if ( $reframe_logo != '' ): ?>
					<a href="/"><img class="logo" src="<?php echo $reframe_logo; ?>" /></a>
				<?php else :?>
					<h1 id="site-title"><span><a <?php echo $reframe_branding_color; ?> href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
					<h2 id="site-description" <?php echo $reframe_branding_color; ?> ><?php bloginfo( 'description' ); ?></h2>
				<?php endif; ?>
			</hgroup>

			<?php //Display the header image based on if the option is checked to be above the menu ?>
			<?php $reframe_menu_position = $reframe_options['radio_menu']; ?>
			<?php if ( $reframe_menu_position == 1 and $reframe_header_image != '' ) : ?>
				<img class="header-img" src="<?php echo $reframe_header_image; ?>" />
			<?php endif; ?>	
<div id="navbar" class="navbar">
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<h3 class="menu-toggle"><?php _e( 'Menu', 'twentythirteen' ); ?></h3>
					<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					<?php get_search_form(); ?>
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
			
			<!--Display the header image based on if the option is checked to be below the menu. If no radio button is checked then default is below the navigation.-->
			<?php if ( $reframe_menu_position != 1 and $reframe_header_image != '' ) : ?>
				<img class="header-img" src="<?php echo $reframe_header_image; ?>" />
			<?php endif; ?>

			<!--Show the search bar in either the home or other pages only if the user selected the checkbox in the options page-->
			<?php
			if ( is_front_page() ) {
				if ( $reframe_options['search'] ) {
					get_search_form(); 
				}
			}
			elseif ( !is_front_page() and $default_options['search'] ) {
				get_search_form();
			}
				
			?>
			
	</header><!-- #branding -->

	<div id="main">
