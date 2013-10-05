<div class="featured-image-blog">
	<?php $video_embed = get_post_meta($post->ID, WPGRADE_PREFIX.'video_embed', true);
	if( !empty( $video_embed ) ) {
		echo '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
	} else {
		wpGrade_video_selfhosted($post->ID);
	} ?>
</div>