<?php
	
	$form_args = jboil_comment_args();
	$list_args = '';
	echo "<ul class='jboil-comment-list' >";
		wp_list_comments($list_args, get_comments('post_id='.get_the_ID()));
	echo "</ul>";
	comment_form($form_args);
	
?>