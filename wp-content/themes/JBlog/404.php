<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

get_header(); ?>

	<div id="body_wrapper" class="container_24">
		<div id="content" role="main" class="grid_16">

			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'Not Found', 'jboil' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'jboil' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</div><!-- #post-0 -->
		
		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #body_wrapper -->
	
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>