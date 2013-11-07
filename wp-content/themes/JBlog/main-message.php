<?php
/**
 * This is the main page "message".
 *
 * @package WordPress
 * @subpackage JBoil 
 * 
 */
?>
<?php $numposts = wp_count_posts(); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {

        posts = 9;
        author_posts = parseInt(<?php echo $numposts->publish; ?>);

        jQuery("#load-more").click(function() {


            if ((posts - author_posts) > 0) {
                jQuery("#load-more").text('');
            }
            else {

                jQuery.ajax({
                    type: "GET",
                    url: "<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php",
                    dataType: 'html',
                    data: ({ action: 'loadMore', posts: posts }),
                    success: function(data){
                        jQuery('#main_message').hide().fadeIn('slow').html(data);
                        posts = posts + 3;

                        if ((posts - author_posts) > 0) {
                            jQuery("#load-more").text('');
                        }

                    }
                });
            }

        });
    });

</script>    

<div id="main_message">

<!-- Start the Loop. -->
<?php query_posts('posts_per_page=9'); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php $category = get_the_category();
$name =  $category[0]->term_id;
if ($name == get_option('color1_cat')) {
	$color = 'color1';
}
elseif ($name == get_option('color2_cat')) {
	$color = 'color2';
}
elseif ($name == get_option('color3_cat')) {
	$color = 'color3';
}
elseif ($name == get_option('color4_cat')) {
	$color = 'color4';
}
else {
	$color = 'color5';
}
 ?>


<div class="post_block <?php echo $color; ?>" onclick="window.location.href='<?php the_permalink(); ?>'">

<?php if (has_post_thumbnail()) {
	echo the_post_thumbnail( 'post_block' ); ?>
	<div class="post_block_content">
	<?php }
      else {
?>	<div class="post_block_content" style="display:block;">
<?php } ?>

 <!-- Display the Title as a link to the Post's permalink. -->
 
 

 <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>





 <!-- Display the Post's content in a div box. -->

 <div class="entry">
   <?php the_excerpt(); ?>
 </div>


 <!-- Display a comma separated list of the Post's Categories. -->

 <p class="post_block_category"><?php the_category(', '); ?></p>
 </div> <!-- closes the first div box --></a>


 <!-- Stop The Loop (but note the "else:" - see next line). -->
</div>
 <?php endwhile; else: ?>


 <!-- The very first "if" tested to see if there were any Posts to -->
 <!-- display.  This "else" part tells what do if there weren't any. -->
 <p>Sorry, no posts matched your criteria.</p>


 <!-- REALLY stop The Loop. -->
 <?php endif; ?>
 
 </div>
<div id="load-more-container"><A id="load-more">Load More Posts</A></div>