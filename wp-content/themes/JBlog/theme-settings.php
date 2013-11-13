<div class="wrap">
    <?php screen_icon('themes'); ?> <h2>Theme Settings</h2>
    <form method="POST" action="">
      <h3>Color Scheme</h3>
	<p class="description">Enter colors in hex form (i.e. #FFFFF). Select a category to associate the color with.</p>
        <ul id="color-scheme-list">
			<?php foreach ($categories as $category) { 
				$slug = $category->slug; 
				$name = $category->name; ?>
        	<li>
        		<label for="<?php echo $slug; ?>_color"><?php echo $name; ?> Color (Hex):</label>
        		<input type="text" name="<?php echo $slug; ?>_color" value="<?php echo get_option($slug.'_color'); ?>"/>
    		</li>
    		<?php } ?>
        </ul>

	<h3>Blog Title and Footer</h3>
	<label for="header_name">Blog Name or Logo Element: </label><input type="text" name="header_name" value="<?php echo get_option('header_name'); ?>" /><br>
	<label for="copyright_text">Copyright Text: </label><input type="text" name="copyright_text" value="<?php echo get_option('copyright_text'); ?>" /><br>
	<label for="tagline">Footer Tagline: </label><input type="text" name="tagline" value="<?php echo get_option('tagline'); ?>" /><br>
	
	<h3>Social Media Links</h3>
	<label for="facebook">facebook.com/</label><input type="text" name="facebook" value="<?php echo get_option('facebook'); ?>" /><br>
	<label for="twitter">twitter.com/</label><input type="text" name="twitter" value="<?php echo get_option('twitter'); ?>" /><br>
	<label for="linkedin">linkedin.com/</label><input type="text" name="linkedin" value="<?php echo get_option('linkedin'); ?>" /><br>
    
	<input type="hidden" name="options_updated" />

    <input type="submit" name="submit" value="Submit" class="button button-primary"/>         

</form>
</div>