<?php
/*
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up until <div id="main">
 *
 * @package WordPress
 * @subpackage JBoil 
 * 
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>

<!-- Basic indentifying Meta Tags --!>
<meta name="resource-type" content="document">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<link rel="profile" href="http://gmpg.org/xfn/11" />

<!-- Font stylesheets that are used in style.css --!>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fonts/stylesheet.css" />

<!-- Other external stylesheets. These load in the 960 grid system and the jQuery UI interface system. --!>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/960_24_col.css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/jqueryui.css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/custom-style.php" />

<!-- Loads our primary external stylesheet style.css --!>
<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9/jquery.min.js"><\/script>
<script>window.jQuery || document.write('<script src="/wp-content/themes/jboil/js/jquery.js"><\/script>')</script>
</head>

<body <?php body_class(); ?>>
<!--[if lte IE 8 ]>
<noscript><strong>JavaScript is required for this website to be displayed correctly. Please enable JavaScript before continuing...</strong></noscript>
<![endif]-->

<div id="wrapper" class="hfeed">
	
	<div id="header_wrapper">
		
		<!-- The sites banner logo --!>
		<div id="logo_wrapper">
		<div id="logo_container" class="container_24">
			<a href="<?php bloginfo('wpurl') ?>"><h1 id="title"><?php echo (get_option('header_name')) ? get_option('header_name') : bloginfo('name'); ?></h1></a>
		</div>
		</div>
		<div id="category_header_wrapper">
			<div id="category_header_container" class="container_24">
				<h2 id="category_header_name"></h2>
			</div>
		</div>
		
		<!-- The Nav Bar. In order for the Nav Bar to load properly, you must have a custom primary menu set in "Appearance" --!>
		<div id="main_nav_container" class="container_24">
		<div id="main_nav" role="navigation" >
			<ul>
				<?php wp_nav_menu( array( 'container' => '', 'items_wrap' => '%3$s', 'theme_location' => 'primary' ) ); ?>
				<li class="filler"></li>
			</ul>
		</div>
		</div>
		
	</div>