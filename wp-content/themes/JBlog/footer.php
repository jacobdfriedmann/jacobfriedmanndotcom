<?php

/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */

?>	
</div> <!-- Close content wrapper -->
<div id="jblog-curtain">
</div>
	<div id="jblog-footer-widget-wrapper">
		
		<div id="jblog-footer-widget-container" class="container">
			<div id="jblog-social-media-icons" class="row">
				<div class="col-md-2 col-xs-4">
					<?php if (get_option('github')) { ?>	
						<a href="http://github.com/<?php echo get_option('github'); ?>" target="_blank"><div class="fa fa-github"></div></a>
					<?php } ?>
				</div>
				<div class="col-md-2 col-xs-4">
					<?php if (get_option('twitter')) { ?>	
						<a href="http://twitter.com/<?php echo get_option('twitter'); ?>" target="_blank"><div class="fa fa-twitter"></div></a>
					<?php } ?>
				</div>
				<div class="col-md-2 col-xs-4">
					<?php if (get_option('linkedin')) { ?>		
						<a href="http://linkedin.com/<?php echo get_option('linkedin'); ?>" target="_blank"><div class="fa fa-linkedin"></div></a>
					<?php } ?>
				</div>
			

				<div id="jblog-tagline-area" class="col-md-6 col-sm-12">
					<span id="jblog-tagline"><?php echo (get_option('tagline')) ? get_option('tagline') : bloginfo('description'); ?></span>
				</div>
			</div>
		</div>

	</div>

	<div id="jblog-footer-wrapper" >
		<div id="jblog-footer-container" class="container">
			<div class="row">
				<div id="jblog-copyright" class="col-md-6">
					<?php echo get_option('copyright_text'); ?>
				</div>
				<div id="jblog-site-info" class="col-md-6">
					Site designed and created by <a href="http://jacobfriedmann.com" target="_blank">Jacob Friedmann</a>
				</div>
			</div>
		</div>
	</div>

</div><!-- #wrapper -->

<!-- Google analystics boilerplate. You will need to register the site and get a code. -->

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
	wp_footer();
?>

</body>
</html>