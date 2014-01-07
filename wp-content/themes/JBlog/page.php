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
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */

get_header(); ?>
		<div id="jblog-page-wrapper" class="row pages">
			<div id="jblog-content" role="main" class="col-md-8">

				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

									<div class="entry-content">
										<?php the_content(); ?>
										<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'jblog' ), 'after' => '</div>' ) ); ?>
										<?php edit_post_link( __( 'Edit', 'jblog' ), '<span class="edit-link">', '</span>' ); ?>
									</div><!-- .entry-content -->
								</article><!-- #post-## -->

				<?php endwhile;?>

			</div>
			<?php get_sidebar(); ?>
		</div>


<?php get_footer(); ?>
