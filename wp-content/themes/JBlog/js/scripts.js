// Globals
var page = 2;

jQuery(function() {
	// Make images responsive
	jQuery('.jboil-imgliquid').imgLiquid();
	jQuery(".jboil-imgliquid").css("visibility", "visible").hide().fadeIn("slow")
	
	// Set the page title for small screens
	var menupage = jQuery(".current-menu-item");
	if (menupage.length != 1) {
		menupage = jQuery(".current-menu-parent");
	}
	var menupagetitle = menupage.text();
	var menupagecolor = menupage.find("a").css("color");
	jQuery(".jboil-menu-page-title").text(menupagetitle);
	jQuery(".jboil-menu-page-title").css("color", menupagecolor);
	
	// Set up comment form
	jQuery(".form-submit").find("input[type=submit]").addClass("form-control btn btn-default");
	
	// Ajax to load more posts on index
	jQuery("#jboil-load-more").click(function() {
		jQuery.ajax({
			type: "GET",
			url: "/wp-admin/admin-ajax.php",
			dataType: 'html',
			data: ({ action: 'jboil_load_more', page: page }),
			success: function(data){
				var newdiv = jQuery("<div style='display:none'>"+ data + "</div>");
				jQuery('#jboil-main-message').append(newdiv);
				jQuery(newdiv).fadeIn("slow");
				if (jQuery(data).filter(".jboil-post-block").length < 9) {
					jQuery("#jboil-load-more").hide();
				}
				page++;
			}
		});
	});
});