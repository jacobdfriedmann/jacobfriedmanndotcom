<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=body_wrapper div and all content
 * after.
 *
 * @package WordPress
 * @subpackage JBoil 
 * 
 */
?>


		
	<div id="footer_widget_wrapper">
		<div id="footer_widget_container" class="container_24">
			<div id="social_media_icons" class="">
			<?php if (get_option('facebook')) { ?>	
				<a href="http://facebook.com/<?php echo get_option('facebook'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory'); ?>/img/facebook.png" alt="facebook"/></a>
			<?php } ?>
			<?php if (get_option('twitter')) { ?>	
				<a href="http://twitter.com/<?php echo get_option('twitter'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory'); ?>/img/twitter.png" alt="twitter"/></a>
			<?php } ?>
			<?php if (get_option('linkedin')) { ?>		
				<a href="http://linkedin.com/<?php echo get_option('linkedin'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory'); ?>/img/linkedin.png" alt="linkedin"/></a>
			<?php } ?>
			</div>
			
			<div id="tagline_area" class="">
				<span id="tagline"><?php echo (get_option('tagline')) ? get_option('tagline') : bloginfo('description'); ?></span>
			</div>
		</div>
	</div>
	<div id="footer_wrapper">
		<div id="footer_container" class="container_24">
			<div id="copyright" class="">
				<?php echo get_option('copyright_text'); ?>
			</div>
			<div id="site_info" class="">
				Site designed and created by <a href="http://jacobfriedmann.com" target="_blank">Jacob Friedmann</a>
			</div>
		</div>
	</div>
		

</div><!-- #wrapper -->


<!-- Load external javascript files --!>

<!-- These help IE with html 5 and CSS 3 --!>
<script src="<?php bloginfo('template_directory'); ?>/js/modernizr.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/selectivizr.js"></script>

<!-- The jQuery UI scripts --!>
<script src="<?php bloginfo('template_directory'); ?>/js/jqueryui.js"></script>

<!-- The custom scripts stored in the js folder --!>
<script src="<?php bloginfo('template_directory'); ?>/js/scripts.js"></script>


<!-- Google analystics boilerplate. You will need to register the site and get a code. --!>
<script>
 var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
 (function(d, t) {
  var g = d.createElement(t),
      s = d.getElementsByTagName(t)[0];
  g.async = true;
  g.src = '//www.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g, s);
 })(document, 'script');
</script>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>