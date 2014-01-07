<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */

get_header(); ?>

		<div id="jblog-page-wrapper" class="search row">
			<div id="jblog-content" role="main" class="col-md-8">

			<?php if ( have_posts() ) : ?>
				<header>
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'jblog' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'jblog' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'jblog' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>


<?php get_footer(); ?>
