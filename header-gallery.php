<?php
/**
 * The Default Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!-- jQuery library (served from Google) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="<?php echo get_stylesheet_directory_uri() ?>/js/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="<?php echo get_stylesheet_directory_uri() ?>/lib/jquery.bxslider.css" rel="stylesheet" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
	<header id="branding" role="banner">
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
<nav  id="access" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></h3>
				<?php /* Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
				<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
				<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
				<?php /* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */ ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #access -->
			
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
