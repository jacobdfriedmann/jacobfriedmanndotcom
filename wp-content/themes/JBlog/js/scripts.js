// Globals
var page = 2;

jQuery(function() {
	// Make images responsive
	jQuery('.jboil-imgliquid').imgLiquid();
	jQuery(".jboil-imgliquid").css("visibility", "visible").hide().fadeIn("slow");
	
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
				jboilInit();
				jQuery(".jboil-imgliquid").filter(function (index) { return jQuery(this).css('visibility') == 'hidden' }).imgLiquid().css("visibility", "visible").hide().fadeIn("slow");
				if (jQuery(data).filter(".jboil-post-block").length < 9) {
					jQuery("#jboil-load-more").hide();
				}
				page++;
			}
		});
	});
	
	
	
	// For small devices show postblock text when in optimal reading space
	function setOpacity(className, height) {
		var scrollTop = jQuery(window).scrollTop();
		if (!scrollTop) {
			scrollTop = 0;
		}
		jQuery(className).each(function() {
			var postOffset = jQuery(this).offset().top;
			var distance = postOffset - scrollTop;
			if (distance > 0) {
				jQuery(this).css("opacity", (height/distance));
			}
			else {
				jQuery(this).css("opacity", 1);
			}
		});
	}
	
	// Functions for making text more readable on overlays
	function rgb2hsv () {
		var rr, gg, bb,
			r = arguments[0] / 255,
			g = arguments[1] / 255,
			b = arguments[2] / 255,
			h, s,
			v = Math.max(r, g, b),
			diff = v - Math.min(r, g, b),
			diffc = function(c){
				return (v - c) / 6 / diff + 1 / 2;
			};

		if (diff == 0) {
			h = s = 0;
		} else {
			s = diff / v;
			rr = diffc(r);
			gg = diffc(g);
			bb = diffc(b);

			if (r === v) {
				h = bb - gg;
			}else if (g === v) {
				h = (1 / 3) + rr - bb;
			}else if (b === v) {
				h = (2 / 3) + gg - rr;
			}
			if (h < 0) {
				h += 1;
			}else if (h > 1) {
				h -= 1;
			}
		}
		return {
			h: Math.round(h * 360),
			s: Math.round(s * 100),
			v: Math.round(v * 100)
		};
	}
	
	function setTextColor(className, small) {
		jQuery(className).each(function() {
			var rgb = jQuery(this).css("background-color");
			rgb = rgb.substring(5, rgb.length-1).replace(/ /g, '').split(',');
			for (var i = 0; i <3; i++) { 
				rgb[i] = parseInt(rgb[i]); 
			}
			if (rgb2hsv(rgb[0], rgb[1], rgb[2]).v < 50) {
				if (small) {
					jQuery(this).addClass("jboil-white");
				}
				else {
					jQuery(this).removeClass("jboil-white");
				}
			} else {
				if (small) {
					jQuery(this).addClass("jboil-black");
				}
				else {
					jQuery(this).removeClass("jboil-black");
				}
			}
		});
	}
	
	// Truncate excerpts 
	
	function jboilTruncate(className, length) {
		jQuery(className).each(function() {
			var contents = jQuery(this).find("p").contents();
			var link;
			var excerpt = jQuery(contents[0]).text();
			if (contents.length == 3) {
				var hiddenExcerpt = contents[1];
				link = contents[2];
				excerpt = excerpt + jQuery(hiddenExcerpt).text();
			} else {
				link = contents[1];
			}
			excerpt = excerpt.replace(/\s+/g, " ");
			var excerptArray = excerpt.split(" ");
			excerptArray.splice(length, 0, "<span style='display:none;'>");
			excerptArray.push("</span>");
			excerpt = excerptArray.join(" ");
			jQuery(this).html("<p>" + excerpt + "</p>").find("p").append(link);
		})
	}
	
	// Handle Window Resize and Scroll
	function jboilChange() {
		var smallWindow;
		// xs
		if (window.innerWidth < 768) {
			smallWindow = true;
			setOpacity(".jboil-post-block-content", 150);
			setOpacity(".jboil-archive-detail", 150);
			jboilTruncate(".jboil-entry", Math.round(window.innerWidth/10));
			jboilTruncate(".jboil-archive-excerpt", Math.round(window.innerWidth/15));
		}
		// sm
		else if (window.innerWidth >= 768 && window.innerWidth < 992){
			smallWindow = false;
			setOpacity(".jboil-post-block-content", 300);
			setOpacity(".jboil-archive-detail", 300);
			jboilTruncate(".jboil-entry", 80);
			jboilTruncate(".jboil-archive-excerpt", 35);
		}
		// md
		else if (window.innerWidth >= 992 && window.innerWidth < 1200) {
			jboilTruncate(".jboil-entry", 25);
			jboilTruncate(".jboil-archive-excerpt", 35);
			jQuery(".jboil-post-block-content").css("opacity", "");
			setOpacity(".jboil-archive-detail", 300);
		}
		// lg
		else if (window.innerWidth >= 1200) {
			jboilTruncate(".jboil-entry, .jboil-archive-excerpt", 45);
			jQuery(".jboil-post-block-content").css("opacity", "");
			setOpacity(".jboil-archive-detail", 300);
		}
		setTextColor(".jboil-archive-detail:not(.jboil-no-thumb)", smallWindow);
	}
	
	function jboilInit() {
		setTextColor(".jboil-post-block-content", true);
		jboilChange();
	}
	
	jQuery(window).resize(function() {jboilChange()});
	jQuery(window).scroll(function() {jboilChange()});
	
	// Do it!
	jboilInit();
	jQuery("#jboil-content").css("visibility", "visible").hide().fadeIn("slow");
});