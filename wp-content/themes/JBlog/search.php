<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

get_header(); ?>

		<div id="body_wrapper" class="container_24">
			<div id="content" role="main" class="grid_16">

<?php if ( have_posts() ) : ?>
				<header>
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'jboil' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>
				<?php
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
				<article id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'jboil' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'jboil' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
<?php endif; ?>
			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #container -->


<?php get_footer(); ?>
