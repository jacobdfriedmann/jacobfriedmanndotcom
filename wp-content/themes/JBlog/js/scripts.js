
var jboil = window.jboil = {
	
	page: 2, // Next page of posts to be queried 
	
	screenSize: "", // xs(<768), sm(>=768 && <992), md(>=992 && <1200), lg(>1200)
	
	deviceType: "", // desktop or mobile
	
	pageType: "", // index, page, post, archive
	
	postClassName: "", // .jboil-post-block-content, .jboil-archive-detail
	
	excerptClassName: "", // .jboil-entry, .jboil-archive-excerpt
	
	getScreenSize: function () { // Determine current screen size
		var size;
		if (window.innerWidth < 768) {
			size = "xs";
		}
		else if (window.innerWidth >= 768 && window.innerWidth < 992){
			size = "sm";
		}
		else if (window.innerWidth >= 992 && window.innerWidth < 1200) {
			size = "md";
		}
		else if (window.innerWidth >= 1200) {
			size = "lg";
		}
		return size;
	},
	
	getDeviceType: function () { // Determine mobile or desktop
		var device;
		if ((/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)) {
			device = "mobile";
		}
		else {
			device = "desktop";
		}
		return device;
	},
	
	getPageType: function () { // Determine what kind of wordpress page we are on
		var body = jQuery("#jboil-page-wrapper");
		var page;
		if (body.hasClass("index")) {
			page = "index";
		}
		else if (body.hasClass("page")) {
			page = "page";
		}
		else if (body.hasClass("archive") || body.hasClass("search")) {
			page = "archive";
		}
		else {
			page = "single";
		}
		return page;
	},
	
	getPostClassName: function () { // Determine the post's content class name
		var className;
		if (this.pageType == "archive") {
			className = ".jboil-archive-detail";
		}
		else if (this.pageType == "index") {
			className = ".jboil-post-block-content";
		}
		return className;
	},
	
	getExcerptClassName: function () { // Determine the post's content class name
		var className;
		if (this.pageType == "archive") {
			className = ".jboil-archive-excerpt";
		}
		else if (this.pageType == "index") {
			className = ".jboil-post-block-excerpt";
		}
		return className;
	},
	
	crossedBreakpoint: function () { // Determine if window has crossed a Bootstrap breakpoint
		return (this.deviceType == "desktop" && this.screenSize != this.getScreenSize);
	},
	
	loadMorePosts: function () { // Load more posts on index using an ajax call
		var context = this;
		jQuery.ajax({
			type: "GET",
			url: "/wp-admin/admin-ajax.php",
			dataType: 'html',
			data: ({ action: 'jboil_load_more', page: this.page }),
			success: function(data){
				var newdiv = jQuery("<div style='display:none'>"+ data + "</div>");
				jQuery('#jboil-page-wrapper').append(newdiv);
				jQuery(newdiv).fadeIn("slow");
				context.refresh();
				jQuery(".jboil-imgliquid").filter(function (index) { return jQuery(this).css('visibility') == 'hidden' }).imgLiquid().css("visibility", "visible").hide().fadeIn("slow");
				if (jQuery(data).filter(".jboil-post-block").length < 9) {
					jQuery("#jboil-load-more").hide();
				}
				context.page++;
			}
		});
	},
	
	rgb2hsv: function() { // Turn an array of rgb's to a object of hsv's
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
	},
	
	setBlockTextColor: function() { // Set block's foreground text color based on background color
		var className = this.postClassName;
		var context = this;
		if (className) {
			jQuery(className).each(function() {
				var rgb = jQuery(this).css("background-color");
				rgb = rgb.substring(5, rgb.length-1).replace(/ /g, '').split(',');
				for (var i = 0; i <3; i++) { 
					rgb[i] = parseInt(rgb[i]); 
				}
				if (context.rgb2hsv(rgb[0], rgb[1], rgb[2]).v < 50) {
					jQuery(this).addClass("jboil-white");
				} 
				else {
					jQuery(this).addClass("jboil-black");
				}
			});
		}
	},
	
	removeBlockTextColor: function() {
		if (this.postClassName == ".jboil-archive-detail") {
			jQuery(".jboil-white").removeClass("jboil-white");
			jQuery(".jboil-black").removeClass("jboil-black");
		}
	},
	
	affixSidebar: function() {
		if (jQuery("#jboil-content").height() >= jQuery("#jboil-sidebar>div").height()) {
			jQuery("#jboil-sidebar>div").affix({
				offset: {
					bottom: 250
				}
			})
		}
	},
		
	truncate: function() { // Truncates Excerpt to specific length
		var length = arguments[0];
		if (this.excerptClassName) {
			jQuery(this.excerptClassName).each(function() {
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
			});
		}
	},
	
	ajaxify: function () {
		var className = arguments[0];
		var context = this;
		jQuery(className).click( function(e) {

			e.preventDefault();
			var urlPath = jQuery(this).attr("href");
			var url = urlPath + " #jboil-page-wrapper";
			var curtain = jQuery("#jboil-curtain");
			var content = jQuery("#jboil-content-wrapper");
			curtain
				.css("top", content.position().top)
				.css("left", content.position().left)
				.width(content.width())
				.height(content.height());
			content.animate({"opacity": 0}, 600, function () { curtain.show(); } );
			if (jboil.screenSize == "xs") jQuery("#jboil-main-navigation-list").collapse("hide");
			jQuery(".jboil-menu-page-title").animate({"opacity":0}, 1000);
			jQuery("#jboil-content-wrapper").load(url, function(response) {
				var title = jQuery(response).find("title").text();
				var menupage = jQuery(response).find(".current-menu-item").attr("id");
				if (!menupage) {
					menupage = jQuery(response).find(".current-menu-parent").attr("id");
				}
				jQuery("title").text(title);
				jQuery(".current-menu-item, .current-menu-parent").removeClass("current-menu-item").removeClass("current-menu-parent");
				jQuery("#"+menupage).addClass("current-menu-item");
				window.history.pushState({"html":response,"pageTitle":title},"", urlPath);
				jQuery(".jboil-menu-page-title").stop(false, true);
				jQuery.proxy(jboil.init(true), jboil);
				jQuery(".jboil-menu-page-title").animate({"opacity":1}, 1000);
				window.scrollTo(0);
				content.stop().animate({"opacity":1}, 600, function () { curtain.hide(); });
				context.affixSidebar();
			});
		});
	},
	
	makePostsMobile: function () {
		if (this.pageType == "index") {
			jQuery(".jboil-post-block-content").css("opacity", 1).css("height", "auto").css("padding-bottom", 0);
			jQuery(".jboil-post-block-title").css("display", "inline-block").css("margin-top", "7px");
			jQuery(".jboil-post-block-excerpt, .jboil-post-block-category").css("display", "none");
			jQuery(".jboil-index-thumb").each( function () {
				jQuery(this).css("top", "-" + jQuery(this).siblings(".jboil-post-block-content")[0].clientHeight + "px");
			});
		}
		else if (this.pageType == "archive" && this.screenSize == "xs") {
			jQuery(".jboil-archive-detail").css("opacity", 1).css("padding-bottom", 0).css("height", "auto");
			jQuery(".jboil-archive-detail h2").css("display", "inline-block").css("margin-top", "7px");
			jQuery(".jboil-entry-meta, .jboil-archive-excerpt, .jboil-archive-utility").css("display", "none");
			jQuery(".jboil-archive-thumb").each( function () {
				jQuery(this).css("top", "-" + jQuery(this).siblings(".jboil-archive-detail")[0].clientHeight + "px");
			});
		}
	},
	
	fixBodyPadding: function() {
		jQuery("body").css("padding-top", jQuery("#jboil-header-wrapper").height() -jQuery("body").offset().top -10);
	},
	
	init: function (ajax) { // initialize a page
		
		// Things we do on all pages
		if (!ajax) {			
		
			jQuery("#wpadminbar").hide();
			
			// Make top navigation ajax calls
			this.ajaxify(".menu-item a");
			
			// Fix Sidebar
			this.affixSidebar();
		}
		
		this.fixBodyPadding();
		
		this.ajaxify(".widget_jboil_recentposts_widget a");
			
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
		
		// Initialize instance variables
		this.screenSize = this.getScreenSize();
		this.pageType = this.getPageType();
		this.deviceType = this.getDeviceType();
		this.postClassName = this.getPostClassName();
		this.excerptClassName = this.getExcerptClassName();
		
		// Logic for single posts
		if (this.pageType == "single") {
			// Set up comment form
			jQuery(".form-submit").find("input[type=submit]").addClass("form-control btn btn-default");
			jQuery(window).resize(function () {
				jboil.fixBodyPadding();
			});
		}
		// Logic for static page
		else if (this.pageType == "page") {
			jQuery(window).resize(function () {
				jboil.fixBodyPadding();
			});
		}
		// Logic for index
		else if (this.pageType == "index") {
			this.refresh();
			var context = this;
			jQuery("#jboil-load-more").click(function() {
				context.loadMorePosts();
			});
			jQuery(window).resize(function () {
				context.fixBodyPadding();
				context.refresh();
			});
		}
		// Logic for archive pages
		else if (this.pageType == "archive") {
			this.refresh();
			var context = this;
			jQuery(window).resize(function () {
				context.fixBodyPadding();
				context.refresh();
			});
		}
		// Fade in content for it is loaded
		jQuery("#jboil-content").css("visibility", "visible").hide().fadeIn("slow");
	},
	
	refresh: function() {
		// Mobile refresh
		if (this.deviceType == "mobile") {
			if (this.screenSize == "xs") {
				this.makePostsMobile();
				this.setBlockTextColor();
			}
			else if (this.screenSize == "sm" || this.screenSize == "md") {
				if (this.pageType == "archive") {
					this.truncate(35);
				}
				else if (this.pageType == "index") {
					this.makePostsMobile();
					this.setBlockTextColor();
				}
			}
		}
		// Desktop refresh
		else {	
			this.screenSize = this.getScreenSize();
			if (this.pageType == "index") {
				this.setBlockTextColor();
			}
			if (this.screenSize == "xs") {
				this.truncate(Math.round(window.innerWidth/10));
				this.setBlockTextColor();
			}
			else if (this.screenSize == "sm") {
				if (this.pageType == "index") {
					this.truncate(80);
				}
				else {
					this.truncate(35);
					this.removeBlockTextColor();
				}
			}
			else if (this.screenSize == "md") {
				if (this.pageType == "index") {
					this.truncate(25);
				}
				else {
					this.truncate(35);
				}
			}
			else {
				this.truncate(45);
			}
		}
	}
}

jQuery(function() {
	jboil.init();
});