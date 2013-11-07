<?php
/**
 * Template Name: One column, no sidebar
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

get_header(); ?>

		<div id="body_wrapper" class="container_24">
			<div id="big-content" role="main" class="grid_24">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					
					</div><!-- .entry-content -->
				</article><!-- #post-## -->

				<?php comments_template( '', true ); ?>

<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #body_wrapper -->

<?php get_footer(); ?>
