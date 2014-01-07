<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>


<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<article id="post-0" class="post error404 not-found">
		<header>
			<h1 class="entry-title"><?php _e( 'Not Found', 'jblog' ); ?></h1>
		</header>

		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'jblog' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->
<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
<?php while ( have_posts() ) : the_post(); ?>

<?php /* How to display posts in the Gallery category. */ ?>

	<?php if ( in_category( _x('gallery', 'gallery category slug', 'jblog') ) ) : ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'jblog' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<p class="entry-meta">
					<?php jblog_posted_on(); ?>
				</p><!-- .entry-meta -->
			</header>

			<div class="entry-content">
<?php if ( post_password_required() ) : ?>
				<?php the_content(); ?>
<?php else : ?>
				<div class="gallery-thumb">
<?php
	$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
	$total_images = count( $images );
	$image = array_shift( $images );
	$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
?>
					<a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
				</div><!-- .gallery-thumb -->
				<p><em><?php printf( __( 'This gallery contains <a %1$s>%2$s photos</a>.', 'jblog' ),
						'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'jblog' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						$total_images
					); ?></em></p>

				<?php the_excerpt(); ?>
<?php endif; ?>
			</div><!-- .entry-content -->

			<footer class="entry-utility">
				<a href="<?php echo get_term_link( _x('gallery', 'gallery category slug', 'jblog'), 'category' ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', 'jblog' ); ?>"><?php _e( 'More Galleries', 'jblog' ); ?></a>
				<span class="meta-sep">|</span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'jblog' ), __( '1 Comment', 'jblog' ), __( '% Comments', 'jblog' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'jblog' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-utility -->
		</article><!-- #post-## -->

<?php /* How to display posts in the asides category */ ?>

	<?php elseif ( in_category( _x('asides', 'asides category slug', 'jblog') ) ) : ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'jblog' ) ); ?>
			</div><!-- .entry-content -->
		<?php endif; ?>

			<footer class="entry-utility">
				<?php jblog_posted_on(); ?>
				<span class="meta-sep">|</span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'jblog' ), __( '1 Comment', 'jblog' ), __( '% Comments', 'jblog' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'jblog' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-utility -->
		</article><!-- #post-## -->

<?php /* How to display all other posts. */ ?>

	<?php else : ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('row jblog-archive-post'); ?>>
			<?php if (has_post_thumbnail()) { ?>
				<div class="col-sm-8 col-sm-push-4 jblog-archive-detail">
			<?php } else { ?>
				<div class="col-sm-12 jblog-archive-detail jblog-no-thumb" >
			<?php } ?>
				<header>
					<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'jblog' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

					<p class="jblog-entry-meta">
						<?php jblog_posted_on(); ?>
					</p><!-- .entry-meta -->
				</header>

				<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
					<div class="jblog-archive-excerpt">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php else : ?>
					<div>
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'jblog' ) ); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'jblog' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->
				<?php endif; ?>
				
				<?php
				$category = get_the_category();
				$color =  $category[0]->slug."_color";
				 ?>

				<footer class="jblog-archive-utility">
					<?php if ( count( get_the_category() ) ) : ?>
						<span class="cat-links">
							<?php printf( __( '<span class="%1$s">Posted in</span> <span class="%3$s"> %2$s</span>', 'jblog' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ), $color ); ?>
						</span>
						<span class="meta-sep">|</span>
					<?php endif; ?>
					<?php
						$tags_list = get_the_tag_list( '', ', ' );
						if ( $tags_list ):
					?>
						<span class="tag-links">
							<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'jblog' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
						</span>
						<span class="meta-sep">|</span>
					<?php endif; ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'jblog' ), __( '1 Comment', 'jblog' ), __( '% Comments', 'jblog' ) ); ?></span>
					<?php edit_post_link( __( 'Edit', 'jblog' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-utility -->
			</div>
			<?php if (has_post_thumbnail()) { ?>
				<div class="col-sm-4 col-sm-pull-8 jblog-archive-thumb jblog-imgliquid" onclick="window.location.href='<?php the_permalink(); ?>'">
						<?php the_post_thumbnail('large'); ?>
				</div>
			<?php } ?>
		</article><!-- #post-## -->

		<?php comments_template( '', true ); ?>

	<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'jblog' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'jblog' ) ); ?></div>
				</nav><!-- #nav-below -->
<?php endif; ?>