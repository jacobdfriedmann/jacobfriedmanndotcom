<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

get_header(); ?>

		<div id="body_wrapper" class="container_24">
			<div id="content" role="main" class="">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<?php
							$key = 'portfolio_url';
							$themeta = get_post_meta($post->ID, $key, TRUE);
							$aend = '';
							$abegin = '';
							if($themeta != '') {
								$abegin = '<a href="'.$themeta.'" target="_blank">';								
								$aend = '</a>';
							}
							?>
				<div id="post_image_container">
					<?php echo $abegin; ?><?php echo the_post_thumbnail('single'); ?><?php echo $aend; ?>
				</div>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header>
						
						<?php echo $abegin; ?><h1 class="entry-title"><?php the_title(); ?></h1><?php echo $aend; ?>

						<p class="entry-meta">
							<?php jboil_posted_on(); ?>
						</p><!-- .entry-meta -->
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'jboil' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
					<footer id="entry-author-info">
						<div id="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'jboil_author_bio_avatar_size', 60 ) ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							<h2><?php printf( esc_attr__( 'About %s', 'jboil' ), get_the_author() ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
							<div id="author-link">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
									<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'jboil' ), get_the_author() ); ?>
								</a>
							</div><!-- #author-link	-->
						</div><!-- #author-description -->
					</footer><!-- #entry-author-info -->
<?php endif; ?>

					<footer class="entry-utility">
						<?php jboil_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'jboil' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-utility -->
				</article><!-- #post-## -->

				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'jboil' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'jboil' ) . '</span>' ); ?></div>
				</nav><!-- #nav-below -->

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
<?php endwhile; // end of the loop. ?>
<?php comments_template( '', true ); ?>
			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #container -->



<?php get_footer(); ?>