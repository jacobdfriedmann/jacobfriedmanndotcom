<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */
?>

<div id="sidebar" class="widget-area" role="complementary">
	<ul>

	<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	 ?>

			<li id="search" class="widget-container widget_search">
				<?php get_search_form(); ?>
			</li>

			<li id="archives" class="widget-container">
				<?php wp_reset_postdata(); ?>
				<h3 class="widget-title">Recent Posts</h3>
				<ul class="widget_list">
					<?php get_recent_posts_list(5); ?>
					
				</ul>
			</li>

		

	<?php dynamic_sidebar( 'primary-widget-area' );  ?>
	</ul>
</div><!-- #primary .widget-area -->