<?php
/**
 * The template for displaying the footer.
 */
?>	</div> <!-- Close content wrapper -->
	<div id="jboil-footer-widget-wrapper">
				<div id="jboil-footer-widget-container" class="container">
			<div id="jboil-social-media-icons" class="row">
				<div class="col-md-2 col-lg-1 col-xs-4">					<?php if (get_option('facebook')) { ?>	
						<a href="http://facebook.com/<?php echo get_option('facebook'); ?>" target="_blank"><div class="sprite-facebook"></div></a>
					<?php } ?>				</div>				<div class="col-md-2 col-lg-1 col-xs-4">
					<?php if (get_option('twitter')) { ?>	
						<a href="http://twitter.com/<?php echo get_option('twitter'); ?>" target="_blank"><div class="sprite-twitter"></div></a>
					<?php } ?>				</div>				<div class="col-md-2 col-lg-1 col-xs-4">
					<?php if (get_option('linkedin')) { ?>		
						<a href="http://linkedin.com/<?php echo get_option('linkedin'); ?>" target="_blank"><div class="sprite-linkedin"></div></a>
					<?php } ?>				</div>
			
				<div id="jboil-tagline-area" class="col-lg-9 col-md-6 col-sm-12">
					<span id="jboil-tagline"><?php echo (get_option('tagline')) ? get_option('tagline') : bloginfo('description'); ?></span>
				</div>			</div>
		</div>
	</div>
	<div id="jboil-footer-wrapper" >
		<div id="jboil-footer-container" class="container">			<div class="row">
				<div id="jboil-copyright" class="col-md-6">
					<?php echo get_option('copyright_text'); ?>
				</div>
				<div id="jboil-site-info" class="col-md-6">
					Site designed and created by <a href="http://jacobfriedmann.com" target="_blank">Jacob Friedmann</a>
				</div>			</div>
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