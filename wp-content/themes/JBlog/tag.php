<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

get_header(); ?>

		<div id="jboil-page-wrapper" class="row">
			<div id="jboil-content" role="main" class="col-md-8">
                <header>
    				<h1 class="jboil-page-title"><?php
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
