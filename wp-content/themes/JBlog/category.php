<?php
/**
 * The template for displaying Category Archive pages.
 */
get_header(); ?>
	<div id="jboil-page-wrapper" class="archive row">
		<div id="jboil-content" role="main" class="col-md-8">
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