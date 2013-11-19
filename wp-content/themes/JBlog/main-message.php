<?php
/**
 * This is the main page "message".
 *
 */
?>
<?php $numposts = wp_count_posts(); ?>
<div id="jboil-page-wrapper" class="index row">
<!-- Start the Loop. -->
	<?php query_posts('posts_per_page=9'); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php jboil_printPost("homepage"); ?>
		<?php endwhile; else: ?>
		<!-- display.  This "else" part tells what do if there weren't any. -->
		<p>Sorry, no posts matched your criteria.</p>
		<!-- REALLY stop The Loop. -->
	<?php endif; ?>
</div>
<div id="jboil-load-more-container"><A id="jboil-load-more">Load More Posts</A></div>