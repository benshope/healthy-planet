<?php 
	global $post;
	//$html_title = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'post_html_title', true);
	$video_embed = get_post_meta($post->ID, WPGRADE_PREFIX.'video_embed', true);
	if( !empty( $video_embed ) ) {
		echo '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
	} else {
		wpGrade_video_selfhosted($post->ID);
	}
?>