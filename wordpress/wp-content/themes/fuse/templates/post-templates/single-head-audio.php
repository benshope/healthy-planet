<?php 
	global $post;
	$html_title = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'post_html_title', true);
?>

<div class="page-header-video-wrap">
	<?php 
	$audio_embed = get_post_meta($post->ID, WPGRADE_PREFIX.'audio_embed', true);
	if( !empty( $audio_embed ) ) {
		echo '<div class="audio-wrap">' . stripslashes(htmlspecialchars_decode($audio_embed)) . '</div>';
	} else {
		wpGrade_audio_selfhosted($post->ID); 
	} ?>
</div>
<div class="page-header-videohtml-wrap">
	<?php if (!empty($html_title)) { wpgrade_display_content($html_title); } ?>
</div>