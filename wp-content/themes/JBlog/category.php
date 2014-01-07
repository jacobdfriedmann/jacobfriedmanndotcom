<?php

/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */

get_header(); ?>
	<div id="jblog-page-wrapper" class="archive row">
		<div id="jblog-content" role="main" class="col-md-8">
			<?php
				$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo '<div class="archive-meta">' . $category_description . '</div>';

				get_template_part( 'loop', 'category' );
			?>
		</div>
		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>