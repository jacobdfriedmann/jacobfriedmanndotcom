<?php
/*
 * The Header for jBlog
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
	<!-- Basic indentifying Meta Tags -->
	<meta name="resource-type" content="document">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use). 
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		wp_head();
	?>
</head>
<body <?php body_class(); ?>>
<!--[if lte IE 8 ]>
<noscript><strong>JavaScript is required for this website to be displayed correctly. Please enable JavaScript before continuing...</strong></noscript>
<![endif]-->
<div id="jboil-wrapper" class="hfeed">
	<div id="jboil-header-wrapper" class="hidden-xs">
		<!-- The sites banner logo -->
		<div id="jboil-logo-wrapper" class="page-header">			<div id="jboil-logo-container">
				<a href="<?php bloginfo('wpurl') ?>"><h1 id="title"><?php echo (get_option('header_name')) ? get_option('header_name') : bloginfo('name'); ?></h1></a>
			</div>
		</div>			</div>		<div id="jboil-content-wrapper" class="container">
		<!-- The Nav Bar. In order for the Nav Bar to load properly, you must have a custom primary menu set in "Appearance" -->
		<nav id="jboil-main-navigation" class="navbar navbar-default" role="navigation">
			<div class="navbar-header">				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#jboil-main-navigation-list">					<span class="sr-only">Toggle navigation</span>					<span class="icon-bar"></span>					<span class="icon-bar"></span>					<span class="icon-bar"></span>				</button>				<h1 class="visible-xs jboil-menu-page-title"></h1>				<a class="navbar-brand" href="<?php echo bloginfo('wpurl') ?>">JF</a>			</div>						<div id="jboil-main-navigation-list" class="collapse navbar-collapse">
				<ul class="nav nav-justified">
					<?php wp_nav_menu( array( 'container' => '', 'items_wrap' => '%3$s', 'theme_location' => 'primary' ) ); ?>
				</ul>
			</div>
		</nav>
	