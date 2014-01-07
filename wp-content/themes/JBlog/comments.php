<?php
/**
 * The template for displaying comments.
 *
 * @package WordPress
 * @subpackage JBlog
 * @since JBlog 1.0
 * 
 */
	
	$form_args = jblog_comment_args();
	$list_args = '';
	echo "<ul class='jblog-comment-list' >";
		wp_list_comments($list_args, get_comments(array('post_id'=>get_the_ID(),'status'=>'approve')));
	echo "</ul>";
	comment_form($form_args);
	
?>