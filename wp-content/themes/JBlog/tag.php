<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */

get_header(); ?>

		<div id="jblog-page-wrapper" class="row">
			<div id="jblog-content" role="main" class="col-md-8">
                <header>
    				<h1 class="jblog-page-title"><?php
    					printf( __( 'Tag Archives: %s', 'jblog' ), '<span>' . single_tag_title( '', false ) . '</span>' );
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
