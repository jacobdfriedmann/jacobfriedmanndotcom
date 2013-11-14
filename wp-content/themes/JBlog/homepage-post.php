<?php

$category = get_the_category();
$name =  $category[0]->term_id;
$color = hex2rgb(get_option($category[0]->slug.'_color'));

?>

<div class="jboil-post-block col-md-4" onclick="window.location.href='<?php the_permalink(); ?>'">
	<?php if (has_post_thumbnail()) { ?>
		<div class="jboil-index-thumb jboil-imgliquid">
			<?php echo the_post_thumbnail( 'large' ); ?>
		</div>
		<div class="jboil-post-block-content" style="background: rgba(<?php echo $color ?>)">
	<?php } else { ?>
		<div class="jboil-post-block-content" style="background: rgba(<?php echo $color ?>); display: block; top:0;">
	<?php } ?>
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<div class="jboil-entry">
			<?php the_excerpt(); ?>
		</div>
		<p class="jboil-post-block-category"><?php the_category(', '); ?></p>
	</div>
</div>