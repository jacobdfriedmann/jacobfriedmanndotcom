function setCategoryHeader(category, color) {
	if (category) {
		jQuery('#category_header_name').html(category);
		jQuery('#category_header_wrapper').css('background-color', color);
	}
}