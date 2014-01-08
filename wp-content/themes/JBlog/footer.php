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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46962164-1', 'jacobfriedmann.com');
  ga('send', 'pageview');

</script>

<?php
	wp_footer();
?>

</body>
</html>