<?php
	
	$form_args = jboil_comment_args();
	$list_args = '';
	echo "<ul class='jboil-comment-list' >";
		wp_list_comments($list_args, get_comments());
	echo "</ul>";
	comment_form($form_args);
	
?>