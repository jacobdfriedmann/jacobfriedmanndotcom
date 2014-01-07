<?php

/**
 * The template for displaying the post area or "main message" of the homepage.
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */


?>

<?php $numposts = wp_count_posts(); ?>

<div id="jblog-page-wrapper" class="index row">
<!-- Start the Loop. -->

	<?php query_posts('posts_per_page=9'); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php jblog_printPost("homepage"); ?>
		<?php endwhile; else: ?>

		<!-- display.  This "else" part tells what do if there weren't any. -->
		<p>Sorry, no posts matched your criteria.</p>
		<!-- REALLY stop The Loop. -->

	<?php endif; ?>
	<div id="jblog-load-more-container"><A id="jblog-load-more">Load More Posts</A></div>
</div>

