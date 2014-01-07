<?php

/**
 * The template for displaying posts on the homepage.
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */

$category = get_the_category();
$name =  $category[0]->term_id;
$color = hex2rgb(get_option($category[0]->slug.'_color'));

?>

<div class="jblog-post-block col-md-4" onclick="jblog.doAjax('<?php the_permalink(); ?>')">
	<?php if (has_post_thumbnail()) { ?>
		<div class="jblog-post-block-content" style="background: rgba(<?php echo $color ?>)">
	<?php } else { ?>
		<div class="jblog-post-block-content" style="background: rgba(<?php echo $color ?>); display: block; top:0;">
	<?php } ?>
			<h2 class="jblog-post-block-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="jblog-post-block-excerpt">
				<?php the_excerpt(); ?>
			</div>
			<p class="jblog-post-block-category"><?php the_category(', '); ?></p>
		</div>
	<?php if (has_post_thumbnail()) { ?>
		<div class="jblog-index-thumb jblog-imgliquid">
			<?php echo the_post_thumbnail( 'large' ); ?>
		</div>
	<?php } ?>
</div>