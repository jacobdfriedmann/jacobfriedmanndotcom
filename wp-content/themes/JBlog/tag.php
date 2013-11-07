<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

get_header(); ?>

		<div id="body_wrapper" class="container_24">
			<div id="content" role="main" class="grid_16">
                <header>
    				<h1 class="page-title"><?php
    					printf( __( 'Tag Archives: %s', 'jboil' ), '<span>' . single_tag_title( '', false ) . '</span>' );
    				?></h1>
                </header>

<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'tag' );
?>
			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #container -->


<?php get_footer(); ?>
