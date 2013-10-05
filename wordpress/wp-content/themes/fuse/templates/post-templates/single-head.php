<?php 
	global $post;
	$html_title = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'post_html_title', true);
	if (!empty($html_title)) { wpgrade_display_content($html_title); } 
?>