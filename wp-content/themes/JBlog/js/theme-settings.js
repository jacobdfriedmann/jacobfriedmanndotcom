jQuery(document).ready(function() {

		jQuery("#color1_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color1_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});

		jQuery("#color2_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color2_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});

		jQuery("#color3_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color3_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});

		jQuery("#color4_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color4_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});
		
		jQuery("#color5_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color5_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});
	});