<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

get_header(); ?>
		<div id="jboil-page-wrapper" class="row">
			<div id="jboil-content" role="main" class="col-md-8">

				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

									<div class="entry-content">
										<?php the_content(); ?>
										<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'jboil' ), 'after' => '</div>' ) ); ?>
										<?php edit_post_link( __( 'Edit', 'jboil' ), '<span class="edit-link">', '</span>' ); ?>
									</div><!-- .entry-content -->
								</article><!-- #post-## -->

				<?php endwhile;?>

			</div>
			<?php get_sidebar(); ?>
		</div>


<?php get_footer(); ?>
