<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>

	<div id="jboil-page-wrapper" class="row">
		<div id="jboil-content" role="main" class="col-md-8">
			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'Whoops!', 'jboil' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Nothing here... try a search!', 'jboil' ); ?></p>
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