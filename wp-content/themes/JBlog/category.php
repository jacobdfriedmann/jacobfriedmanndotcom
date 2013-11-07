<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

get_header(); ?>
<?php $category = get_the_category(); 
$id = $category[0]->term_id;
$catName = $category[0]->name;

if ( $id == get_option('color1_cat') ) {
		$color = 'color1';
	}
	elseif ($id == get_option('color2_cat') ) {
		$color = 'color2';
	}
	elseif ($id == get_option('color3_cat') ) {
		$color = 'color3';
	}
	elseif ($id == get_option('color4_cat') ) {
		$color = 'color4';
	}
	elseif ($id == get_option('color5_cat') ) {
		$color = 'color5';
	}
?>
<script>
	jQuery(document).ready(function() {
		setCategoryHeader("<?php echo $catName; ?>", "<?php echo get_option($color); ?>");
	});
</script>
		<div id="body_wrapper" class="container_24">
			<div id="content" role="main">
				<header>
					<h1 class="page-title"><?php
						printf( __( '%s', 'jboil' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					?></h1>
				</header>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>

			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #container -->

<?php get_footer(); ?>