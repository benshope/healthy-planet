<div class="featured-image-blog">
	<?php $audio_embed = get_post_meta($post->ID, WPGRADE_PREFIX.'audio_embed', true);
	if( !empty( $audio_embed ) ) {
		echo '<div class="audio-wrap">' . stripslashes(htmlspecialchars_decode($audio_embed)) . '</div>';
	} else {
		wpGrade_audio_selfhosted($post->ID); 
	} ?>
</div>